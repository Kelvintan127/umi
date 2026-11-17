<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocaleRedirectController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;
use App\Support\Locales;
use App\Support\Pages;
use Illuminate\Support\Facades\Route;

/*
 * No closures anywhere in this file: `php artisan route:cache` cannot serialise
 * them (ENG-003 §12 step 6).
 */

Route::get('/', LocaleRedirectController::class)->name('site.root');
Route::get('/media/company-profile.mp4', [MediaController::class, 'companyProfile'])
    ->name('media.company-profile');

Route::prefix('{locale}')
    // whereIn() is a real trait method on RouteRegistrar, not a dynamic attribute.
    // It implodes the values into a regex WITHOUT preg_quote, so Locales::CODES
    // must stay a literal const of lowercase two-letter codes (R1-A).
    ->whereIn('locale', Locales::CODES)
    ->middleware(SetLocale::class)
    ->name('site.')
    ->group(function () {
        // One route per registry entry, generated from the registry itself, so a
        // page cannot exist in the sitemap without a route (or the reverse).
        foreach (Pages::REGISTRY as $key => $meta) {
            $uri = $meta['path'] === '' ? '/' : '/'.$meta['path'];

            Route::get($uri, [PageController::class, $meta['action']])
                ->defaults('pageKey', $key)
                ->name($key);
        }

        Route::post('/contact', [ContactController::class, 'store'])
            ->middleware('throttle:5,1')->name('contact.store');
    });

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('site.sitemap');
Route::get('/robots.txt',  [SitemapController::class, 'robots'])->name('site.robots');
