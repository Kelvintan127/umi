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
     * Value for <html lang>. The URL segment stays two letters so the route
     * regex constraint holds; only the document attribute expands zh -> zh-Hans.
     */
    public static function htmlLang(string $locale): string
    {
        return $locale === 'zh' ? 'zh-Hans' : $locale;
    }
}
