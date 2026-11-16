#!/usr/bin/env python3
"""
Minimal SMTP sink for verifying inquiry delivery.

Why this exists: the site's contact flow has only ever been tested with the
`log` mailer, which writes the message to storage/logs and proves nothing about
SMTP. "The inquiry persisted" and "the mail was delivered" are different claims,
and only the first one was ever checked.

This speaks enough SMTP for Laravel's Symfony mailer to complete a real
transaction: greeting, EHLO, AUTH, MAIL FROM, RCPT TO, DATA, QUIT. It writes each
accepted message to a directory as a .eml file so the test can assert on what
actually arrived on the wire.

It is a test double, not a mail server. No TLS, no relay, no delivery. It binds
to loopback only.

Failure injection: send `MAIL_FROM_FAIL=1` and it rejects RCPT TO with 550, which
is how a provider rejects an unknown recipient. That exercises the "provider
refused it" path rather than a crash.

    python3 tools/smtp_sink.py --port 2526 --outdir /tmp/smtp-capture
"""
import argparse
import os
import socket
import threading
import time
from pathlib import Path

ACCEPTED = []
LOCK = threading.Lock()


class Sink:
    def __init__(self, outdir: Path, fail_recipients: bool):
        self.outdir = outdir
        self.fail_recipients = fail_recipients
        self.counter = 0
        self.outdir.mkdir(parents=True, exist_ok=True)

    def handle(self, conn: socket.socket, addr):
        conn.settimeout(20)
        f = conn.makefile("rwb", buffering=0)

        def send(line: str):
            f.write((line + "\r\n").encode())

        def read() -> str:
            return f.readline().decode(errors="replace").rstrip("\r\n")

        send("220 sink.local ESMTP ready")

        from_addr = ""
        rcpts = []

        try:
            while True:
                line = read()
                if not line:
                    break

                verb = line.split(" ", 1)[0].upper()

                if verb == "EHLO":
                    send("250-sink.local")
                    send("250-AUTH PLAIN LOGIN")
                    send("250 SIZE 52428800")
                elif verb == "HELO":
                    send("250 sink.local")
                elif verb == "AUTH":
                    send("235 2.7.0 Authentication successful")
                    # AUTH PLAIN sends the payload on the same line; LOGIN is a
                    # challenge/response. Either way one 235 is enough for the
                    # client to proceed.
                elif verb == "MAIL":
                    from_addr = line
                    send("250 2.1.0 Sender OK")
                elif verb == "RCPT":
                    if self.fail_recipients:
                        send("550 5.1.1 No such user here")
                    else:
                        rcpts.append(line)
                        send("250 2.1.5 Recipient OK")
                elif verb == "DATA":
                    send("354 End data with <CR><LF>.<CR><LF>")
                    body = []
                    while True:
                        data_line = read()
                        if data_line == ".":
                            break
                        if data_line == "":
                            break
                        # Undo dot-stuffing so the captured file is the real body.
                        body.append(data_line[1:] if data_line.startswith("..") else data_line)

                    with LOCK:
                        self.counter += 1
                        n = self.counter

                    path = self.outdir / f"message-{n:03d}.eml"
                    path.write_text(
                        f"X-Sink-From: {from_addr}\n"
                        f"X-Sink-Rcpt: {'; '.join(rcpts)}\n"
                        + "\n".join(body),
                        encoding="utf-8",
                    )

                    with LOCK:
                        ACCEPTED.append(
                            {"n": n, "from": from_addr, "rcpts": list(rcpts), "path": str(path), "ts": time.time()}
                        )

                    send("250 2.0.0 Message accepted for delivery")
                    rcpts = []
                elif verb == "QUIT":
                    send("221 2.0.0 Bye")
                    break
                elif verb == "RSET":
                    from_addr, rcpts = "", []
                    send("250 2.0.0 Reset")
                elif verb == "NOOP":
                    send("250 2.0.0 OK")
                else:
                    send("250 2.0.0 OK")
        except (socket.timeout, OSError):
            pass
        finally:
            try:
                f.close()
            except OSError:
                pass
            conn.close()


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--port", type=int, default=2526)
    ap.add_argument("--outdir", default="/tmp/smtp-capture")
    ap.add_argument("--fail-recipients", action="store_true")
    args = ap.parse_args()

    sink = Sink(Path(args.outdir), args.fail_recipients or os.environ.get("MAIL_FROM_FAIL") == "1")

    srv = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    srv.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    srv.bind(("127.0.0.1", args.port))
    srv.listen(32)

    print(f"smtp sink listening on 127.0.0.1:{args.port} -> {args.outdir}", flush=True)
    if sink.fail_recipients:
        print("mode: rejecting all recipients with 550", flush=True)

    threads = []
    try:
        while True:
            conn, addr = srv.accept()
            t = threading.Thread(target=sink.handle, args=(conn, addr), daemon=True)
            t.start()
            threads.append(t)
    except KeyboardInterrupt:
        pass
    finally:
        srv.close()


if __name__ == "__main__":
    main()
