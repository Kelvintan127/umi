<?php

namespace Tests\Feature;

use App\Support\Locales;
use App\Support\Pages;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * The locale sign-off registry is fail-closed: a locale whose copy is not signed
 * off must redirect to English, never serve English body text under a foreign
 * <html lang>.
 *
 * These tests are the contract. They pass against the current state (en only)
 * and are written to keep passing once id/zh are signed off — they assert the
 * *rule*, not the current answer.
 */
class LocalePolicyTest extends TestCase
{
    public function test_every_route_locale_segment_is_a_supported_code(): void
    {
        foreach (Locales::CODES as $code) {
            $this->assertMatchesRegularExpression('/^[a-z]{2}$/', $code);
        }
    }

    public function test_an_unsigned_off_locale_redirects_to_the_default(): void
    {
        foreach (Locales::CODES as $code) {
            if (Locales::isTranslated('home', $code)) {
                continue;
            }

            $this->get('/'.$code)
                ->assertRedirect('/'.Locales::DEFAULT);
        }
    }

    public function test_an_unsigned_off_locale_page_redirects_to_the_default_page(): void
    {
        foreach (['about', 'products', 'contact', 'facilities'] as $pageKey) {
            $path = Pages::path($pageKey);

            foreach (Locales::CODES as $code) {
                if (Locales::isTranslated($pageKey, $code)) {
                    continue;
                }

                $this->get('/'.$code.'/'.$path)
                    ->assertRedirect('/'.Locales::DEFAULT.'/'.$path);
            }
        }
    }

    public function test_a_signed_off_locale_serves_its_own_url_with_its_own_lang_attribute(): void
    {
        foreach (Locales::published() as $locale) {
            $response = $this->get('/'.$locale);

            $response->assertOk();
            $response->assertSee('lang="'.Locales::htmlLang($locale).'"', false);
        }
    }

    public function test_html_lang_expands_chinese_to_hans_but_the_url_segment_stays_two_letters(): void
    {
        $this->assertSame('zh-Hans', Locales::htmlLang('zh'));
        $this->assertSame('en', Locales::htmlLang('en'));
        $this->assertSame('id', Locales::htmlLang('id'));
    }

    public function test_the_switcher_never_offers_an_unavailable_locale_as_its_own_url(): void
    {
        foreach (Pages::REGISTRY as $pageKey => $meta) {
            foreach (Locales::switcher('en', $pageKey, $meta['path']) as $option) {
                if ($option['available']) {
                    $this->assertStringStartsWith('/'.$option['code'], $option['url']);

                    continue;
                }

                $this->assertStringStartsWith(
                    '/'.Locales::DEFAULT,
                    $option['url'],
                    "Unavailable locale {$option['code']} on {$pageKey} must point at the default locale."
                );
            }
        }
    }

    public function test_hreflang_alternates_never_point_at_a_url_the_app_would_redirect(): void
    {
        foreach (Pages::REGISTRY as $pageKey => $meta) {
            $served = [];

            foreach (Locales::alternates($pageKey, $meta['path']) as $alt) {
                $served[] = $alt['url'];
            }

            // An alternate whose first segment is a locale that is not published
            // would be redirected, so it must not be advertised.
            foreach ($served as $url) {
                $first = explode('/', ltrim($url, '/'))[0];

                if ($first === '') {
                    continue;
                }

                $this->assertTrue(
                    in_array($first, Locales::published(), true),
                    "hreflang alternate {$url} targets unpublishe locale {$first}."
                );
            }
        }
    }

    public function test_the_default_locale_is_always_published(): void
    {
        $this->assertContains(Locales::DEFAULT, Locales::published());
    }

    public function test_inertia_contact_post_is_a_registered_route(): void
    {
        $this->assertTrue(Route::has('site.contact.store'));
    }
}
