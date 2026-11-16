<?php

namespace Tests\Feature;

use App\Support\Pages;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * The translation drafts, rendered.
 *
 * id and zh are complete drafts with no company sign-off, so the served site
 * redirects them to /en and nobody has ever seen them on a page. That is the
 * dangerous state: a translation can be key-complete and still render as broken
 * markup, and the first person to find out would be the company employee who
 * signs it off.
 *
 * These tests temporarily sign a locale off, render every page through the real
 * stack, and assert the page is genuinely in that language with the right HTML
 * lang attribute. They change nothing about what production serves — the sign-off
 * registry is untouched after each test — but they mean that approving a locale
 * is a one-line diff with the rendering already proven.
 */
class TranslationRenderTest extends TestCase
{
    /**
     * Render a page as though the locale were signed off.
     */
    private function renderSignedOff(string $locale, string $pageKey): array
    {
        $pages = (array) config('locales.translated');
        $pages[$pageKey] = array_values(array_unique([...($pages[$pageKey] ?? ['en']), $locale]));
        config()->set('locales.translated', $pages);

        $path = Pages::path($pageKey);
        $url = '/'.$locale.($path === '' ? '' : '/'.$path);

        $response = $this->get($url);
        $response->assertOk();

        return $response->viewData('page')['props'];
    }

    public static function localeProvider(): array
    {
        return [
            'indonesian' => ['id', ['home', 'about', 'capabilities', 'products', 'facilities', 'quality', 'contact']],
            'chinese' => ['zh', ['home', 'about', 'capabilities', 'products', 'facilities', 'quality', 'contact']],
        ];
    }

    #[DataProvider('localeProvider')]
    public function test_a_signed_off_locale_serves_its_own_url_and_lang(string $locale, array $pageKeys): void
    {
        foreach ($pageKeys as $pageKey) {
            $props = $this->renderSignedOff($locale, $pageKey);

            $this->assertSame($locale, $props['locale'], "{$pageKey} served the wrong locale");
            $this->assertSame(
                $locale === 'zh' ? 'zh-Hans' : $locale,
                $props['htmlLang'],
                "{$pageKey} has the wrong HTML lang attribute"
            );
        }
    }

    #[DataProvider('localeProvider')]
    public function test_no_page_falls_back_to_english_body_text(string $locale, array $pageKeys): void
    {
        foreach ($pageKeys as $pageKey) {
            $props = $this->renderSignedOff($locale, $pageKey);

            // The English headline. Pages::copy() reads the *active* locale, and
            // the request above left it on the locale under test, so the English
            // text has to be fetched explicitly. Comparing against copy() here
            // would silently compare the draft with itself and pass.
            $englishTitle = trans('pages.'.$pageKey.'.hero.title', [], 'en');

            if (! is_string($englishTitle) || $englishTitle === 'pages.'.$pageKey.'.hero.title') {
                $englishTitle = null;
            }

            if ($englishTitle === null) {
                continue;
            }

            $rendered = (string) ($props['content']['hero']['title'] ?? '');

            $this->assertNotSame(
                $englishTitle,
                $rendered,
                "{$pageKey} rendered the English headline in {$locale}"
            );
            $this->assertNotSame('', trim($rendered), "{$pageKey} rendered an empty headline in {$locale}");
        }
    }

    #[DataProvider('localeProvider')]
    public function test_navigation_labels_are_translated(string $locale, array $pageKeys): void
    {
        $props = $this->renderSignedOff($locale, 'about');
        $english = Pages::navigation('en');
        $localised = $props['chrome']['nav'];

        $this->assertCount(count($english), $localised);

        // Brand-neutral short labels legitimately match across languages, so the
        // assertion is that the set is not wholesale identical rather than that
        // every item differs.
        $differs = 0;

        foreach ($localised as $item) {
            foreach ($english as $source) {
                if ($source['key'] === $item['key'] && $source['label'] !== $item['label']) {
                    $differs++;
                }
            }
        }

        $this->assertGreaterThan(0, $differs, "navigation is not translated for {$locale}");
    }

    #[DataProvider('localeProvider')]
    public function test_form_validation_messages_are_translated(string $locale, array $pageKeys): void
    {
        $props = $this->renderSignedOff($locale, 'contact');
        $form = $props['form'];

        // A validation message left in English is the kind of gap nobody notices
        // until a real customer hits an error. FormLabels flattens the lang file
        // into the shape the component takes, so compare the labels that carry
        // meaning rather than the whole array.
        $english = \App\Support\FormLabels::for('en');

        foreach (['title', 'submit', 'successTitle', 'successBody', 'consent'] as $key) {
            $this->assertNotSame(
                $english[$key],
                $form[$key],
                "form copy '{$key}' is untranslated for {$locale}"
            );
            $this->assertNotSame('', trim((string) $form[$key]), "form copy '{$key}' is empty for {$locale}");
        }
    }

    #[DataProvider('localeProvider')]
    public function test_seo_metadata_is_translated_and_canonical_is_localised(string $locale, array $pageKeys): void
    {
        $props = $this->renderSignedOff($locale, 'about');

        $this->assertStringEndsWith("/{$locale}/about", $props['seo']['canonical']);

        // Explicit English lookup, not Pages::copy() — see the note above.
        $englishTitle = trans('pages.about.seo.title', [], 'en');

        $this->assertNotSame($englishTitle, $props['seo']['title'], "meta title is not translated for {$locale}");
    }

    #[DataProvider('localeProvider')]
    public function test_internal_links_stay_inside_the_locale(string $locale, array $pageKeys): void
    {
        $props = $this->renderSignedOff($locale, 'about');

        // Sign the whole locale off before following its navigation: each nav
        // target is its own page with its own sign-off entry, so checking one
        // page's sign-off and then requesting a different page tests nothing but
        // the registry's per-page granularity.
        $current = (array) config('locales.translated');
        $all = [];

        foreach (Pages::keys() as $key) {
            $all[$key] = array_values(array_unique([...($current[$key] ?? ['en']), $locale]));
        }

        config()->set('locales.translated', $all);

        foreach ($props['chrome']['nav'] as $item) {
            $this->get('/'.$locale.'/'.$item['path'])->assertOk();
        }
    }
}
