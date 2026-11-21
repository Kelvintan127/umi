import { Link } from "@inertiajs/react";
import { ArrowUpRight, ChevronRight } from "lucide-react";
import type { Breadcrumb, Hero as HeroContent, Locale } from "@/types";

/**
 * A single industrial editorial hero for every interior route. Unlike the
 * homepage's media hero, this hero intentionally uses no heavy video or fake
 * product imagery. The geometric drafting plate echoes the approved Contact
 * page without inventing machinery or specifications.
 */
export function InteriorHero({
  hero, locale, pageKey, breadcrumbs, breadcrumbLabel, ctaLabel,
}: {
  hero: HeroContent;
  locale: Locale;
  pageKey: string;
  breadcrumbs: Breadcrumb[];
  breadcrumbLabel: string;
  ctaLabel: string;
}) {
  const group = pageKey.split(".")[0];
  const pageIndex = ({
    about: "01", capabilities: "02", products: "03", facilities: "04",
    quality: "05", certifications: "05", policy: "06", gallery: "07",
    industries: "08", news: "09", privacy: "10", terms: "11",
    "metal-part-users": "12",
  } as Record<string, string>)[group] ?? "00";

  return (
    <section className="umi-interior-hero umi-hero umi-blueprint-lines relative isolate overflow-hidden bg-[#071522] text-white">
      <div aria-hidden="true" className="pointer-events-none absolute inset-0 bg-[linear-gradient(105deg,rgba(7,21,34,.96)_0%,rgba(9,32,48,.88)_65%,rgba(7,21,34,.75)_100%)]" />
      <div className="relative mx-auto grid max-w-[1400px] items-center gap-8 px-5 py-10 sm:px-8 md:grid-cols-[1.12fr_.88fr] md:py-14 xl:px-10">
        <div className="relative z-10 min-w-0">
          {breadcrumbs?.length > 0 && (
            <nav aria-label={breadcrumbLabel} className="mb-7">
              <ol className="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-semibold text-white/65">
                {breadcrumbs.map((crumb, index) => (
                  <li key={index} className="flex items-center gap-2">
                    {index > 0 && <ChevronRight size={12} aria-hidden="true" className="text-white/45" />}
                    {index === breadcrumbs.length-1
                      ? <span aria-current="page" className="text-white">{crumb.label}</span>
                      : <Link href={crumb.url} className="transition-colors hover:text-white">{crumb.label}</Link>}
                  </li>
                ))}
              </ol>
            </nav>
          )}
          <p className="mb-4 text-xs font-extrabold uppercase tracking-[.18em] text-[#f44a53]">
            {hero.eyebrow ?? pageKey.replaceAll(".", " / ")}
          </p>
          {hero.title && <h1 className="umi-interior-hero-title max-w-[760px] text-[clamp(2.75rem,4.7vw,5.25rem)] font-black leading-[.99] tracking-[-.058em]">{hero.title}</h1>}
          {hero.lead && <p className="umi-interior-hero-lead mt-6 max-w-2xl text-[clamp(.98rem,1.3vw,1.18rem)] font-medium leading-[1.6] text-[#dee7ef]">{hero.lead}</p>}
          <div className="mt-7 flex flex-wrap items-center gap-5">
            <Link href={"/"+locale+"/contact"}
              className="umi-btn-red inline-flex items-center gap-2 rounded px-5 py-3 text-sm font-extrabold text-white">
              {ctaLabel}<ArrowUpRight size={16} aria-hidden="true"/>
            </Link>
            <span className="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[.13em] text-white/65">
              <span aria-hidden="true" className="h-px w-7 bg-[#e94b51]"/>
              PT. UNI METALTECH INDUSTRY
            </span>
          </div>
        </div>

        <div className="umi-interior-hero-plate relative hidden min-h-[280px] items-center justify-center md:flex lg:min-h-[350px]" aria-hidden="true">
          <div className="absolute inset-[7%] border border-dashed border-white/20" />
          <div className="absolute inset-[13%] border border-white/10" />
          <svg viewBox="0 0 480 300" className="relative h-full w-full max-w-[500px] text-white/65"
            fill="none" stroke="currentColor" strokeWidth="1.5">
            <path opacity=".5" d="M45 72H435V245H45z M45 105H435 M45 210H435" strokeDasharray="5 8"/>
            <path d="M132 104L188 49H296L354 104V212L296 253H188L132 212Z" strokeWidth="2.2"/>
            <path d="M165 115V198L203 225H282L322 198V115L282 82H203Z"/>
            <circle cx="243" cy="152" r="59" strokeWidth="2.5"/>
            <circle cx="243" cy="152" r="40"/>
            <circle cx="243" cy="152" r="8" fill="currentColor" fillOpacity=".18"/>
            <path opacity=".6" strokeDasharray="4 6" d="M243 12V287M12 152H468M132 104L322 198M354 104L165 198"/>
            <path d="M132 50V29H354V50M132 29H354M375 105H400V212H375M120 104H90V212H120"/>
            <path opacity=".7" d="M207 60H278 M207 244H278 M64 152H110 M379 152H421"/>
            <g fill="currentColor" stroke="none" fontFamily="Inter,Arial,sans-serif" fontWeight="700" fontSize="12">
              <text x="212" y="21">R 24.50</text>
              <text x="401" y="166" transform="rotate(90 401 166)">± 0.10</text>
              <text x="69" y="67">UMI / {pageIndex}</text>
              <text x="319" y="274">DRAWING REF.</text>
            </g>
          </svg>
          <span className="absolute bottom-0 right-0 border-l border-[#e94b51] pl-3 text-[10px] font-extrabold uppercase tracking-widest text-[#f3636b]">
            {group.replaceAll("-", " ")} / {pageIndex}
          </span>
        </div>
      </div>
      <div className="absolute bottom-0 left-0 right-0 h-[3px] bg-[linear-gradient(90deg,#d71920_0%,#d71920_9%,rgba(255,255,255,.12)_9%,rgba(255,255,255,.12)_100%)]" aria-hidden="true"/>
    </section>
  );
}
