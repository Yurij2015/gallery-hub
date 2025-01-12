<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GalleryHub</title>
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/x-icon">
    <!-- Styles / Scripts -->
    @stack('head-scripts')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="dark:bg-gray-800">
@include('layouts.client-navbar-main')
<main class="bg-gray-50 dark:bg-gray-900">
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50  dark:bg-gray-900">
            @yield('content')
            @yield('footer')
            <!-- Footer Scripts -->
            @stack('scripts')
        </div>
    </div>
</main>
</body>
</html>
