<?php

namespace App\Support;

/**
 * The single page registry: every public page, its URL path, its Inertia
 * component, and its place in the sitemap / navigation.
 *
 * Routes, sitemap alternates, breadcrumbs and the translation-parity test all
 * read this list, so adding a page is a one-line change here plus its lang
 * leaves. Nothing else needs editing.
 */
final class Pages
{
    /**
     * key => ['path' => url segment under /{locale}, 'component' => Inertia page,
     *         'action' => PageController method, 'priority' => sitemap priority,
     *         'nav' => shown in primary nav]
     *
     * @var array<string, array{path: string, component: string, action: string, priority: string, nav: bool}>
     */
    public const REGISTRY = [
        'home' => ['path' => '', 'component' => 'Home', 'action' => 'page', 'priority' => '1.0', 'nav' => false],
        'about' => ['path' => 'about', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.9', 'nav' => true],
        'certifications' => ['path' => 'certifications', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.8', 'nav' => false],
        'policy' => ['path' => 'policy', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.6', 'nav' => false],
        'capabilities' => ['path' => 'capabilities', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.9', 'nav' => true],
        'products' => ['path' => 'products', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.9', 'nav' => true],
        'products.battery-contacts' => ['path' => 'products/battery-contacts', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'products.wire-harnessing' => ['path' => 'products/wire-harnessing', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'products.ods-dvd-drive' => ['path' => 'products/ods-dvd-drive', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'products.mechanical-assembly' => ['path' => 'products/mechanical-assembly', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'products.electrical-metal-parts' => ['path' => 'products/electrical-metal-parts', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'facilities' => ['path' => 'facilities', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.8', 'nav' => true],
        'facilities.production-machines' => ['path' => 'facilities/production-machines', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'facilities.supporting-machines' => ['path' => 'facilities/supporting-machines', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'facilities.tools-design-storage' => ['path' => 'facilities/tools-design-storage', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'facilities.measurement-equipment' => ['path' => 'facilities/measurement-equipment', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.7', 'nav' => false],
        'metal-part-users' => ['path' => 'metal-part-users', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.6', 'nav' => false],
        'industries' => ['path' => 'industries', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.8', 'nav' => true],
        'quality' => ['path' => 'quality', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.8', 'nav' => true],
        'gallery' => ['path' => 'gallery', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.6', 'nav' => false],
        'news' => ['path' => 'news', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.5', 'nav' => false],
        'contact' => ['path' => 'contact', 'component' => 'Contact', 'action' => 'contact', 'priority' => '0.9', 'nav' => true],
        'privacy' => ['path' => 'privacy', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.3', 'nav' => false],
        'terms' => ['path' => 'terms', 'component' => 'ContentPage', 'action' => 'page', 'priority' => '0.3', 'nav' => false],
    ];

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys(self::REGISTRY);
    }

    public static function exists(string $key): bool
    {
        return isset(self::REGISTRY[$key]);
    }

    /**
     * Page copy for a registry key, in the active locale.
     *
     * The pages lang file uses literal dotted keys ("products.battery-contacts")
     * as flat siblings of "products". A trans('pages.products.battery-contacts')
     * call would be split on the dot by the translator and never match, so the
     * whole file is fetched and indexed literally.
     *
     * @return array<string, mixed>
     */
    public static function copy(string $key): array
    {
        $all = trans('pages');

        return is_array($all) ? (array) ($all[$key] ?? []) : [];
    }

    /**
     * A single value from a page's copy, e.g. copyValue('x.y', 'hero.title').
     */
    public static function copyValue(string $key, string $path, mixed $fallback = null): mixed
    {
        $value = self::copy($key);

        foreach (explode('.', $path) as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return $fallback;
            }
            $value = $value[$segment];
        }

        return $value ?? $fallback;
    }

    public static function path(string $key): string
    {
        return self::REGISTRY[$key]['path'];
    }

    public static function component(string $key): string
    {
        return self::REGISTRY[$key]['component'];
    }

    public static function priority(string $key): string
    {
        return self::REGISTRY[$key]['priority'];
    }

    /**
     * Primary navigation, ordered. Labels come from lang/{locale}/site.php
     * under `nav.{key}`, so a missing translation is visible as the key.
     *
     * @return list<array{key: string, path: string, label: string}>
     */
    public static function navigation(?string $locale = null): array
    {
        $out = [];
        foreach (self::REGISTRY as $key => $meta) {
            if (! $meta['nav']) {
                continue;
            }
            $out[] = [
                'key' => $key,
                'path' => $meta['path'],
                'label' => trans('site.nav.'.$key, [], $locale),
            ];
        }

        return $out;
    }
}
