<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use App\Support\PageProps;
use App\Support\Pages;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves every registry page for a validated {locale} segment.
 *
 * The page is identified by the `pageKey` route default that routes/web.php
 * sets from App\Support\Pages::REGISTRY, so there is no per-page method to
 * forget to add when a page is registered.
 *
 * Locale policy: a page with no signed-off copy in this locale 302s to the /en/
 * equivalent rather than serving an English body under a foreign lang attribute
 * (AC-16, AC-40). Fail-closed: no entry in config('locales.translated.{page}')
 * means no exemption.
 */
class PageController extends Controller
{
    public function page(Request $request): Response
    {
        return $this->render((string) $request->route('pageKey'), $request);
    }

    public function contact(Request $request): Response
    {
        return $this->render('contact', $request);
    }

    private function render(string $pageKey, Request $request): Response
    {
        $locale = (string) $request->route('locale');

        // The route constraint already limits {locale} to Locales::CODES and the
        // registry gates pageKey. Both are re-checked: a 404 here means the route
        // table and the registry disagreed, which must never render a page.
        if (! Locales::isSupported($locale) || ! Pages::exists($pageKey)) {
            abort(404);
        }

        if (! Locales::isTranslated($pageKey, $locale)) {
            return redirect()->route('site.'.$pageKey, ['locale' => Locales::DEFAULT], 302);
        }

        // Inertia\Response has no header() macro in v3: materialise the HTTP
        // response first, then set the header on it.
        $response = Inertia::render(
            Pages::component($pageKey),
            PageProps::forPage($pageKey, $locale, $request),
        )->toResponse($request);

        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
