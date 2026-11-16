import { Link } from "@inertiajs/react";
import { ArrowUpRight, ArrowDown } from "lucide-react";
import { Container } from "../layout/Container";
import type { Hero as HeroContent } from "@/types";

/**
 * Page hero.
 *
 * The homepage hero carries the company profile video; every other page uses the
 * static variant. The video is muted, looping, playsInline and has a poster, so
 * it never blocks first paint or autoplays with sound.
 */
export function Hero({
  hero,
  locale,
  ctaLabels,
  breadcrumbs,
  breadcrumbLabel,
  variant = "page",
}: {
  hero: HeroContent;
  locale: string;
  ctaLabels: { quote: string; capabilities: string };
  breadcrumbs?: { label: string; url: string }[];
  breadcrumbLabel?: string;
  variant?: "home" | "page";
}) {
  const isHome = variant === "home";

  return (
    <section className="relative isolate overflow-hidden bg-ink text-white">
      {isHome && hero.video ? (
        <video
          className="absolute inset-0 -z-10 h-full w-full object-cover opacity-45"
          poster={hero.poster}
          autoPlay
          muted
          loop
          playsInline
          preload="metadata"
          aria-hidden="true"
          tabIndex={-1}
        >
          {hero.video_mobile ? (
            <source src={hero.video_mobile} type="video/mp4" media="(max-width: 767px)" />
          ) : null}
          <source src={hero.video} type="video/mp4" />
        </video>
      ) : null}

      {isHome ? (
        <div
          aria-hidden="true"
          className="absolute inset-0 -z-10 bg-gradient-to-r from-ink via-ink/85 to-ink/40"
        />
      ) : null}

      <Container className={isHome ? "py-32 md:py-44" : "py-24 md:py-32"}>
        {breadcrumbs && breadcrumbs.length > 0 ? (
          <nav aria-label={breadcrumbLabel ?? "Breadcrumb"} className="mb-8">
            <ol className="flex flex-wrap items-center gap-2 text-xs text-white/50">
              {breadcrumbs.map((crumb, index) => (
                <li key={crumb.url} className="flex items-center gap-2">
                  {index > 0 ? (
                    <span aria-hidden="true" className="text-white/25">
                      /
                    </span>
                  ) : null}
                  {index === breadcrumbs.length - 1 ? (
                    <span aria-current="page" className="text-white/80">
                      {crumb.label}
                    </span>
                  ) : (
                    <Link href={crumb.url} className="transition-colors hover:text-white">
                      {crumb.label}
                    </Link>
                  )}
                </li>
              ))}
            </ol>
          </nav>
        ) : null}

        {hero.eyebrow ? (
          <p className="text-xs font-semibold uppercase tracking-[0.22em] text-red">{hero.eyebrow}</p>
        ) : null}

        {hero.title ? (
          <h1
            className={
              isHome
                ? "mt-5 max-w-4xl text-4xl font-black leading-[1.02] tracking-tight sm:text-6xl lg:text-7xl"
                : "mt-5 max-w-4xl text-3xl font-black leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl"
            }
          >
            {hero.title}
          </h1>
        ) : null}

        {hero.lead ? (
          <p className="mt-7 max-w-2xl text-base leading-7 text-white/65 sm:text-lg sm:leading-8">
            {hero.lead}
          </p>
        ) : null}

        {hero.note ? (
          <p className="mt-6 max-w-2xl border-l-2 border-red pl-4 text-sm leading-6 text-white/55">
            {hero.note}
          </p>
        ) : null}

        {isHome ? (
          <div className="mt-10 flex flex-wrap items-center gap-4">
            <Link
              href={`/${locale}/contact`}
              className="group inline-flex items-center gap-2 bg-red px-7 py-4 text-sm font-semibold text-white transition-colors hover:bg-red-hover"
            >
              {ctaLabels.quote}
              <ArrowUpRight
                size={18}
                aria-hidden="true"
                className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
              />
            </Link>

            <Link
              href={`/${locale}/capabilities`}
              className="inline-flex items-center gap-2 border border-white/25 px-7 py-4 text-sm font-semibold text-white transition-colors hover:border-white/60"
            >
              {ctaLabels.capabilities}
            </Link>
          </div>
        ) : null}

        {isHome ? (
          <div className="mt-20 flex items-center gap-3 text-xs uppercase tracking-[0.2em] text-white/40">
            <ArrowDown size={14} aria-hidden="true" />
            <span>Scroll to explore</span>
          </div>
        ) : null}
      </Container>
    </section>
  );
}
