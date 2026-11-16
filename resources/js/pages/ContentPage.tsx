import { usePage } from "@inertiajs/react";
import { AppShell } from "@/components/layout/AppShell";
import { PageHead } from "@/components/layout/PageHead";
import { Hero } from "@/components/sections/Hero";
import { SectionRenderer } from "@/components/sections/SectionRenderer";
import type { PageProps } from "@/types";

/**
 * Every registry page except contact renders through here: hero plus whatever
 * sections its lang file declares. Page copy is data, not a component, so 24 of
 * the 25 pages share this one renderer.
 */
export default function ContentPage() {
  const { content, locale, chrome, breadcrumbs, seo, htmlLang, pageKey } = usePage<PageProps>().props;

  const cta = {
    title: chrome.ctaBlock.title,
    lead: chrome.ctaBlock.lead,
    label: chrome.cta.team,
  };

  return (
    <AppShell>
      <PageHead seo={seo} htmlLang={htmlLang} />

      <Hero
        hero={content.hero}
        locale={locale}
        ctaLabels={{
          quote: chrome.cta.quote,
          capabilities: chrome.cta.capabilities,
          pauseVideo: chrome.aria.pause_video,
          playVideo: chrome.aria.play_video,
        }}
        breadcrumbs={breadcrumbs}
        breadcrumbLabel={chrome.aria.breadcrumb}
        variant={pageKey === "home" ? "home" : "page"}
      />

      <SectionRenderer
        sections={content.sections}
        content={content}
        locale={locale}
        cta={cta}
      />
    </AppShell>
  );
}
