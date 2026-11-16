<?php

/*
|--------------------------------------------------------------------------
| Metadata SEO (Indonesia) —
| UNREVIEWED id draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| Draft terjemahan tanpa tinjauan perusahaan. Struktur kunci identik dengan
| lang/en/seo.php; hanya nilai yang diterjemahkan. Kode bahasa pada
| 'alternates' dan nilai Open Graph adalah nilai teknis, bukan teks yang
| ditampilkan, sehingga dibiarkan apa adanya.
|
*/

return [

    'defaults' => [
        'title' => 'UMI Stamping — Produsen Stamping Logam Presisi',
        'description' => 'PT. Uni-Metaltech Industry (UMI Stamping) adalah produsen stamping logam presisi di Batam, Indonesia, yang melayani industri kelistrikan, elektronik, dan otomotif.',
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
