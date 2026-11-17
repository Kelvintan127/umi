import { Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { ChevronDown } from "lucide-react";
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
  const [open, setOpen] = useState(false);
  const menuRef = useRef<HTMLDivElement | null>(null);
  const triggerRef = useRef<HTMLButtonElement | null>(null);

  useEffect(() => {
    if (!open) return;

    const onPointerDown = (event: PointerEvent) => {
      if (!menuRef.current?.contains(event.target as Node)) setOpen(false);
    };
    const onKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Escape") {
        setOpen(false);
        triggerRef.current?.focus();
      }
    };

    document.addEventListener("pointerdown", onPointerDown);
    document.addEventListener("keydown", onKeyDown);
    return () => {
      document.removeEventListener("pointerdown", onPointerDown);
      document.removeEventListener("keydown", onKeyDown);
    };
  }, [open]);

  return (
    <div ref={menuRef} className="relative" aria-label={ariaLabel}>
      <button
        ref={triggerRef}
        type="button"
        aria-haspopup="menu"
        aria-expanded={open}
        onClick={() => setOpen((value) => !value)}
        className={cn(
          "group flex cursor-pointer list-none items-center justify-center gap-2 rounded-full text-xs font-semibold uppercase tracking-widest text-white transition-[background-color,color] duration-300 hover:bg-white/10 hover:text-white focus-visible:text-white",
          compact ? "px-2 py-1" : "px-2.5 py-1.5",
          open && "bg-white/10",
        )}
      >
        <span aria-hidden="true" className="text-base leading-none">
          {flags[current.code] ?? "🌐"}
        </span>
        <span>{current.code}</span>
        <span
          aria-hidden="true"
          className={cn(
            "flex h-5 w-5 items-center justify-center rounded-full border border-white/20 text-white/55 transition-[background-color,border-color,color,transform] duration-300 group-hover:border-white/45 group-hover:text-white",
            open && "rotate-180 border-red bg-red text-white",
          )}
        >
          <ChevronDown size={12} strokeWidth={2.5} />
        </span>
      </button>

      <div
        role="menu"
        aria-hidden={!open}
        className={cn(
          "absolute left-1/2 top-full z-50 mt-3 min-w-52 -translate-x-1/2 origin-top border border-white/15 bg-ink p-1.5 shadow-2xl shadow-black/30 transition-[opacity,transform,visibility] duration-200",
          open
            ? "visible scale-100 opacity-100"
            : "invisible pointer-events-none scale-95 opacity-0",
        )}
      >
        {languages.map((lang) => {
          const itemClass = cn(
            "flex w-full items-center gap-3 px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest transition-colors",
            lang.current
              ? "bg-white/10 text-white"
              : lang.available
                ? "text-white/65 hover:bg-white/10 hover:text-white"
                : "cursor-not-allowed text-white/25",
          );
          const content = (
            <>
              <span aria-hidden="true" className="text-base leading-none">
                {flags[lang.code] ?? "🌐"}
              </span>
              <span className="flex-1">
                <span className="block">{lang.code}</span>
                <span className="mt-0.5 block normal-case tracking-normal text-white/45">
                  {lang.available ? lang.label : unavailableLabel}
                </span>
              </span>
              {lang.current ? (
                <span
                  aria-hidden="true"
                  className="h-1.5 w-1.5 rounded-full bg-red shadow-[0_0_0_3px_rgba(215,25,32,0.15)]"
                />
              ) : null}
            </>
          );

          return lang.available ? (
            <Link
              key={lang.code}
              href={lang.url}
              lang={lang.htmlLang}
              hrefLang={lang.htmlLang}
              aria-current={lang.current ? "true" : undefined}
              role="menuitem"
              title={lang.label}
              onClick={() => setOpen(false)}
              className={itemClass}
            >
              {content}
            </Link>
          ) : (
            <span
              key={lang.code}
              lang={lang.htmlLang}
              aria-disabled="true"
              role="menuitem"
              title={`${lang.label} — ${unavailableLabel}`}
              className={itemClass}
            >
              {content}
            </span>
          );
        })}
      </div>
    </div>
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
