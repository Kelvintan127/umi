<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Builds the shared Inertia props for every page.
 *
 * Everything a page needs to render is resolved here in one place: the page
 * copy for the active locale (with the language policy already applied by
 * PageController), the site chrome (nav, footer, language options), SEO tags,
 * and breadcrumbs. Components stay presentational.
 */
final class PageProps
{
    /**
     * @return array<string, mixed>
     */
    public static function forPage(string $pageKey, string $locale, Request $request): array
    {
        $path = Pages::path($pageKey);

        return [
            'pageKey' => $pageKey,
            'locale' => $locale,
            'htmlLang' => Locales::htmlLang($locale),
            'dir' => 'ltr',
            'path' => $path,
            'content' => self::content($pageKey),
            'chrome' => self::chrome($locale, $pageKey, $path),
            'seo' => self::seo($pageKey, $locale, $path),
            'breadcrumbs' => self::breadcrumbs($pageKey, $locale),
            'site' => self::site($locale),
            'form' => FormLabels::for($locale),
        ];
    }

    /**
     * Page copy: page-specific hero + sections, plus the shared content blocks
     * a section may reference by key (cards/specs sources).
     *
     * @return array<string, mixed>
     */
    private static function content(string $pageKey): array
    {
        $page = Pages::copy($pageKey);

        return [
            'hero' => $page['hero'] ?? [],
            'sections' => $page['sections'] ?? [],
            'blocks' => [
                'capabilities' => trans('site.capabilities'),
                'industries' => trans('site.industries'),
                'products' => trans('site.products'),
                'facilities' => trans('site.facilities'),
                'certifications' => trans('site.certifications'),
                'quality' => trans('site.quality'),
                'process' => trans('site.process'),
                'stats' => trans('site.stats'),
                'policy' => trans('site.policy'),
                'gallery' => trans('site.gallery'),
                'news' => trans('site.news'),
                'users' => self::approvedUsers(),
                'contact' => trans('site.contact'),
            ],
        ];
    }

    /**
     * The metal-part-users block, with third-party names filtered through the
     * approval gate in config/approvals.php.
     *
     * Everything else in the block (intro, note) is UMI's own copy and renders
     * as written. The customer names and attributed quotes do not, because
     * naming a customer publicly needs that customer's permission and the old
     * site's publication is not that permission. When the approved list is
     * empty the section states that the list is available on request, which is
     * both true and better than a section that silently renders nothing.
     *
     * @return array<string, mixed>
     */
    private static function approvedUsers(): array
    {
        $block = (array) trans('site.metal_part_users');

        $customers = Approvals::customers();

        // The English source lists bare names; the config carries the direct /
        // indirect distinction. Where config is the emptier of the two, publish
        // nothing rather than fall back to the unfiltered list — failing open
        // here is the exact bug this gate exists to stop.
        $block['users'] = array_values(array_map(
            fn (array $row) => $row['name'],
            $customers
        ));

        // Split direct customers from end-product brands reached through a
        // contract manufacturer. Listing them together implies a commercial
        // relationship with the brand that UMI may not have.
        $block['direct'] = array_values(array_map(
            fn (array $row) => $row['name'],
            array_filter($customers, fn (array $row) => $row['relationship'] === 'direct')
        ));
        $block['indirect'] = array_values(array_map(
            fn (array $row) => $row['name'],
            array_filter($customers, fn (array $row) => $row['relationship'] !== 'direct')
        ));

        $block['testimonials'] = self::approvedTestimonials();

        // Only claim "available on request" when something is genuinely held
        // back. When nothing is withheld the note would be a false statement.
        $block['withheld'] = Approvals::hasWithheld('customers');
        $block['withheld_count'] = Approvals::withheldCount('customers');

        return $block;
    }

    /**
     * Approved testimonials, re-joined with their published quote text.
     *
     * The gate in Approvals decides which names may appear; the wording of each
     * quote lives with the other localised copy in the per-locale site.php, so it gets
     * translated with everything else. A name allowed through by the gate but
     * with no quote text available is dropped rather than rendered bare.
     *
     * @return list<array{name: string, period: string, quote: string}>
     */
    private static function approvedTestimonials(): array
    {
        $published = (array) trans('site.metal_part_users.testimonials', []);

        // trans() returns the key itself when the path is missing, so guard.
        if (! is_array($published)) {
            $published = [];
        }

        $quotes = [];

        foreach ($published as $row) {
            if (is_array($row) && isset($row['name'])) {
                $quotes[(string) $row['name']] = $row;
            }
        }

        $out = [];

        foreach (Approvals::testimonials() as $approved) {
            $source = $quotes[$approved['name']] ?? null;

            if ($source === null || ! isset($source['quote'])) {
                continue;
            }

            $out[] = [
                'name' => $approved['name'],
                'period' => $source['period'] ?? $approved['period'],
                'quote' => (string) $source['quote'],
            ];
        }

        return $out;
    }

    /**
     * Site chrome: navigation (already localised by Pages), footer, CTA labels,
     * aria labels, and the language switcher state.
     *
     * @return array<string, mixed>
     */
    private static function chrome(string $locale, string $pageKey, string $path): array
    {
        return [
            'nav' => Pages::navigation($locale),
            'brand' => [
                'mark' => 'UMI',
                'company' => trans('site.meta.company', [], $locale),
                'short' => trans('site.meta.short', [], $locale),
            ],
            'cta' => trans('site.cta', [], $locale),
            'ctaBlock' => trans('site.cta_block', [], $locale),
            'contactPage' => trans('site.contact_page', [], $locale),
            'aria' => trans('site.nav_aria', [], $locale),
            'footer' => trans('site.footer', [], $locale),
            'languages' => Locales::switcher($locale, $pageKey, $path),
            'language' => trans('site.language', [], $locale),
        ];
    }

    /**
     * SEO: title, description, canonical, hreflang alternates.
     *
     * @return array<string, mixed>
     */
    private static function seo(string $pageKey, string $locale, string $path): array
    {
        $page = Pages::copy($pageKey);
        $seo = (array) ($page['seo'] ?? []);
        $base = rtrim((string) config('app.url'), '/');
        $canonical = $base.'/'.$locale.($path === '' ? '' : '/'.$path);

        return [
            'title' => $seo['title'] ?? trans('seo.defaults.title'),
            'description' => $seo['description'] ?? trans('seo.defaults.description'),
            'canonical' => $canonical,
            'og' => [
                'type' => trans('seo.og.type'),
                'site_name' => trans('seo.og.site_name'),
                'image' => $base.trans('seo.defaults.og_image'),
                'url' => $canonical,
            ],
            'alternates' => array_map(
                fn (array $alt) => [...$alt, 'url' => $base.$alt['url']],
                Locales::alternates($pageKey, $path)
            ),
            'xDefault' => $base.Locales::xDefault($path),
            'jsonLd' => self::jsonLd($locale, $base, $canonical, $seo),
        ];
    }

    /**
     * Structured data. Only facts the site actually publishes: the organisation
     * and its two real locations. No ratings, no invented founding claims.
     *
     * @param  array<string, mixed>  $seo
     * @return array<string, mixed>
     */
    private static function jsonLd(string $locale, string $base, string $canonical, array $seo): array
    {
        $contact = (array) trans('site.contact');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => trans('site.meta.company'),
            'alternateName' => trans('site.meta.short'),
            'url' => $base.'/'.$locale,
            'foundingDate' => trans('site.meta.founded'),
            'description' => $seo['description'] ?? trans('seo.defaults.description'),
            'email' => $contact['email'] ?? null,
            'telephone' => $contact['phone'] ?? null,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $contact['batam']['lines'][0] ?? null,
                'addressLocality' => 'Batam Center',
                'postalCode' => '29432',
                'addressRegion' => 'Kepulauan Riau',
                'addressCountry' => 'ID',
            ],
            'location' => [
                [
                    '@type' => 'Place',
                    'name' => $contact['batam']['label'] ?? null,
                    'address' => implode(', ', $contact['batam']['lines'] ?? []),
                ],
            ],
            'mainEntityOfPage' => $canonical,
        ];
    }

    /**
     * Breadcrumbs: Home > page. Parent pages get Home > parent > page.
     *
     * @return list<array{label: string, url: string}>
     */
    private static function breadcrumbs(string $pageKey, string $locale): array
    {
        $trail = [[
            'label' => trans('site.nav.home', [], $locale) ?: 'Home',
            'url' => '/'.$locale,
        ]];

        if ($pageKey === 'home') {
            return [];
        }

        // A dotted key ("products.battery-contacts") gets its parent prepended
        // when the parent is itself a routed page.
        if (str_contains($pageKey, '.')) {
            $parent = explode('.', $pageKey)[0];
            if (Pages::exists($parent)) {
                $trail[] = [
                    'label' => trans('site.nav.'.$parent, [], $locale),
                    'url' => '/'.$locale.'/'.Pages::path($parent),
                ];
            }
        }

        $page = Pages::copy($pageKey);
        $trail[] = [
            'label' => $page['hero']['eyebrow'] ?? $pageKey,
            'url' => '/'.$locale.'/'.Pages::path($pageKey),
        ];

        return $trail;
    }

    /**
     * @return array<string, mixed>
     */
    private static function site(string $locale): array
    {
        return [
            'name' => trans('site.meta.short', [], $locale),
            'company' => trans('site.meta.company', [], $locale),
            'founded' => trans('site.meta.founded', [], $locale),
            'language' => trans('site.language', [], $locale),
        ];
    }
}
