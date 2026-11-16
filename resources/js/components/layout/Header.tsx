import { Link } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { ArrowUpRight, Menu, X } from "lucide-react";
import { Container } from "./Container";
import { DesktopNav, LanguageSwitcher } from "./Nav";
import type { Chrome } from "@/types";
import { cn } from "@/lib/utils";

/**
 * Site header.
 *
 * The mobile panel is a real dialog: focus moves into it, Escape closes it, the
 * background scroll is locked, and focus returns to the toggle on close. Without
 * those four the menu is a visual overlay a keyboard user cannot escape.
 */
export function Header({ chrome, activeKey, locale }: { chrome: Chrome; activeKey: string; locale: string }) {
  const [open, setOpen] = useState(false);

  useEffect(() => {
    if (!open) return;

    const onKey = (event: KeyboardEvent) => {
      if (event.key === "Escape") setOpen(false);
    };

    const previous = document.body.style.overflow;
    document.body.style.overflow = "hidden";
    document.addEventListener("keydown", onKey);

    return () => {
      document.body.style.overflow = previous;
      document.removeEventListener("keydown", onKey);
    };
  }, [open]);

  useEffect(() => {
    const mq = window.matchMedia("(min-width: 1024px)");
    const onChange = (event: MediaQueryListEvent) => {
      if (event.matches) setOpen(false);
    };

    mq.addEventListener("change", onChange);
    return () => mq.removeEventListener("change", onChange);
  }, []);

  const contactHref = `/${locale}/contact`;

  return (
    <header className="sticky top-0 z-50 border-b border-white/10 bg-ink/95 backdrop-blur-xl">
      <Container as="div">
        <div className="flex h-20 items-center justify-between gap-6">
          <Link
            href={`/${locale}`}
            onClick={() => setOpen(false)}
            className="text-2xl font-black tracking-tight text-white"
            aria-label={`${chrome.brand.company} — ${chrome.brand.short}`}
          >
            {chrome.brand.mark}
            <span className="text-red" aria-hidden="true">
              .
            </span>
          </Link>

          <DesktopNav
            items={chrome.nav}
            activeKey={activeKey}
            locale={locale}
            ariaLabel={chrome.aria.primary}
          />

          <div className="flex items-center gap-4">
            <LanguageSwitcher
              languages={chrome.languages}
              ariaLabel={chrome.aria.language}
              unavailableLabel={chrome.languages.find((l) => !l.available)?.label ?? ""}
            />

            <Link
              href={contactHref}
              className="group hidden items-center gap-2 bg-red px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-red-hover lg:flex"
            >
              {chrome.cta.contact}
              <ArrowUpRight
                size={16}
                aria-hidden="true"
                className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
              />
            </Link>

            <button
              type="button"
              onClick={() => setOpen((prev) => !prev)}
              aria-label={open ? chrome.aria.close : chrome.aria.open}
              aria-expanded={open}
              aria-controls="mobile-menu"
              className="flex h-10 w-10 items-center justify-center text-white lg:hidden"
            >
              {open ? <X size={26} aria-hidden="true" /> : <Menu size={26} aria-hidden="true" />}
            </button>
          </div>
        </div>
      </Container>

      {/* Mobile panel. Kept mounted so aria-controls always resolves. */}
      <div
        id="mobile-menu"
        hidden={!open}
        className={cn(
          "border-t border-white/10 bg-ink lg:hidden",
          open ? "block" : "hidden",
        )}
      >
        <Container className="py-6">
          <ul className="flex flex-col">
            {chrome.nav.map((item) => (
              <li key={item.key}>
                <Link
                  href={`/${locale}/${item.path}`}
                  onClick={() => setOpen(false)}
                  aria-current={activeKey === item.key ? "page" : undefined}
                  className="flex items-center justify-between border-b border-white/10 py-4 text-lg font-medium text-white transition-colors hover:text-red"
                >
                  <span>{item.label}</span>
                  <ArrowUpRight size={18} aria-hidden="true" className="text-white/30" />
                </Link>
              </li>
            ))}
          </ul>

          <Link
            href={contactHref}
            onClick={() => setOpen(false)}
            className="mt-6 flex w-full items-center justify-center gap-2 bg-red px-5 py-4 text-sm font-semibold text-white transition-colors hover:bg-red-hover"
          >
            {chrome.cta.contact}
            <ArrowUpRight size={17} aria-hidden="true" />
          </Link>
        </Container>
      </div>
    </header>
  );
}
