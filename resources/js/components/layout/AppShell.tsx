import type { ReactNode } from "react";
import { usePage } from "@inertiajs/react";
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
    </>
  );
}
