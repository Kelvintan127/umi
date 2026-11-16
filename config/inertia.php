<?php

/*
|--------------------------------------------------------------------------
| Inertia
|--------------------------------------------------------------------------
|
| SSR enabled. The Node renderer is started with `php artisan inertia:start-ssr`
| and managed by the web server's process supervisor. When the renderer is not
| reachable Inertia falls back to client-side rendering automatically, so a
| renderer outage degrades response quality (no server-rendered head) rather
| than taking the site down.
|
*/

return [

    'ssr' => [
        'enabled' => true,
        'url' => env('INERTIA_SSR_URL', 'http://127.0.0.1:13714'),
        // The renderer is a separate process; a hung one must not pin a PHP
        // worker forever.
        'ensure_bundle_exists' => true,
    ],

    'testing' => [
        'ensure_pages_exist' => true,
        'page_paths' => [
            resource_path('js/pages'),
        ],
        'page_extensions' => ['js', 'jsx', 'svelte', 'ts', 'tsx', 'vue'],
    ],

];
