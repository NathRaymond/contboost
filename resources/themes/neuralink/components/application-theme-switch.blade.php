@if (theme_option('enable_dark_mode', 0) == 1)
    <div class="theme-mode-btn-wrap">
        <a role="button" class="theme-mode [ js-mode-toggle ] theme-mode-{{ (setting('dark_default_theme') == 'dark' && setting('enable_dark_mode') == 1) || request()->cookie('siteMode') === 'dark' ? 'light' : 'dark' }}">
            <i class="an btn-mode"></i>
        </a>
    </div>
@endif
