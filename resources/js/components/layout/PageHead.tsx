import { Head } from "@inertiajs/react";
import type { Seo } from "@/types";

/**
 * Document head for every page: title, description, canonical, hreflang
 * alternates, Open Graph, and the Organization JSON-LD.
 *
 * hreflang is emitted for all three locales, matching Locales::alternates() —
 * the same list the sitemap uses, so the two cannot disagree.
 */
export function PageHead({ seo, htmlLang }: { seo: Seo; htmlLang: string }) {
  return (
    <Head>
      <title>{seo.title}</title>
      <meta name="description" content={seo.description} />
      <link rel="canonical" href={seo.canonical} />

      {seo.alternates.map((alt) => (
        <link key={alt.code} rel="alternate" hrefLang={alt.htmlLang} href={alt.url} />
      ))}
      <link rel="alternate" hrefLang="x-default" href={seo.xDefault} />

      <meta property="og:type" content={seo.og.type} />
      <meta property="og:site_name" content={seo.og.site_name} />
      <meta property="og:title" content={seo.title} />
      <meta property="og:description" content={seo.description} />
      <meta property="og:url" content={seo.og.url} />
      <meta property="og:image" content={seo.og.image} />
      <meta property="og:locale" content={htmlLang.replace("-", "_")} />

      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content={seo.title} />
      <meta name="twitter:description" content={seo.description} />
      <meta name="twitter:image" content={seo.og.image} />

      <script
        type="application/ld+json"
        // The payload is generated server-side from translated content and is
        // JSON-encoded before it reaches here; there is no user input in it.
        dangerouslySetInnerHTML={{ __html: JSON.stringify(seo.jsonLd) }}
      />
    </Head>
  );
}
