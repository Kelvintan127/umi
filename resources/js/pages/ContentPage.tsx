import { usePage } from "@inertiajs/react";
import { MockupShell } from "@/components/layout/MockupShell";
import { InteriorHero } from "@/components/sections/InteriorHero";
import { PageHead } from "@/components/layout/PageHead";
import { SectionRenderer } from "@/components/sections/SectionRenderer";
import type { PageProps } from "@/types";

/**
 * Home and Contact already use the approved UMI shell. All registry-driven
 * content pages now reuse it and one interior hero/section design system.
 * Existing page copy, SEO, locale gates and section routing remain intact.
 */
export default function ContentPage() {
  const { content, locale, chrome, breadcrumbs, seo, htmlLang, pageKey } = usePage<PageProps>().props;
  const active = pageKey.split(".")[0];

  return (
    <MockupShell active={active}>
      <PageHead seo={seo} htmlLang={htmlLang}/>
      <div className="umi-interior" data-page-key={pageKey}>
        <InteriorHero
          hero={content.hero}
          locale={locale}
          pageKey={pageKey}
          breadcrumbs={breadcrumbs}
          breadcrumbLabel={chrome.aria.breadcrumb}
          ctaLabel={chrome.cta.quote}
        />
        <SectionRenderer
          sections={content.sections}
          content={content}
          locale={locale}
          cta={{
            title: chrome.ctaBlock.title,
            lead: chrome.ctaBlock.lead,
            label: chrome.cta.team,
          }}
        />
      </div>
    </MockupShell>
  );
}
