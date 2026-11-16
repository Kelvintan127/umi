<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locale Codes
    |--------------------------------------------------------------------------
    |
    | Single source of truth for AC-10 / AC-40 and R1-A. This MUST stay a
    | literal array of lowercase two-letter codes: RouteRegistrar::whereIn()
    | implodes values into a regex without preg_quote() (Framework 12.72.0,
    | CreatesRegularExpressionRouteConstraints), so a metacharacter here would
    | silently become a pattern match rather than a literal one.
    |
    */

    'codes' => ['en', 'id', 'zh'],

    'default' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Sign-Off Registry
    |--------------------------------------------------------------------------
    |
    | page => locales that have SIGNED-OFF copy. 'en' is the source locale and
    | is implicit for every page. A locale absent from a page's list means that
    | page has no approved translation for it, so /{locale}/{page} 302s to the
    | /en/ equivalent rather than serving an English body under a foreign lang
    | attribute (AC-16, AC-40, Q-10, Q-11). No sign-off means no redirect
    | exemption: silence fails closed.
    |
    | COMPLETE DRAFTS EXIST FOR id AND zh (lang/id, lang/zh) — see
    | docs/translation-signoff.md. They are deliberately NOT listed here. A
    | draft becomes servable only when the company signs it off and its locale
    | code is added to the page's list below, which is a one-line, reviewable
    | diff. tests/Feature/TranslationCompletenessTest.php fails if a registered
    | locale's draft is incomplete, so a sign-off cannot outrun the copy.
    |
    */

    'translated' => [
        'privacy' => ['en'],
        'terms' => ['en'],
        // all other pages are added here as their translation lands
    ],

];
