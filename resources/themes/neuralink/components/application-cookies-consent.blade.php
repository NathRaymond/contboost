@if (config('artisan.enabled_cookie_consent', false) && !request()->cookie('airobo'))
    <div class="js-cookie-consent cookie-consent-banner shadow-lg">
        <div class="cookie-consent-banner__inner">
            <div class="cookie-consent-banner__copy">
                <div class="cookie-consent-banner__header">@lang('common.weUseCookies')</div>
                <div class="cookie-consent-banner__description">{!! __('common.cookieConsentMessage') !!}</div>
            </div>
            <div class="cookie-consent-banner__actions">
                <x-button class="btn-success js-cookie-consent-agree cookie-consent__agree">
                    {{ __('common.cookieConsentButton') }}
                </x-button>
            </div>
        </div>
    </div>
    @push('page_scripts')
        <script>
            window.CookieConsent = (function() {
                const COOKIE_VALUE = 1;
                const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

                function consentWithCookies() {
                    setCookie('{{ config('artisan.cookie_name') }}', COOKIE_VALUE,
                        {{ config('artisan.cookie_lifetime') }});
                    hideCookieDialog();
                }

                function cookieExists(name) {
                    return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
                }

                function hideCookieDialog() {
                    const dialogs = document.getElementsByClassName('js-cookie-consent');
                    for (let i = 0; i < dialogs.length; ++i) {
                        dialogs[i].style.display = 'none';
                    }
                }

                function setCookie(name, value, expirationInDays) {
                    const date = new Date();
                    date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                    document.cookie = name + '=' + value +
                        ';expires=' + date.toUTCString() +
                        ';domain=' + COOKIE_DOMAIN +
                        ';path=/{{ config('session.secure') ? ';secure' : null }}' +
                        '{{ config('session.same_site') ? ';samesite=' . config('session.same_site') : null }}';
                }
                if (cookieExists('{{ config('artisan.cookie_name') }}')) {
                    hideCookieDialog();
                }
                const buttons = document.getElementsByClassName('js-cookie-consent-agree');
                for (let i = 0; i < buttons.length; ++i) {
                    buttons[i].addEventListener('click', consentWithCookies);
                }

                return {
                    consentWithCookies: consentWithCookies,
                    hideCookieDialog: hideCookieDialog
                };
            })();
        </script>
    @endpush
@endif
