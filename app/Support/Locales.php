<?php

namespace App\Support;

/**
 * Locale policy read from config/locales.php.
 *
 * CODES is a class constant, not a method, because RouteRegistrar::whereIn()
 * does not preg_quote() its values. Unit/LocalesTest.php asserts every code
 * matches /^[a-z]{2}$/ so the constant is safe to use in a route regex.
 */
final class Locales
{
    /** @var non-empty-list<string> */
    public const CODES = ['en', 'id', 'zh'];

    public const DEFAULT = 'en';

    /**
     * Locale codes whose copy for a page has been signed off.
     *
     * @return non-empty-list<string>
     */
    public static function translated(string $page): array
    {
        $registered = (array) config('locales.translated.'.$page, []);
        $default = (string) config('locales.default', self::DEFAULT);

        return array_values(array_unique(array_merge([$default], $registered)));
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::CODES, true);
    }

    public static function isTranslated(string $page, string $locale): bool
    {
        return in_array($locale, self::translated($page), true);
    }

    /**
     * Locales that actually serve their own URLs.
     *
     * A locale is published only once every registry page is signed off: the
     * router is per-locale, not per-page, so a locale with partial coverage
     * would either 404 on the gaps or serve English under a foreign
     * <html lang>. Until sign-off, nothing in the locale is published and the
     * redirect to the default stays in force.
     *
     * @return non-empty-list<string>
     */
    public static function published(): array
    {
        $out = [];

        foreach (self::CODES as $code) {
            if ($code === self::DEFAULT) {
                $out[] = $code;

                continue;
            }

            $signedOff = true;
            foreach (array_keys(Pages::REGISTRY) as $pageKey) {
                if (! self::isTranslated((string) $pageKey, $code)) {
                    $signedOff = false;

                    break;
                }
            }

            if ($signedOff) {
                $out[] = $code;
            }
        }

        return $out;
    }

    /**
     * Value for <html lang>. The URL segment stays two letters so the route
     * regex constraint holds; only the document attribute expands zh -> zh-Hans.
     */
    public static function htmlLang(string $locale): string
    {
        return $locale === 'zh' ? 'zh-Hans' : $locale;
    }

    /**
     * The language switcher. A locale whose copy for this page is not signed
     * off is still listed, but marked unavailable and pointing at the /en/
     * equivalent, so the UI never offers a link that would silently serve an
     * English body under a foreign lang attribute.
     *
     * @return list<array{code: string, label: string, htmlLang: string, url: string, available: bool, current: bool}>
     */
    public static function switcher(string $locale, ?string $pageKey = null, ?string $path = null): array
    {
        $pageKey ??= 'home';
        $path ??= Pages::exists($pageKey) ? Pages::path($pageKey) : '';
        $suffix = $path === '' ? '' : '/'.$path;

        $out = [];

        foreach (self::CODES as $code) {
            $available = self::isTranslated($pageKey, $code);
            $target = $available ? $code : self::DEFAULT;

            $out[] = [
                'code' => $code,
                'label' => (string) trans('site.language.'.$code, [], self::DEFAULT),
                'htmlLang' => self::htmlLang($code),
                'url' => '/'.$target.$suffix,
                'available' => $available,
                'current' => $code === $locale,
            ];
        }

        return $out;
    }

    /**
     * hreflang alternates for SEO.
     *
     * Only locales that actually serve this page are emitted. An alternate for a
     * locale whose copy is not signed off would have to point somewhere — and
     * every candidate is wrong: pointing it at the English URL tells a crawler
     * that the English page *is* the Indonesian version, which is a false claim
     * about what a visitor receives, and the whole reason the sign-off gate
     * exists. Omitting the alternate says "this page has no Indonesian version",
     * which is true. x-default carries the English URL.
     *
     * @return list<array{code: string, htmlLang: string, url: string, available: bool}>
     */
    public static function alternates(string $pageKey, string $path): array
    {
        $suffix = $path === '' ? '' : '/'.$path;
        $out = [];

        foreach (self::CODES as $code) {
            if (! self::isTranslated($pageKey, $code)) {
                continue;
            }

            $out[] = [
                'code' => $code,
                'htmlLang' => self::htmlLang($code),
                'url' => '/'.$code.$suffix,
                'available' => true,
            ];
        }

        return $out;
    }

    /**
     * The x-default alternate: the URL a visitor with no language preference
     * should land on. Always the default locale, which is always served.
     */
    public static function xDefault(string $path): string
    {
        return '/'.self::DEFAULT.($path === '' ? '' : '/'.$path);
    }
}
