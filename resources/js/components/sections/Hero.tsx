import { Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { ArrowUpRight, ArrowDown, Pause, Play } from "lucide-react";
import { Container } from "../layout/Container";
import type { Hero as HeroContent } from "@/types";

/**
 * Page hero.
 *
 * The homepage hero carries the company profile video; every other page uses the
 * static variant. The video is muted, looping and has a poster, so it never
 * blocks first paint or autoplays with sound.
 *
 * WCAG 2.2.2 (Pause, Stop, Hide) is Level A and applies to any motion that
 * starts automatically and runs for more than five seconds. A decorative
 * aria-hidden video is not exempt: the requirement is about the visitor's
 * ability to stop movement, not about whether a screen reader describes it. So
 * the video gets a real pause control, and it starts paused when the visitor
 * has asked for reduced motion.
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
  ctaLabels: { quote: string; capabilities: string; pauseVideo?: string; playVideo?: string };
  breadcrumbs?: { label: string; url: string }[];
  breadcrumbLabel?: string;
  variant?: "home" | "page";
}) {
  const isHome = variant === "home";
  const videoRef = useRef<HTMLVideoElement | null>(null);
  const [playing, setPlaying] = useState(false);

  // Respect the reduced-motion preference on mount: if the visitor asked for
  // less motion, the hero should not be the one thing that ignores them. The
  // CSS media query cannot reach this, because autoplay is a media element
  // behaviour rather than a style.
  useEffect(() => {
    const el = videoRef.current;
    if (!el) return;

    const motionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");

    const apply = () => {
      if (motionQuery.matches) {
        el.pause();
        setPlaying(false);
      } else {
        void el.play().then(() => setPlaying(true)).catch(() => setPlaying(false));
      }
    };

    apply();
    motionQuery.addEventListener("change", apply);

    return () => motionQuery.removeEventListener("change", apply);
  }, []);

  const toggle = () => {
    const el = videoRef.current;
    if (!el) return;

    if (el.paused) {
      void el.play().then(() => setPlaying(true)).catch(() => setPlaying(false));
    } else {
      el.pause();
      setPlaying(false);
    }
  };

  return (
    <section className="relative isolate overflow-hidden bg-ink text-white">
      {isHome && hero.video ? (
        <>
          <video
            ref={videoRef}
            className="absolute inset-0 -z-10 h-full w-full object-cover opacity-45"
            poster={hero.poster}
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

          <button
            type="button"
            onClick={toggle}
            aria-label={playing ? ctaLabels.pauseVideo : ctaLabels.playVideo}
            aria-pressed={!playing}
            className="absolute bottom-6 right-6 z-20 flex h-11 w-11 items-center justify-center border border-white/25 bg-ink/70 text-white backdrop-blur transition-colors hover:border-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
          >
            {playing ? <Pause size={16} aria-hidden="true" /> : <Play size={16} aria-hidden="true" />}
          </button>
        </>
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
          <p className="text-xs font-semibold uppercase tracking-[0.22em] text-red-on-dark">{hero.eyebrow}</p>
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
