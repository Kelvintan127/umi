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
  return (
    <nav aria-label={ariaLabel} className="flex items-center gap-1">
      {languages.map((lang) => {
        const base = cn(
          "text-xs font-semibold uppercase tracking-widest transition-colors",
          compact ? "px-2 py-1" : "px-2.5 py-1.5",
        );

        if (lang.current) {
          return (
            <span
              key={lang.code}
              aria-current="true"
              lang={lang.htmlLang}
              className={cn(base, "text-white")}
            >
              {lang.code}
            </span>
          );
        }

        if (!lang.available) {
          return (
            <span
              key={lang.code}
              lang={lang.htmlLang}
              title={`${lang.label} — ${unavailableLabel}`}
              aria-label={`${lang.code} — ${unavailableLabel}`}
              aria-disabled="true"
              className={cn(base, "cursor-not-allowed text-white/25")}
            >
              {lang.code}
            </span>
          );
        }

        return (
          <Link
            key={lang.code}
            href={lang.url}
            lang={lang.htmlLang}
            hrefLang={lang.htmlLang}
            className={cn(base, "text-white/45 hover:text-white")}
          >
            {lang.code}
          </Link>
        );
      })}
    </nav>
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
