<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;

/**
 * Guards the Inertia response contract for the {locale} page group.
 *
 * These assertions exist because the controller originally narrowed its return
 * type to Illuminate\Http\Response while Inertia returns JsonResponse on an
 * X-Inertia XHR and RedirectResponse for an untranslated locale. Both were
 * silent 500s until proven over real HTTP.
 */
class InertiaPageTest extends TestCase
{
    public function test_a_page_renders_the_inertia_root_template(): void
    {
        $response = $this->get('/en');

        $response->assertOk();
        // The root element must carry the serialised page payload, which is
        // what lets the client hydrate without a second request.
        //
        // Do not assert the payload's encoding. Inertia 2 emits it two ways
        // depending on state — `data-page="app"` plus a raw-JSON script block
        // when SSR/history is available, or the whole payload HTML-escaped
        // inside the attribute otherwise. Both hydrate correctly. Assert the
        // decoded payload instead, which is the property that actually matters.
        $response->assertSee('id="app"', false);

        // Laravel hands the test an array; over the wire it is an encoded
        // string. Accept either so the test tracks the payload, not the plumbing.
        $raw = $response->viewData('page');
        $page = is_array($raw) ? $raw : json_decode(html_entity_decode((string) $raw, ENT_QUOTES), true);
        $this->assertSame('Home', $page['component'] ?? null, 'the payload must name the component');
        $this->assertIsArray($page['props'] ?? null, 'the payload must carry props');
        $this->assertArrayHasKey('locale', $page['props'], 'shared props must reach the client');
        $response->assertHeader('Content-Language', 'en');
    }

    public function test_an_inertia_xhr_receives_json_not_html(): void
    {
        // The version is derived from build/manifest.json. Read it from the
        // first (full-page) response the way the client does, otherwise Inertia
        // correctly answers 409 Conflict to force an asset reload.
        $version = $this->get('/en')->viewData('page')['version'];

        $response = $this->withHeaders([
            'X-Inertia' => 'true',
            'X-Inertia-Version' => $version,
            'X-Requested-With' => 'XMLHttpRequest',
        ])->get('/en');

        $response->assertOk();
        $response->assertHeader('X-Inertia', 'true');
        $this->assertSame('Home', $response->json('component'));
        $this->assertSame('en', $response->json('props.locale'));
    }

    public function test_a_stale_asset_version_is_rejected_with_409(): void
    {
        $response = $this->withHeaders([
            'X-Inertia' => 'true',
            'X-Inertia-Version' => 'stale-version',
        ])->get('/en');

        $response->assertStatus(409);
        $response->assertHeader('X-Inertia-Location');
    }

    public function test_an_untranslated_locale_redirects_to_the_default(): void
    {
        // No signed-off ID/ZH copy exists yet, so the locale policy must redirect
        // rather than serve an English body under a foreign lang attribute.
        $this->get('/id')->assertRedirect('/en');
        $this->get('/zh/about')->assertRedirect('/en/about');
    }

    public function test_the_default_locale_serves_every_page_with_200(): void
    {
        foreach (['', '/about', '/contact', '/news'] as $path) {
            $this->get('/en'.$path)->assertOk();
        }
    }
}
