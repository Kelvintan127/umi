<!DOCTYPE html>
<html lang="{{ $page['props']['htmlLang'] ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ $page['props']['title'] ?? config('app.name') }}</title>
    @vite(['resources/js/app.tsx'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
