import { useEffect, useState, type ReactNode } from "react";
import { usePage } from "@inertiajs/react";
import { ArrowUp } from "lucide-react";
import { Header } from "./Header";
import { Footer } from "./Footer";
import type { PageProps } from "@/types";

/**
 * The persistent shell: skip link, header, main landmark, footer.
 *
 * Inertia keeps this mounted across visits, so navigation does not re-render the
 * chrome (ENG-001 §1.1 — the reference duplicated Navbar/Footer into all 10
 * pages).
 */
export function AppShell({ children }: { children: ReactNode }) {
  const { chrome, locale, pageKey } = usePage<PageProps>().props;
  const year = new Date().getFullYear();
  const [showBackToTop, setShowBackToTop] = useState(false);

  useEffect(() => {
    const onScroll = () => setShowBackToTop(window.scrollY > 560);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <>
      <a
        href="#main"
        className="sr-only sr-only-focusable z-[100] bg-red px-5 py-3 text-sm font-semibold text-white"
      >
        {chrome.aria.skip}
      </a>

      <Header chrome={chrome} activeKey={pageKey} locale={locale} />

      <main id="main">{children}</main>

      <Footer chrome={chrome} locale={locale} year={year} />

      {showBackToTop ? (
        <button
          type="button"
          onClick={() => window.scrollTo({ top: 0, behavior: "smooth" })}
          aria-label="Back to top"
          className="fixed bottom-5 right-5 z-40 flex h-11 w-11 items-center justify-center border border-ink/15 bg-white/95 text-ink shadow-lg backdrop-blur transition-[transform,background-color,color] duration-300 hover:-translate-y-1 hover:bg-red hover:text-white sm:bottom-7 sm:right-7"
        >
          <ArrowUp size={18} aria-hidden="true" />
        </button>
      ) : null}
    </>
  );
}
