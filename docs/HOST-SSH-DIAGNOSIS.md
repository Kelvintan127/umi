# Host SSH Access — Diagnosis

Status: **BLOCKED**. This documents what is proven, what is not, and the exact
one-line fix on the host side. No authentication setting was weakened and no
private key was handled.

## The target

| | |
|---|---|
| Address | `10.0.2.1` (this container is `10.0.2.3` on the same network) |
| SSH daemon | OpenSSH 9.6p1 Ubuntu-3ubuntu13.20 |
| Host key (ED25519) | `SHA256:VVtc+5hTL+sdoZPyx3uLQLYiOoXcofKEZhWRmEcB88M` |
| Host key matches | `/opt/data/host-ssh/known_hosts` — consistent, no MITM sign |
| Auth methods offered | `publickey` only (no password fallback) |
| Other open ports | 80, 443, 3000, 8000 |

## The key

```
public:   ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIPza6q4wiTbTuPeYlnxpN0Enw15Ovl4BsgN0WgpZkYrK
comment:  hermes-host-access
fingerprint: SHA256:/mrAgrUVehN1to/jU3/gWpIfTDMoEr3/szM1a+LZCqk  (256-bit ED25519)
```

The public key is derived correctly from the private key (`ssh-keygen -y` output
matches the `.pub` file byte for byte). The key is not corrupt, not encrypted with
an unknown passphrase, and not mismatched.

## What the server says

```
$ ssh -v -o BatchMode=yes -o IdentitiesOnly=yes \
      -i /opt/data/host-ssh/id_ed25519 hermes@10.0.2.1 true

debug1: Remote protocol version 2.0, remote software version OpenSSH_9.6p1
debug1: Authentications that can continue: publickey
debug1: Offering public key: /opt/data/host-ssh/id_ed25519 ED25519 SHA256:/mrAgr...
debug1: Authentications that can continue: publickey
hermes@10.0.2.1: Permission denied (publickey).
```

## What this proves, and what it does not

**Proven:** the key reaches the server, the server evaluates it, and rejects it.
That is the signature of a key absent from that account's `authorized_keys`.

**Proven:** it is not a protocol problem (server and client both OpenSSH, ED25519
negotiated), and not a client config problem (`IdentitiesOnly=yes` rules out the
agent offering a wrong key first).

**Not proven:** that `/opt/data/host-ssh/id_ed25519.pub` was ever copied to the
host. Nothing in this container records that step having happened.

**Not determined:** the correct deployment account name. The key comment says
`hermes-host-access`, and `hermes` was tried and refused. The remaining candidate
is `umi` (matching the application and service naming used throughout
`docs/DEPLOYMENT.md`, e.g. `User=www-data` for the web user but `umi` for the
application tree). Attempting it without evidence is guessing, and repeated
failed auth is exactly what fail2ban is configured to catch — so it is left to
the operator to name the account rather than brute-forced here.

## The fix — host side, one command

On the host, as the deployment account:

```bash
install -d -m 700 ~/.ssh

cat >> ~/.ssh/authorized_keys <<'EOF'
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIPza6q4wiTbTuPeYlnxpN0Enw15Ovl4BsgN0WgpZkYrK hermes-host-access
EOF

chmod 600 ~/.ssh/authorized_keys
chmod go-w ~
```

Then confirm ownership and permissions, which are the usual second cause of
`Permission denied` even when the key is present:

```bash
ls -ld ~ ~/.ssh ~/.ssh/authorized_keys
# expect: drwx------ has to be 700-or-stricter on .ssh and no group/other write
```

Verify from this container:

```bash
ssh -i /opt/data/host-ssh/id_ed25519 <account>@10.0.2.1 'echo OK'
# expect: OK
```

If it still refuses with the key present, the server-side reason will be in the
host's `/var/log/auth.log`:

```bash
sudo tail -20 /var/log/auth.log | grep -i sshd
```

Look for `Authentication refused: bad ownership or modes` (permissions) versus
`Failed publickey ... ssh-ed25519 SHA256:/mrAgr...` (key genuinely not matched).

## What was deliberately not done

- No password authentication attempted, and none enabled.
- No `StrictHostKeyChecking=no` used against the real target after the first
  probe — the host key is pinned in `known_hosts`.
- No private key printed, copied, or transmitted. Only the public half appears
  above, and a public key is designed to be public.
- No brute force of account names beyond the one implied by the key comment.
- No sshd configuration change proposed — the daemon is already correct: it
  offers publickey only, which is the right posture.

## Consequence for staging

Host staging cannot proceed until this is resolved. The complete deployment
procedure, including independent database and `APP_KEY`, TLS, systemd unit for
the SSR renderer, health checks and rollback, is written and waiting in
`docs/PRODUCTION-HOST-PROCEDURE.md`. A verified container-local staging instance
at commit `9db8ee6` is running on `127.0.0.1:8941` and is documented in
`docs/STAGING.md`.

`umistamping.com` production has not been touched.
