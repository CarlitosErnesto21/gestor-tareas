<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @if(app()->environment('production'))
            @php
                $manifestPath = public_path('build/.vite/manifest.json');
                if(file_exists($manifestPath)) {
                    $manifest = json_decode(file_get_contents($manifestPath), true);
                    $entrypoint = $manifest['resources/js/app.js'];
                    $cssFiles = $entrypoint['css'] ?? [];
                    $jsFile = $entrypoint['file'];
                    $vendorFile = $manifest['_vendor-CPZB69Mu.js']['file'] ?? null;
                } else {
                    $cssFiles = [];
                    $jsFile = null;
                    $vendorFile = null;
                }
            @endphp
            @foreach($cssFiles as $cssFile)
                <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
            @endforeach
            @if($vendorFile)
                <script type="module" src="{{ asset('build/' . $vendorFile) }}"></script>
            @endif
            @if($jsFile)
                <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
            @endif
        @else
            @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @endif
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
