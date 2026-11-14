<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocaleRedirectController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;
use App\Support\Locales;
use Illuminate\Support\Facades\Route;

/*
 * No closures anywhere in this file: `php artisan route:cache` cannot serialise
 * them (ENG-003 §12 step 6).
 */

Route::get('/', LocaleRedirectController::class)->name('site.root');

Route::prefix('{locale}')
    // whereIn() is a real trait method on RouteRegistrar, not a dynamic attribute.
    // It implodes the values into a regex WITHOUT preg_quote, so Locales::CODES
    // must stay a literal const of lowercase two-letter codes (R1-A).
    ->whereIn('locale', Locales::CODES)
    ->middleware(SetLocale::class)
    ->name('site.')
    ->group(function () {
        Route::get('/',             [PageController::class, 'home'])->name('home');
        Route::get('/about',        [PageController::class, 'about'])->name('about');
        Route::get('/capabilities', [PageController::class, 'capabilities'])->name('capabilities');
        Route::get('/products',     [PageController::class, 'products'])->name('products');
        Route::get('/industries',   [PageController::class, 'industries'])->name('industries');
        Route::get('/quality',      [PageController::class, 'quality'])->name('quality');
        Route::get('/gallery',      [PageController::class, 'gallery'])->name('gallery');
        Route::get('/news',         [PageController::class, 'news'])->name('news');
        Route::get('/contact',      [PageController::class, 'contact'])->name('contact');
        Route::post('/contact',     [ContactController::class, 'store'])
             ->middleware('throttle:5,1')->name('contact.store');
        Route::get('/privacy',      [PageController::class, 'privacy'])->name('privacy');
        Route::get('/terms',        [PageController::class, 'terms'])->name('terms');
    });

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('site.sitemap');
Route::get('/robots.txt',  [SitemapController::class, 'robots'])->name('site.robots');
