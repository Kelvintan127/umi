<!DOCTYPE html>
<html lang="{{ $page['props']['htmlLang'] ?? 'en' }}" dir="{{ $page['props']['dir'] ?? 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--
        No <title> here on purpose: pages emit theirs through Inertia's <Head>,
        which is server-rendered below by @inertiaHead. A static title element
        here would ship a second, wrong <title> on every page.
    --}}

    <link rel="icon" href="/favicon.ico" sizes="any">

    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body class="bg-white text-ink antialiased">
    @inertia
</body>
</html>
