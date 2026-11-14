<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves the 11 site pages for a validated {locale} segment.
 *
 * ponytail: bodies are not built. Every action runs the locale policy
 * (AC-16/AC-40) and returns a placeholder, so the route table, the redirect
 * rule and the locale constraint are testable now. Replace each action's body
 * with Inertia::render('...') as that page is migrated; the signatures and the
 * policy gate stay as written.
 */
class PageController extends Controller
{
    public function home(Request $request): Response { return $this->renderPage('home', $request); }

    public function about(Request $request): Response { return $this->renderPage('about', $request); }

    public function capabilities(Request $request): Response { return $this->renderPage('capabilities', $request); }

    public function products(Request $request): Response { return $this->renderPage('products', $request); }

    public function industries(Request $request): Response { return $this->renderPage('industries', $request); }

    public function quality(Request $request): Response { return $this->renderPage('quality', $request); }

    public function gallery(Request $request): Response { return $this->renderPage('gallery', $request); }

    public function news(Request $request): Response { return $this->renderPage('news', $request); }

    public function contact(Request $request): Response { return $this->renderPage('contact', $request); }

    public function privacy(Request $request): Response { return $this->renderPage('privacy', $request); }

    public function terms(Request $request): Response { return $this->renderPage('terms', $request); }

    private function renderPage(string $page, Request $request): Response
    {
        $locale = (string) $request->route('locale');

        // The route constraint already limits {locale} to Locales::CODES. This is
        // defence in depth, mirroring Unit/LocalesTest.php.
        if (! Locales::isSupported($locale)) {
            abort(404);
        }

        // A page with no signed-off copy for this locale 302s to /en/ rather than
        // serving an English body under a foreign lang attribute (AC-16, AC-40).
        if (! Locales::isTranslated($page, $locale)) {
            return redirect()->route('site.'.$page, ['locale' => Locales::DEFAULT], 302);
        }

        // Page component names are PascalCase to match resources/js/pages.
        // Inertia\Response has no header() macro in v3: materialise the HTTP
        // response first, then set the header on it.
        $response = Inertia::render(ucfirst($page), [
            'locale' => $locale,
            'htmlLang' => Locales::htmlLang($locale),
        ])->toResponse($request);

        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
