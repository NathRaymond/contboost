<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="@lang('front.direction')"
    theme-mode="{{ (setting('dark_default_theme') == 'dark' && setting('enable_dark_mode') == 1) || request()->cookie('siteMode') === 'dark' ? 'dark' : 'light' }}">


<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    @vite(['resources/themes/neuralink/assets/sass/app.scss', 'resources/themes/neuralink/assets/sass/editor.scss', 'resources/themes/neuralink/assets/js/app.js', 'resources/themes/neuralink/assets/js/editor.js'])
    @meta_tags()
</head>

<body>
    <main class="main-wrapper">
        <div class="ai-app-dashboard">
            <x-document-header />
            {{ $slot }}
        </div>
    </main>
    <x-document-footer />
    <x-application-cookies-consent />
    <x-application-messages />
    <x-application-loader />
    @stack('page_scripts')
</body>

</html>
