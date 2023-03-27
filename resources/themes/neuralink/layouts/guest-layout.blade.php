<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="@lang('front.direction')"
    theme-mode="{{ (setting('dark_default_theme') == 'dark' && setting('enable_dark_mode') == 1) || request()->cookie('siteMode') === 'dark' ? 'dark' : 'light' }}">


<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    @vite(['resources/themes/neuralink/assets/sass/app.scss', 'resources/themes/neuralink/assets/js/app.js'])
    @meta_tags()
</head>

<body class="auth-body">
    <main class="main-wrapper">
        <div class="signin-container">
            <div class="signin-main">
                {{ $slot }}
            </div>
        </div>
    </main>
    <x-application-cookies-consent />
    @meta_tags('footer')
</body>

</html>
