import { EngineeringRuler } from "@/components/layout/EngineeringRuler";
import { Link, usePage } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight, Menu, X } from "lucide-react";
import { useEffect, useState, type ReactNode } from "react";
import type { PageProps } from "@/types";

const siteLink = (locale: string, path: string) => "/" + locale + (path ? "/" + path : "");

export function MockupShell({ active, children }: { active: string; children: ReactNode }) {
  const { chrome, locale, content } = usePage<PageProps>().props;
  const [mobileOpen, setMobileOpen] = useState(false);
  const contact = content.blocks.contact;

  useEffect(() => {
    setMobileOpen(false);
  }, [locale, active]);

  useEffect(() => {
    if (!mobileOpen) return;
    const onEscape = (event: KeyboardEvent) => {
      if (event.key === "Escape") setMobileOpen(false);
    };
    document.addEventListener("keydown", onEscape);
    return () => document.removeEventListener("keydown", onEscape);
  }, [mobileOpen]);

  return (
    <div className="umi-mockup min-h-screen bg-white text-[#071522] antialiased">
      <a href="#main" className="sr-only sr-only-focusable fixed z-[100] bg-white px-5 py-3 text-[#071522]">Skip to content</a>
      <header className="sticky top-0 z-50 border-b border-[#dfe4e8] bg-white/95 shadow-sm backdrop-blur-xl">
        <EngineeringRuler variant={active === "contact" ? "contact" : "home"} height={active === "contact" ? 38 : 48} />
        <div className="mx-auto flex h-[78px] max-w-[1400px] items-center justify-between gap-4 px-5 sm:px-8 xl:px-10">
          <Link href={siteLink(locale, "")} className="flex shrink-0 items-center gap-2.5" aria-label={chrome.brand.company + " homepage"}>
            <img src="/images/logo.png" alt="UMI" className="h-12 w-12 object-contain lg:h-14 lg:w-14" />
            <span className="max-w-40 text-[10px] font-black uppercase leading-[1.18] tracking-[-0.02em] lg:text-xs">PT. UNI-METALTECH<br />INDUSTRY (UMI)</span>
          </Link>
          <nav className="hidden items-center gap-5 xl:flex" aria-label={chrome.aria.primary}>
            {chrome.nav.map((item) => (
              <Link key={item.key} href={siteLink(locale, item.path)}
                aria-current={active === item.key ? "page" : undefined}
                className={"umi-nav-link relative whitespace-nowrap py-7 text-xs font-bold transition-colors hover:text-[#d71920] 2xl:text-sm " +
                  (active === item.key ? "text-[#d71920] after:absolute after:bottom-0 after:left-0 after:h-1 after:w-full after:bg-[#d71920]" : "text-[#071522]")}>
                {item.label}
              </Link>
            ))}
          </nav>
          <div className="flex items-center gap-3 md:gap-5">
            <nav className="hidden items-center gap-1.5 text-[11px] font-bold sm:flex" aria-label={chrome.aria.language}>
              {chrome.languages.map((language, index) => (
                <span key={language.code} className="flex items-center gap-1.5">
                  {index > 0 && <span aria-hidden="true" className="text-[#a6acb4]">/</span>}
                  {language.available
                    ? <Link lang={language.htmlLang} href={language.url}
                        aria-current={language.current ? "page" : undefined}
                        className={language.current ? "text-[#d71920]" : "text-[#586575] hover:text-[#d71920]"}>{language.code.toUpperCase()}</Link>
                    : <span title={chrome.language.unavailable} aria-disabled="true" className="text-[#a6acb4]">{language.code.toUpperCase()}</span>}
                </span>
              ))}
            </nav>
            <Link href={siteLink(locale, "contact")} className="umi-btn-red hidden shrink-0 items-center gap-2 rounded bg-[#d71920] px-4 py-3 text-xs font-bold text-white transition-colors hover:bg-[#b9151b] lg:flex">
              {chrome.cta.quote}<ArrowUpRight size={15} aria-hidden="true" />
            </Link>
            <button type="button" className="umi-menu-toggle flex h-11 w-11 items-center justify-center text-[#071522] xl:hidden"
              aria-label={mobileOpen ? chrome.aria.close : chrome.aria.open} aria-controls="umi-mobile-nav"
              aria-expanded={mobileOpen} onClick={() => setMobileOpen(!mobileOpen)}>
              {mobileOpen ? <X size={26} /> : <Menu size={26} />}
            </button>
          </div>
        </div>
        <nav id="umi-mobile-nav" aria-label="Mobile navigation"
          aria-hidden={!mobileOpen} inert={!mobileOpen}
          data-open={mobileOpen ? "true" : "false"}
          className={"umi-mobile-drawer border-t border-[#e3e8ec] bg-white xl:hidden " + (mobileOpen ? "is-open" : "")}>
          <div className="umi-mobile-drawer-inner mx-auto flex max-w-[1400px] flex-col px-6 py-5">
            {chrome.nav.map(item => <Link key={item.key} href={siteLink(locale, item.path)} onClick={() => setMobileOpen(false)}
              aria-current={active === item.key ? "page" : undefined}
              className="flex items-center justify-between border-b border-[#edf0f2] py-3 text-sm font-semibold">
              {item.label}<ArrowUpRight size={16} className="text-[#d71920]" />
            </Link>)}
            <div className="mt-4 flex items-center gap-4">
              {chrome.languages.filter(language => language.available).map(language =>
                <Link key={language.code} href={language.url} onClick={() => setMobileOpen(false)}
                  className={language.current ? "text-sm font-bold text-[#d71920]" : "text-sm font-medium text-[#506070]"}>{language.code.toUpperCase()}</Link>)}
            </div>
          </div>
        </nav>
      </header>
      <main id="main">{children}</main>
      <footer className="bg-[#f8fafb]">
        <div className="mx-auto grid max-w-[1400px] gap-7 px-5 py-9 sm:px-8 md:grid-cols-2 xl:grid-cols-4 xl:px-10">
          <div className="flex items-start gap-3"><img src="/images/logo.png" alt="" className="h-14 w-14 object-contain" />
            <b className="pt-2 text-xs font-black leading-4">PT. UNI-METALTECH<br/>INDUSTRY (UMI)</b></div>
          <div><h2 className="text-sm font-bold">{locale === "id" ? "Pabrik Batam" : locale === "zh" ? "巴淡工厂" : "Batam Factory"}</h2>
            <p className="mt-2 text-xs leading-5 text-[#506070]">{contact.batam.lines.join(", ")}</p></div>
          <div><h2 className="text-sm font-bold">{locale === "id" ? "Hubungi Kami" : locale === "zh" ? "联系方式" : "Contact"}</h2>
            <a href={"tel:" + contact.phone.replace(/\s/g,"")} className="mt-2 block text-xs leading-5 text-[#506070] hover:text-[#d71920]">{contact.phone}</a>
            <a href={"mailto:" + contact.email} className="mt-1 block break-all text-xs leading-5 text-[#506070] hover:text-[#d71920]">{contact.email}</a></div>
          <div><h2 className="text-sm font-bold">Quick Links</h2><div className="mt-2 grid grid-cols-2 gap-1.5">
            {chrome.nav.map(item => <Link key={item.key} href={siteLink(locale, item.path)} className="text-xs text-[#506070] hover:text-[#d71920]">{item.label}</Link>)}
          </div></div>
        </div>
        <div className="mx-auto flex max-w-[1400px] flex-col justify-between gap-4 border-t border-[#dce3e7] px-5 py-3 text-xs text-[#637081] sm:px-8 md:flex-row xl:px-10">
          <span>© 2000–{new Date().getFullYear()} PT. Uni-Metaltech Industry. {chrome.footer.rights}</span>
          <div className="flex gap-5"><Link href={siteLink(locale, "privacy")}>{chrome.footer.privacy}</Link><Link href={siteLink(locale, "terms")}>{chrome.footer.terms}</Link></div>
        </div>
      </footer>
    </div>
  );
}
