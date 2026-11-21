<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Every published image/PDF path in the translated site/page copy must map to
 * an actual public file. This prevents the silent broken-gallery regression.
 */
class PublishedContentAssetsTest extends TestCase
{
    public function test_all_published_localized_media_paths_exist(): void
    {
        $missing = [];
        foreach (['en', 'id', 'zh'] as $locale) {
            foreach (['site', 'pages'] as $file) {
                $data = require lang_path($locale.'/'.$file.'.php');
                $visit = function (mixed $value) use (&$visit, &$missing, $locale, $file): void {
                    if (is_array($value)) {
                        foreach ($value as $child) {
                            $visit($child);
                        }
                        return;
                    }
                    if (is_string($value) && str_starts_with($value, '/images/')) {
                        $public = public_path(ltrim($value, '/'));
                        if (! is_file($public)) {
                            $missing[] = $locale.'/'.$file.': '.$value;
                        }
                    }
                };
                $visit($data);
            }
        }
        $this->assertSame([], $missing, "Published media paths missing:\n".implode("\n", $missing));
    }
}
