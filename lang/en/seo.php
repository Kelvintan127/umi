<?php

/*
|--------------------------------------------------------------------------
| SEO metadata — English source locale
|--------------------------------------------------------------------------
|
| Kept in its own file because these four groups (page title, page
| description, the site-level defaults, and the Open Graph block) are the
| complete set of tag-bearing strings; the per-page copies live in pages.php.
|
*/

return [

    'defaults' => [
        'title' => 'UMI Stamping — Precision Metal Stamping Manufacturer',
        'description' => 'PT. Uni-Metaltech Industry (UMI Stamping) is a precision metal stamping manufacturer in Batam, Indonesia, serving electrical, electronic and automotive industries.',
        'og_image' => '/images/hero/factory.jpg',
    ],

    'og' => [
        'type' => 'website',
        'site_name' => 'UMI Stamping',
    ],

    'alternates' => [
        'hreflang' => [
            'en' => 'en',
            'id' => 'id',
            'zh' => 'zh-Hans',
        ],
        'x_default' => 'en',
    ],

];
