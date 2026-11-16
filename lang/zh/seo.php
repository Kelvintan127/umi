<?php

/*
|--------------------------------------------------------------------------
| Metadata SEO（简体中文）——
| UNREVIEWED zh draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| 未经公司审阅的翻译草稿。键结构与 lang/en/seo.php 完全一致，仅翻译取值。
| 'alternates' 中的语言代码与 Open Graph 的取值属于技术值，不是展示文本，
| 因此保持原样。
|
*/

return [

    'defaults' => [
        'title' => 'UMI Stamping — 精密金属冲压制造商',
        'description' => 'PT. Uni-Metaltech Industry（UMI Stamping）是位于印度尼西亚 Batam 的精密金属冲压制造商，服务于电气、电子和汽车行业。',
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
