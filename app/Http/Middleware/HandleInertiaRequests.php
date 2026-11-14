<?php

namespace App\Http\Middleware;

use App\Support\Locales;
use Illuminate\Http\Request;
use Inertia\Middleware as BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shares the props every page needs, and keeps the Inertia asset version tied to
 * the built manifest so a rebuild triggers a client reload.
 */
class HandleInertiaRequests extends BaseMiddleware
{
    public function version(Request $request): ?string
    {
        $manifest = public_path('build/manifest.json');

        return is_file($manifest) ? (string) hash_file('xxh128', $manifest) : null;
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = (string) ($request->route('locale') ?? Locales::DEFAULT);

        return array_merge(parent::share($request), [
            'locale' => $locale,
            'htmlLang' => Locales::htmlLang($locale),
        ]);
    }
}
