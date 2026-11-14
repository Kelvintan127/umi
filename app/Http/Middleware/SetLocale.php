<?php

namespace App\Http\Middleware;

use App\Support\Locales;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the {locale} segment for the rest of the request.
 *
 * Only runs inside the route group whose {locale} is already constrained to
 * Locales::CODES, so no re-validation is needed. Sets both the framework locale
 * and Carbon's, because translated date strings come from Carbon.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = (string) $request->route('locale');

        app()->setLocale($locale);
        \Carbon\Carbon::setLocale($locale);

        return $next($request);
    }
}
