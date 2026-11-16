import { Link } from "@inertiajs/react";
import { Container } from "./Container";
import type { Chrome } from "@/types";

/**
 * Footer. Link groups come from lang/{locale}/site.php under
 * `footer.links.{group}` and are resolved against the page registry paths, so a
 * renamed page is a 404-free change in one place.
 */
export function Footer({ chrome, locale, year }: { chrome: Chrome; locale: string; year: number }) {
  const groups: { key: string; title: string }[] = [
    { key: "company_section", title: chrome.footer.company },
    { key: "resources_section", title: chrome.footer.resources },
  ];

  // Footer link keys are page-registry keys, and every one of them has a path
  // equal to its key, so the href is a direct mapping.
  const pathFor = (key: string) => (key === "home" ? `/${locale}` : `/${locale}/${key}`);

  return (
    <footer className="bg-footer text-white">
      <Container className="grid gap-14 py-20 lg:grid-cols-[1.5fr_1fr_1fr]">
        <div>
          <Link href={`/${locale}`} className="inline-flex" aria-label={chrome.brand.company}>
            <img
              src="/images/logo.jpg"
              alt={chrome.brand.company}
              className="h-20 w-20 object-contain"
            />
          </Link>

          <p className="mt-6 max-w-sm text-sm leading-6 text-white/50">{chrome.footer.blurb}</p>
        </div>

        {groups.map((group) => (
          <div key={group.key}>
            <h2 className="text-sm font-semibold">{group.title}</h2>
            <ul className="mt-5 space-y-3">
              {Object.entries(chrome.footer.links[group.key] ?? {}).map(([key, label]) => (
                <li key={key}>
                  <Link
                    href={pathFor(key)}
                    className="text-sm text-white/50 transition-colors hover:text-white"
                  >
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        ))}
      </Container>

      <Container className="flex flex-col justify-between gap-4 border-t border-white/10 py-7 text-xs text-white/40 md:flex-row">
        <p>
          © {year} {chrome.brand.company}. {chrome.footer.rights}
        </p>
        <div className="flex gap-6">
          <Link href={`/${locale}/privacy`} className="transition-colors hover:text-white/70">
            {chrome.footer.privacy}
          </Link>
          <Link href={`/${locale}/terms`} className="transition-colors hover:text-white/70">
            {chrome.footer.terms}
          </Link>
        </div>
      </Container>
    </footer>
  );
}
