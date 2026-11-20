<?php

namespace Tests\Feature;

use App\Support\Locales;
use App\Support\Pages;
use Tests\TestCase;

/**
 * hreflang alternates and the language switcher.
 *
 * Both had the same shape of bug: they named a locale that does not exist as a
 * served page. hreflang pointed the Indonesian alternate at the English URL,
 * and the switcher's pending message was taken from the first unavailable
 * language, so Chinese was labelled "Bahasa Indonesia". Neither breaks a page —
 * they misinform a crawler and a screen-reader user respectively, which is why
 * they need a test rather than a careful read.
 */
class HreflangTest extends TestCase
{
    public function test_unsigned_locales_are_omitted_rather_than_pointed_at_english(): void
    {
        // Simulate a page with no approved translations while keeping production sign-offs.
        config()->set('locales.translated', ['*' => []]);
        $response = $this->get('/en/about');
        $response->assertOk();

        $alternates = $response->viewData('page')['props']['seo']['alternates'];

        // Only English is signed off, so only English may be advertised. An
        // alternate claiming /en/about is the Indonesian version is a lie to
        // every crawler that reads it.
        $this->assertSame(['en'], array_column($alternates, 'code'));
        $this->assertSame(
            [config('app.url').'/en/about'],
            array_column($alternates, 'url')
        );
    }

    public function test_no_alternate_url_is_a_redirect(): void
    {
        // Every advertised alternate must serve 200, not bounce the visitor back
        // to /en. This is the invariant the previous implementation broke.
        $response = $this->get('/en/products');
        $alternates = $response->viewData('page')['props']['seo']['alternates'];

        foreach ($alternates as $alt) {
            $path = parse_url($alt['url'], PHP_URL_PATH);
            $this->get($path)->assertOk();
        }
    }

    public function test_x_default_always_points_at_the_default_locale(): void
    {
        $props = $this->get('/en/products')->viewData('page')['props'];

        $this->assertStringEndsWith('/en/products', $props['seo']['xDefault']);
    }

    public function test_every_signed_off_locale_may_advertise_itself(): void
    {
        // Proves the omission is driven by the sign-off registry, not by a
        // hardcoded English-only list. Signing off `id` must add the alternate.
        config()->set('locales.translated', ['*' => [], 'about' => ['en', 'id']]);

        $alternates = Locales::alternates('about', 'about');
        $codes = array_column($alternates, 'code');

        $this->assertContains('en', $codes);
        $this->assertContains('id', $codes);
        $this->assertNotContains('zh', $codes);
    }

    public function test_chinese_is_not_labelled_indonesian_in_the_switcher_data(): void
    {
        // The bug: the pending label was read off the first unavailable locale,
        // so `zh` rendered title="Bahasa Indonesia".
        $languages = $this->get('/en/about')->viewData('page')['props']['chrome']['languages'];

        $byCode = [];
        foreach ($languages as $lang) {
            $byCode[$lang['code']] = $lang;
        }

        $this->assertSame('Bahasa Indonesia', $byCode['id']['label']);
        $this->assertSame('简体中文', $byCode['zh']['label']);
        $this->assertNotSame($byCode['id']['label'], $byCode['zh']['label']);
    }

    public function test_unavailable_locales_are_not_rendered_as_links(): void
    {
        // A disabled control is honest; a link that redirects back to /en is not.
        config()->set('locales.translated', ['*' => []]);
        $languages = $this->get('/en/about')->viewData('page')['props']['chrome']['languages'];

        foreach ($languages as $lang) {
            if ($lang['code'] === 'en') {
                continue;
            }

            $this->assertFalse($lang['available'], "{$lang['code']} must be unavailable until signed off");
        }
    }

    public function test_dotted_page_keys_are_read_flat_not_by_dot_traversal(): void
    {
        // config('locales.translated.products.battery-contacts') splits on every
        // dot, so a signed-off child page read that way silently resolves to
        // nothing and redirects to /en forever. The failure is invisible: the
        // page returns 302, which looks exactly like "not signed off yet".
        $key = 'products.battery-contacts';

        config()->set('locales.translated', ['*' => [], $key => ['en', 'id']]);

        $this->assertTrue(Locales::isTranslated($key, 'id'));
        $this->assertSame(['en', 'id'], Locales::translated($key));

        // And the route agrees with the policy.
        $this->get('/id/products/battery-contacts')->assertOk();
    }

    public function test_a_signed_off_dotted_page_is_not_redirected(): void
    {
        // Every child page carries a dotted key, so this covers all of them.
        $dotted = array_values(array_filter(
            Pages::keys(),
            fn (string $key) => str_contains($key, '.')
        ));

        $this->assertNotEmpty($dotted, 'registry is expected to contain dotted child keys');

        $registry = (array) config('locales.translated');
        foreach ($dotted as $key) {
            $registry[$key] = ['en', 'id'];
        }
        config()->set('locales.translated', $registry);

        foreach ($dotted as $key) {
            $path = Pages::path($key);
            $this->get('/id/'.$path)->assertOk();
        }
    }

    public function test_every_locale_has_accessible_names_for_the_video_control(): void
    {
        // WCAG 2.2.2 needs a pause control; a control with no accessible name is
        // not usable by anyone not looking at it, and an empty string here would
        // render aria-label="" silently.
        foreach (['en', 'id', 'zh'] as $locale) {
            foreach (['pause_video', 'play_video'] as $key) {
                $label = trans('site.nav_aria.'.$key, [], $locale);

                $this->assertNotSame('site.nav_aria.'.$key, $label, "missing {$key} in {$locale}");
                $this->assertNotSame('', trim((string) $label));
            }
        }
    }

    public function test_the_pending_message_exists_in_every_locale(): void
    {
        // The label is read from the active locale's copy, so a locale missing
        // the key would render an empty title instead of the explanation.
        foreach (['en', 'id', 'zh'] as $locale) {
            $msg = trans('site.language.unavailable', [], $locale);

            $this->assertIsString($msg);
            $this->assertNotSame('site.language.unavailable', $msg, "missing key in {$locale}");
            $this->assertNotSame('', trim($msg));
        }
    }
}
