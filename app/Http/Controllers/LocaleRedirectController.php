<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use Illuminate\Http\RedirectResponse;

/**
 * GET / negotiates a locale and 302s exactly once (AC-11: no redirect loop).
 *
 * ponytail: session and Accept-Language negotiation are not wired. It redirects
 * to the default locale, which satisfies "single 302, no loop". Add the
 * session -> Accept-Language -> default order when the language switcher lands;
 * the target stays /{locale}/ because every locale's home is translated.
 */
class LocaleRedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('site.home', ['locale' => Locales::DEFAULT], 302);
    }
}
