<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * /sitemap.xml and /robots.txt.
 *
 * ponytail: the sitemap emits an empty urlset. AC-12 needs four alternates per
 * page, which needs the real rendered page set. Populate from the same page list
 * PageController uses once pages render.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        return response(
            '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>',
            200
        )->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\n", 200)
            ->header('Content-Type', 'text/plain');
    }
}
