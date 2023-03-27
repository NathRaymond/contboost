<div class="container-fluid p-0">
    <div class="header-content-wrapper">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div class="header-left-content d-flex">
                <div class="main-logo">
                    <a class="navbar-brand" href="{{ route('front.index') }}">
                        <x-application-logo />
                    </a>
                </div>
                <form class="search-bar d-flex d-none d-lg-block d-md-block" method="get"
                    action="{{ route('document.index') }}">
                    <button type="submit" class="btn" role="button">
                        <i class="an an-search"></i>
                    </button>
                    <input class="form-control" name="q" type="search" placeholder="@lang('common.searchStr')"
                        aria-label="@lang('common.search')" value="{{ request()->get('q') ?? old('q') }}" />
                </form>
            </div>
            <div class="collapse navbar-collapse" id="navbarMenu">
                {!! menu(setting('_document_menu', null), 'bootstrap', ['icon' => true]) !!}
            </div>
            <div class="header-right-content d-flex align-items-center">
                @if (theme_option('enable_dark_mode', 0) == 1)
                    <div class="header-right-option">
                        <a role="button"
                            class="theme-mode [ js-mode-toggle ] theme-mode-{{ (setting('dark_default_theme') == 'dark' && setting('enable_dark_mode') == 1) || request()->cookie('siteMode') === 'dark' ? 'light' : 'dark' }}">
                            <i class="an btn-mode"></i>
                        </a>
                    </div>
                @endif
                @auth
                    <x-application-user-nav :user="auth()->user()" />
                @endauth
            </div>
        </div>
    </div>
</div>
