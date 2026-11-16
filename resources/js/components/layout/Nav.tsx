import { Link } from "@inertiajs/react";
import type { LanguageOption, NavItem } from "@/types";
import { cn } from "@/lib/utils";

/**
 * Language switcher.
 *
 * A locale without signed-off copy for the current page is rendered as a
 * disabled control carrying its own language name plus the pending-sign-off
 * message, rather than as a link to a page that would silently serve English
 * under a foreign lang attribute. The switcher's `url` field still resolves to
 * the /en/ equivalent so the data is complete, but it is never rendered as an
 * href — linking a visitor to a URL that redirects them back is worse than
 * telling them the translation is not ready.
 */
export function LanguageSwitcher({
  languages,
  ariaLabel,
  unavailableLabel,
  compact = false,
}: {
  languages: LanguageOption[];
  ariaLabel: string;
  unavailableLabel: string;
  compact?: boolean;
}) {
  const current = languages.find((lang) => lang.current) ?? languages[0];
  const flags: Record<string, string> = { en: "🇬🇧", id: "🇮🇩", zh: "🇨🇳" };

  return (
    <details className="relative" aria-label={ariaLabel}>
      <summary
        className={cn(
          "flex cursor-pointer list-none items-center justify-center gap-2 text-xs font-semibold uppercase tracking-widest text-white [&::-webkit-details-marker]:hidden",
          compact ? "px-2 py-1" : "px-2.5 py-1.5",
        )}
      >
        <span aria-hidden="true" className="text-base leading-none">
          {flags[current.code] ?? "🌐"}
        </span>
        <span>{current.code}</span>
        <span aria-hidden="true" className="text-white/50">⌄</span>
      </summary>

      <div className="absolute left-1/2 top-full z-50 mt-2 min-w-40 -translate-x-1/2 border border-white/15 bg-ink p-1 shadow-xl">
        {languages.map((lang) => {
          const itemClass = cn(
            "flex items-center justify-center gap-3 px-3 py-2 text-xs font-semibold uppercase tracking-widest",
            lang.current
              ? "bg-white/10 text-white"
              : lang.available
                ? "text-white/65 transition-colors hover:bg-white/10 hover:text-white"
                : "cursor-not-allowed text-white/25",
          );
          const content = (
            <>
              <span aria-hidden="true" className="text-base leading-none">
                {flags[lang.code] ?? "🌐"}
              </span>
              <span>{lang.code}</span>
              <span className="normal-case tracking-normal text-white/45">
                {lang.available ? lang.label : unavailableLabel}
              </span>
            </>
          );

          return lang.available ? (
            <Link
              key={lang.code}
              href={lang.url}
              lang={lang.htmlLang}
              hrefLang={lang.htmlLang}
              aria-current={lang.current ? "true" : undefined}
              title={lang.label}
              className={itemClass}
            >
              {content}
            </Link>
          ) : (
            <span
              key={lang.code}
              lang={lang.htmlLang}
              aria-disabled="true"
              title={`${lang.label} — ${unavailableLabel}`}
              className={itemClass}
            >
              {content}
            </span>
          );
        })}
      </div>
    </details>
  );
}

/**
 * Desktop navigation. Active state comes from the page key Inertia gives us via
 * usePage(), passed down as `activeKey` so this stays presentational.
 */
export function DesktopNav({
  items,
  activeKey,
  locale,
  ariaLabel,
}: {
  items: NavItem[];
  activeKey: string;
  locale: string;
  ariaLabel: string;
}) {
  return (
    <ul aria-label={ariaLabel} className="hidden items-center gap-7 lg:flex">
      {items.map((item) => {
        const active = activeKey === item.key;
        return (
          <li key={item.key}>
            <Link
              href={`/${locale}/${item.path}`}
              aria-current={active ? "page" : undefined}
              className={cn(
                "relative text-sm font-medium transition-colors",
                active ? "text-white" : "text-white/70 hover:text-white",
              )}
            >
              {item.label}
              <span
                aria-hidden="true"
                className={cn(
                  "absolute -bottom-1.5 left-0 h-px w-full origin-left bg-red scale-x-0 transition-transform duration-300",
                  active && "scale-x-100",
                )}
              />
            </Link>
          </li>
        );
      })}
    </ul>
  );
}
