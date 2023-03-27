<nav class="navbar navbar-expand-lg top-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('front.index') }}">
            <x-application-logo />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            {!! menu(setting('_main_menu', 'Main Menu'), 'bootstrap', ['icon' => true]) !!}
        </div>
        @auth
            <div class="header-right-content d-flex align-items-center">
                <x-application-user-nav :user="auth()->user()" />
            </div>
        @endauth
    </div>
</nav>
