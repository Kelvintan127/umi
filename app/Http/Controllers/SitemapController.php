<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use App\Support\Pages;
use Illuminate\Http\Response;

/**
 * /sitemap.xml and /robots.txt, generated from App\Support\Pages::REGISTRY.
 *
 * One <url> per page per *published* locale. A locale whose translations are
 * not signed off has no URL of its own — the router redirects it to English, so
 * listing it would advertise duplicates and contradict the hreflang set the
 * page head emits (Locales::alternates()).
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $lastmod = now()->toDateString();

        $urls = '';

        foreach (Pages::REGISTRY as $key => $meta) {
            $suffix = $meta['path'] === '' ? '' : '/'.$meta['path'];
            $published = Locales::published();

            $links = '';
            foreach (Locales::alternates($key, $meta['path']) as $alt) {
                $links .= '    <xhtml:link rel="alternate" hreflang="'.$alt['htmlLang']
                    .'" href="'.htmlspecialchars($base.$alt['url'], ENT_XML1).'"/>'."\n";
            }

            foreach ($published as $locale) {
                $loc = $base.'/'.$locale.$suffix;

                $urls .= "  <url>\n"
                    .'    <loc>'.htmlspecialchars($loc, ENT_XML1)."</loc>\n"
                    .$links
                    .'    <lastmod>'.$lastmod."</lastmod>\n"
                    .'    <changefreq>monthly</changefreq>'."\n"
                    .'    <priority>'.$meta['priority']."</priority>\n"
                    ."  </url>\n";
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'
            .' xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n"
            .$urls
            .'</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $base = rtrim((string) config('app.url'), '/');

        $body = "User-agent: *\n"
            ."Allow: /\n"
            ."Disallow: /build/\n"
            ."\n"
            .'Sitemap: '.$base."/sitemap.xml\n";

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
