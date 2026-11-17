import { Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
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
  const [scrolled, setScrolled] = useState(false);
  const panelRef = useRef<HTMLDivElement | null>(null);
  const toggleRef = useRef<HTMLButtonElement | null>(null);

  useEffect(() => {
    if (!open) return;

    const onKey = (event: KeyboardEvent) => {
      if (event.key === "Escape") setOpen(false);

      if (event.key !== "Tab") return;

      // Trap Tab inside the panel. aria-modal="true" tells a screen reader that
      // nothing outside the dialog is reachable; leaving Tab free to walk into
      // the page behind the overlay makes that a lie, and a sighted keyboard user
      // ends up tabbing through content they cannot see. The panel is the only
      // focusable region, so wrap at both ends.
      const panel = panelRef.current;
      if (!panel) return;

      const focusable = panel.querySelectorAll<HTMLElement>(
        'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])',
      );
      if (focusable.length === 0) return;

      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      const active = document.activeElement as HTMLElement | null;

      // Focus on the panel container itself (where we put it on open) counts as
      // "before the first item", so Shift+Tab from there goes to the end.
      if (event.shiftKey && (active === first || active === panel)) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && active === last) {
        event.preventDefault();
        first.focus();
      }
    };

    const previous = document.body.style.overflow;
    document.body.style.overflow = "hidden";
    document.addEventListener("keydown", onKey);

    return () => {
      document.body.style.overflow = previous;
      document.removeEventListener("keydown", onKey);
    };
  }, [open]);

  // Move focus into the panel when it opens and return it to the toggle when it
  // closes. The panel covers the viewport and locks background scroll, so it
  // behaves modally; without this a keyboard user tabbing forward walks the page
  // behind the panel they cannot see, and on close is dumped at the top of the
  // document instead of where they left off.
  //
  // The return trip is keyed off "was open" rather than off where focus sits at
  // close time: hiding an element blurs whatever is inside it, so by the time
  // this runs the focused node is already the body and contains() says no.
  const wasOpen = useRef(false);

  useEffect(() => {
    if (open) {
      panelRef.current?.focus();
    } else if (wasOpen.current) {
      toggleRef.current?.focus();
    }

    wasOpen.current = open;
  }, [open]);

  useEffect(() => {
    const mq = window.matchMedia("(min-width: 1024px)");
    const onChange = (event: MediaQueryListEvent) => {
      if (event.matches) setOpen(false);
    };

    mq.addEventListener("change", onChange);
    return () => mq.removeEventListener("change", onChange);
  }, []);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  const contactHref = `/${locale}/contact`;

  return (
    <header
      className={cn(
        "sticky top-0 z-50 border-b border-white/10 bg-ink/95 backdrop-blur-xl transition-shadow duration-300",
        scrolled && "shadow-lg shadow-black/20",
      )}
    >
      <Container as="div">
        <div className="flex h-20 items-center justify-between gap-6">
          <Link
            href={`/${locale}`}
            onClick={() => setOpen(false)}
            className="group text-2xl font-black tracking-tight text-white"
            aria-label={`${chrome.brand.company} — ${chrome.brand.short}`}
          >
            <img
              src="/images/logo.png"
              alt={chrome.brand.company}
              className="h-14 w-14 object-contain transition-transform duration-300 group-hover:scale-105"
            />
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
              unavailableLabel={chrome.language.unavailable}
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
              ref={toggleRef}
              type="button"
              onClick={() => setOpen((prev) => !prev)}
              aria-label={open ? chrome.aria.close : chrome.aria.open}
              aria-expanded={open}
              aria-controls="mobile-menu"
              className="flex h-10 w-10 items-center justify-center text-white transition-colors hover:text-red lg:hidden"
            >
              {open ? <X size={26} aria-hidden="true" /> : <Menu size={26} aria-hidden="true" />}
            </button>
          </div>
        </div>
      </Container>

      {/* Mobile panel. Kept mounted so aria-controls always resolves. */}
      <div
        ref={panelRef}
        id="mobile-menu"
        hidden={!open}
        tabIndex={-1}
        role="dialog"
        aria-modal={open ? "true" : undefined}
        aria-label={chrome.aria.primary}
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
