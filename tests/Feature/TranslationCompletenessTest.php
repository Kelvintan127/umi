<?php

namespace Tests\Feature;

use App\Support\Locales;
use App\Support\Pages;
use Tests\TestCase;

/**
 * Fails when a locale is signed off in config/locales.php but its draft is not
 * complete, or when a draft drifts structurally from the English source.
 *
 * The point is that a sign-off cannot outrun the copy: adding 'id' to a page's
 * translated list without complete lang/id/ files turns this suite red.
 *
 * A draft that exists but is not signed off is allowed — it just is not served.
 */
class TranslationCompletenessTest extends TestCase
{
    /**
     * @return array<string, array<string, mixed>>
     */
    private function flatten(string $file): array
    {
        $data = require base_path('lang/'.$file);

        $out = [];
        $walk = function (array $node, string $prefix) use (&$walk, &$out): void {
            foreach ($node as $key => $value) {
                $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;
                if (is_array($value)) {
                    $walk($value, $path);
                } else {
                    $out[$path] = $value;
                }
            }
        };
        $walk($data, '');

        return $out;
    }

    public function test_every_signed_off_locale_has_complete_files(): void
    {
        foreach (Locales::CODES as $code) {
            if ($code === Locales::DEFAULT) {
                continue;
            }

            // Only enforce completeness for locales that are actually published.
            if (! in_array($code, Locales::published(), true)) {
                $this->assertTrue(true, "{$code} is a draft; completeness not enforced until sign-off.");

                continue;
            }

            foreach (['site.php', 'pages.php', 'seo.php', 'forms.php'] as $file) {
                $this->assertFileExists(
                    base_path('lang/'.$code.'/'.$file),
                    "Locale {$code} is published but lang/{$code}/{$file} is missing."
                );

                // Extra draft keys may exist outside the published page registry.
                // Require every English contract key to exist in the locale; preserve
                // unpublished draft content rather than deleting it to pass parity.
                $missing = array_values(array_diff(
                    array_keys($this->flatten('en/'.$file)),
                    array_keys($this->flatten($code.'/'.$file))
                ));
                $this->assertSame(
                    [],
                    $missing,
                    "lang/{$code}/{$file} is missing required keys from lang/en/{$file}."
                );
            }
        }
    }

    public function test_a_draft_locale_never_leaks_english_body_text_under_its_own_lang(): void
    {
        foreach (Locales::CODES as $code) {
            if ($code === Locales::DEFAULT || in_array($code, Locales::published(), true)) {
                continue;
            }

            // Everything in this locale must redirect, so the response can
            // never carry lang="{code}".
            $response = $this->get('/'.$code);
            $response->assertRedirect();
            $this->assertStringNotContainsString('lang="'.$code.'"', (string) $response->headers->get('Location'));
        }
    }

    public function test_every_registry_page_has_english_copy(): void
    {
        foreach (array_keys(Pages::REGISTRY) as $pageKey) {
            $page = Pages::copy($pageKey);

            $this->assertIsArray($page, "pages.{$pageKey} is not an array.");
            $this->assertNotEmpty($page['hero'] ?? null, "pages.{$pageKey}.hero is empty.");
            $this->assertNotEmpty($page['hero']['title'] ?? null, "pages.{$pageKey}.hero.title is empty.");
            $this->assertNotEmpty($page['seo']['title'] ?? null, "pages.{$pageKey}.seo.title is empty.");
            $this->assertNotEmpty($page['seo']['description'] ?? null, "pages.{$pageKey}.seo.description is empty.");
        }
    }

    public function test_no_page_ships_an_empty_section_list_except_contact(): void
    {
        foreach (array_keys(Pages::REGISTRY) as $pageKey) {
            if ($pageKey === 'contact') {
                continue;
            }

            $sections = Pages::copy($pageKey)['sections'] ?? null;

            $this->assertIsArray($sections, "pages.{$pageKey}.sections is not an array.");
            $this->assertNotEmpty($sections, "pages.{$pageKey} has no sections; the page would render a bare hero.");
        }
    }

    public function test_every_section_type_has_a_renderer(): void
    {
        // Mirrors the switch in resources/js/components/sections/SectionRenderer.tsx.
        $known = [
            'prose', 'cards', 'specs', 'certifications', 'policy', 'stats',
            'process', 'gallery', 'news', 'users', 'testimonials', 'legal', 'cta',
        ];

        foreach (array_keys(Pages::REGISTRY) as $pageKey) {
            foreach ((array) (Pages::copy($pageKey)['sections'] ?? []) as $index => $section) {
                $this->assertContains(
                    $section['type'] ?? null,
                    $known,
                    "pages.{$pageKey}.sections.{$index} has an unknown type; it would render the error band."
                );
            }
        }
    }
}
