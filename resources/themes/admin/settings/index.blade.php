<x-app-layout>
    <form id="settingsForm" class="" action="{{ route('admin.settings.update') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="row settings-tabs invisible">
            <div class="col-md-2">
                <ul class="nav flex-column verticle-tabs" id="leftTabs" role="tablist">
                    <li class="nav-title">@lang('settings.applicationManagement')</li>
                    <li class="nav-item">
                        <a href="#general" class="nav-link active" data-coreui-toggle="tab"
                            data-coreui-target="#general" role="tab" aria-controls="nav-home" aria-selected="true">
                            <span></span>@lang('settings.general')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#usersTab" class="nav-link" data-coreui-toggle="tab" data-coreui-target="#usersTab"
                            role="tab" aria-controls="nav-home" aria-selected="false">
                            <span></span>@lang('admin.users')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#footerTab" class="nav-link" data-coreui-toggle="tab" data-coreui-target="#footerTab"
                            role="tab" aria-controls="nav-home" aria-selected="false">
                            <span></span>@lang('admin.footer')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#uploads" class="nav-link" data-coreui-toggle="tab" data-coreui-target="#uploads"
                            role="tab" aria-controls="nav-home" aria-selected="false">
                            <span></span>@lang('settings.uploads')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#mail" class="nav-link" data-coreui-toggle="tab" data-coreui-target="#mail"
                            role="tab" aria-controls="nav-home" aria-selected="false">
                            <span></span>@lang('settings.mail')
                        </a>
                    </li>
                    @if (!empty($theme_file))
                        <li class="nav-item">
                            <a href="#themeOptions" class="nav-link" data-coreui-toggle="tab"
                                data-coreui-target="#themeOptions" role="tab" aria-controls="nav-home"
                                aria-selected="false">
                                <span></span>@lang('settings.themeOptions')
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#paymentGateways" class="nav-link" data-coreui-toggle="tab"
                            data-coreui-target="#paymentGateways" role="tab" aria-controls="nav-home"
                            aria-selected="false">
                            <span></span>@lang('settings.paymentGateways')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#usecasesTab" class="nav-link" data-coreui-toggle="tab"
                            data-coreui-target="#usecasesTab" role="tab" aria-controls="nav-home"
                            aria-selected="false">
                            <span></span>@lang('settings.usecases')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#advance" class="nav-link" data-coreui-toggle="tab" data-coreui-target="#advance"
                            role="tab" aria-controls="nav-home" aria-selected="false">
                            <span></span>@lang('settings.advance')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#maintenanceMode" class="nav-link" data-coreui-toggle="tab"
                            data-coreui-target="#maintenanceMode" role="tab" aria-controls="nav-home"
                            aria-selected="false">
                            <span></span>@lang('settings.maintenance')
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="tab-content tab-main bg-white rounded-4 p-3">
                    <div id="general" class="tab-pane tab-parent fade show active">
                        <h1 class="h4">@lang('settings.generalSettings')</h1>
                        <ul class="nav">
                            <li class="nav-item"><a href="#generalTab" class="nav-link active"
                                    data-coreui-toggle="tab">@lang('settings.general')</a></li>
                            <li class="nav-item"><a href="#loginConfig" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.login')</a></li>
                            <li class="nav-item"><a href="#integration" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.integration')</a></li>
                            {{-- <li class="nav-item"><a href="#recaptchaTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.reCAPTCHA')</a></li> --}}
                            <li class="nav-item"><a href="#viewsTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.views')</a>
                            </li>
                            <li class="nav-item"><a href="#currencyTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.currency')</a>
                            </li>
                            <li class="nav-item"><a href="#webmasterTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.webmaster')</a>
                            </li>
                            <li class="nav-item"><a href="#layoutTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.layouts')</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="generalTab" class="tab-pane fade show active">
                                <div class="form-group mb-3 row">
                                    <label for="app_name" class="col-md-3 form-label">@lang('settings.siteName')</label>
                                    <div class="col-md-9">
                                        <input id="app_name" type="text"
                                            class="form-control @error('settings.app_name') is-invalid @enderror"
                                            name="settings[app_name]"
                                            value="{{ setting('app_name') ?? old('settings.app_name') }}">
                                        @error('settings.app_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="website_email" class="col-md-3 form-label">@lang('settings.siteEmail')</label>
                                    <div class="col-md-9">
                                        <input id="website_email" type="text"
                                            class="form-control @error('settings.website_email') is-invalid @enderror"
                                            name="settings[website_email]"
                                            value="{{ setting('website_email') ?? old('settings.website_email') }}">
                                        @error('settings.website_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="website_contact_number"
                                        class="col-md-3 form-label">@lang('settings.siteContact')</label>
                                    <div class="col-md-9">
                                        <input id="website_contact_number" type="text"
                                            class="form-control @error('settings.website_contact_number') is-invalid @enderror"
                                            name="settings[website_contact_number]"
                                            value="{{ setting('website_contact_number') ?? old('settings.website_contact_number') }}">
                                        <span class="help-block text-muted small">@lang('settings.siteContactHelp')</span>
                                        @error('settings.siteContact')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="app_url" class="col-md-3 form-label">@lang('settings.siteUrl')</label>
                                    <div class="col-md-9">
                                        <input id="app_url" type="text"
                                            class="form-control @error('settings.app_url') is-invalid @enderror"
                                            name="settings[app_url]"
                                            value="{{ setting('app_url') ?? old('settings.app_url') }}">
                                        @error('settings.app_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="website_logo" class="col-md-3 form-label">@lang('settings.siteLogoLight')</label>
                                    <div class="col-md-3">
                                        <input id="website_logo" type="file"
                                            class="form-control @error('settings.website_logo') is-invalid @enderror"
                                            name="settings[website_logo]">
                                        @error('settings.website_logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if (!empty(setting('website_logo')))
                                        <div class="col-md-6">
                                            <a href="{{ url(setting('website_logo')) }}" target="_blank">
                                                <img src="{{ url(setting('website_logo')) }}" height="59"
                                                    alt="{{ setting('app_name') }}">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="website_logo_dark"
                                        class="col-md-3 form-label">@lang('settings.siteLogoDark')</label>
                                    <div class="col-md-3">
                                        <input id="website_logo_dark" type="file"
                                            class="form-control @error('settings.website_logo_dark') is-invalid @enderror"
                                            name="settings[website_logo_dark]">
                                        @error('settings.website_logo_dark')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if (!empty(setting('website_logo_dark')))
                                        <div class="col-md-6">
                                            <a href="{{ url(setting('website_logo_dark')) }}" target="_blank">
                                                <img src="{{ url(setting('website_logo_dark')) }}" height="59"
                                                    alt="{{ setting('app_name') }}">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="website_login_logo"
                                        class="col-md-3 form-label">@lang('settings.siteLoginLogo')</label>
                                    <div class="col-md-3">
                                        <input id="website_login_logo" type="file"
                                            class="form-control @error('settings.website_login_logo') is-invalid @enderror"
                                            name="settings[website_login_logo]">
                                        @error('settings.website_login_logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if (!empty(setting('website_login_logo')))
                                        <div class="col-md-6">
                                            <a href="{{ url(setting('website_login_logo')) }}" target="_blank">
                                                <img src="{{ url(setting('website_login_logo')) }}" height="30"
                                                    alt="{{ setting('app_name') }}">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="favicon" class="col-md-3 form-label">@lang('settings.siteFavicon')</label>
                                    <div class="col-md-3">
                                        <input id="favicon" type="file"
                                            class="form-control @error('settings.favicon') is-invalid @enderror"
                                            name="settings[favicon]">
                                        @error('settings.favicon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @if (!empty(setting('favicon')))
                                        <div class="col-md-6">
                                            <a href="{{ url(setting('favicon')) }}" target="_blank">
                                                <img src="{{ url(setting('favicon')) }}" height="16"
                                                    alt="{{ setting('app_name') ?? '' }}">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                @if ($pages)
                                    <div class="form-group mb-3 row">
                                        <label for="terms_link" class="col-md-3 form-label">@lang('settings.termsLink')</label>
                                        <div class="col-md-9">
                                            <select
                                                class="form-control @error('settings.terms_link') is-invalid @enderror"
                                                name="settings[terms_link]" id="terms_link">
                                                <option value="">@lang('common.selectOne')</option>
                                                @foreach ($pages as $page)
                                                    <option value="{{ $page->slug }}"
                                                        @if ($page->slug == setting('terms_link')) selected @endif>
                                                        {{ $page->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('settings.terms_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="privacy_link"
                                            class="col-md-3 form-label">@lang('settings.privacyLink')</label>
                                        <div class="col-md-9">
                                            <select
                                                class="form-control @error('settings.privacy_link') is-invalid @enderror"
                                                name="settings[privacy_link]" id="privacy_link">
                                                <option value="">@lang('common.selectOne')</option>
                                                @foreach ($pages as $page)
                                                    <option value="{{ $page->slug }}"
                                                        @if ($page->slug == setting('privacy_link')) selected @endif>
                                                        {{ $page->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('settings.privacy_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                @if (isset($locales))
                                    <div class="form-group mb-3 row">
                                        <label for="default_locale"
                                            class="col-md-3 form-label">@lang('settings.defaultAdminLanguage')</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="settings[default_locale]"
                                                id="default_locale">
                                                <option value="">@lang('common.selectOne')</option>
                                                @foreach ($locales as $lang)
                                                    <option value="{{ $lang->locale }}"
                                                        @if ($lang->locale == setting('default_locale')) selected @endif>
                                                        {{ $lang->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('settings.default_locale')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group mb-3 row">
                                    <label for="meta_title" class="col-md-3 form-label">@lang('settings.metaTitle')</label>
                                    <div class="col-md-9">
                                        <input id="meta_title" type="text"
                                            class="form-control @error('settings.meta_title') is-invalid @enderror"
                                            name="settings[meta_title]"
                                            value="{{ setting('meta_title') ?? old('settings.meta_title') }}">
                                        @error('settings.meta_title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="meta_description"
                                        class="col-md-3 form-label">@lang('settings.metaDescription')</label>
                                    <div class="col-md-9">
                                        <input id="meta_description" type="text"
                                            class="form-control @error('settings.meta_description') is-invalid @enderror"
                                            name="settings[meta_description]"
                                            value="{{ setting('meta_description') ?? old('settings.meta_description') }}">
                                        @error('settings.meta_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="privacy_link" class="col-md-3 form-label">@lang('settings.systemTimezone')</label>
                                    <div class="col-md-9">
                                        <select
                                            class="form-control @error('settings.SYSTEM_TIMEZONE') is-invalid @enderror"
                                            name="settings[SYSTEM_TIMEZONE]" id="SYSTEM_TIMEZONE">
                                            <option value="">@lang('common.selectOne')</option>
                                            @foreach (timezones_list() as $key => $timezone)
                                                <option value="{{ $key }}"
                                                    @if ($key == setting('SYSTEM_TIMEZONE')) selected @endif>
                                                    {{ $timezone }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('settings.SYSTEM_TIMEZONE')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="date_format" class="col-md-3 form-label">@lang('settings.dateFormat')</label>
                                    <div class="col-md-9">
                                        <input id="date_format" type="text"
                                            class="form-control @error('settings.date_format') is-invalid @enderror"
                                            name="settings[date_format]" value="{{ setting('date_format') ?? '' }}">
                                        @error('settings.date_format')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span
                                            class="help-block text-muted small">{{ now()->format(setting('date_format', 'm-d-Y')) }}
                                            <a href="https://www.php.net/manual/en/function.date.php"
                                                target="_blank">@lang('settings.dateFormatHelp')</a></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="joined_date_format"
                                        class="col-md-3 form-label">@lang('settings.joinedDateFormat')</label>
                                    <div class="col-md-9">
                                        <input id="joined_date_format" type="text"
                                            class="form-control @error('settings.joined_date_format') is-invalid @enderror"
                                            name="settings[joined_date_format]"
                                            value="{{ setting('joined_date_format') ?? '' }}">
                                        @error('settings.joined_date_format')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span
                                            class="help-block text-muted small">{{ now()->format(setting('joined_date_format', 'm-d-Y')) }}
                                            <a href="https://www.php.net/manual/en/function.date.php"
                                                target="_blank">@lang('settings.dateFormatHelp')</a></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="datetime_format"
                                        class="col-md-3 form-label">@lang('settings.dateTimeFormat')</label>
                                    <div class="col-md-9">
                                        <input id="datetime_format" type="text"
                                            class="form-control @error('settings.datetime_format') is-invalid @enderror"
                                            name="settings[datetime_format]"
                                            value="{{ setting('datetime_format') ?? '' }}">
                                        @error('settings.datetime_format')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span
                                            class="help-block text-muted small">{{ now()->format(setting('datetime_format', 'F d, Y h:i a')) }}
                                            <a href="https://www.php.net/manual/en/function.date.php"
                                                target="_blank">@lang('settings.dateTimeFormatHelp')</a></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="purchase_code" class="col-md-3 form-label">@lang('settings.purchaseCode')</label>
                                    <div class="col-md-9">
                                        <input id="purchase_code" type="text"
                                            class="form-control @error('settings.purchase_code') is-invalid @enderror"
                                            name="settings[purchase_code]"
                                            value="{{ setting('purchase_code') ?? '' }}">
                                        @error('settings.purchase_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block text-muted small">@lang('settings.purchaseCodeHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div id="loginConfig" class="tab-pane fade">
                                {{-- <div class="form-group mb-3 row">
                                    <label for="auth_pages_image"
                                        class="col-md-3 form-label">@lang('settings.loginBG')</label>
                                    <div class="col-md-6">
                                        <input id="auth_pages_image" type="file"
                                            class="form-control @error('settings.auth_pages_image') is-invalid @enderror"
                                            name="settings[auth_pages_image]">
                                        @error('settings.auth_pages_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block text-muted small">@lang('settings.loginBGHelp')</span>
                                    </div>
                                    @if (!empty(setting('auth_pages_image')))
                                        <div class="col-md-3">
                                            <div class="position-reletive">
                                                <a href="{{ url(setting('auth_pages_image')) }}" target="_blank">
                                                    <img src="{{ url(setting('auth_pages_image')) }}" height="75"
                                                        alt="@lang('settings.loginBG')">
                                                </a>
                                                <label for="delete_auth_pages_image" class="removeBtn"
                                                    role="button">@lang('common.delete')</label>
                                                <input type="checkbox" name="settings[delete_auth_pages_image]"
                                                    id="delete_auth_pages_image" class="d-none delete-box"
                                                    value="1">
                                            </div>
                                        </div>
                                    @endif
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>@lang('settings.facebook')</h5>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="FB_ID" class="col-md-3 form-label">@lang('settings.appID')</label>
                                    <div class="col-md-9">
                                        <input id="FB_ID" type="text"
                                            class="form-control @error('settings.FB_ID') is-invalid @enderror"
                                            name="settings[FB_ID]" value="{{ setting('FB_ID') ?? '' }}">
                                        @error('settings.FB_ID')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="FB_SECRET" class="col-md-3 form-label">@lang('settings.appSecret')</label>
                                    <div class="col-md-9">
                                        <input id="FB_SECRET" type="text"
                                            class="form-control @error('settings.FB_SECRET') is-invalid @enderror"
                                            name="settings[FB_SECRET]" value="{{ setting('FB_SECRET') ?? '' }}">
                                        @error('settings.FB_SECRET')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-3">
                                        <label for="FB_REDIRECT" class="form-label">@lang('settings.callbackURL')</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="FB_REDIRECT" name="settings[FB_REDIRECT]"
                                            class="form-control"
                                            value="{{ route('social.handle', ['provider' => 'facebook']) }}" readonly>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>@lang('settings.google')</h5>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="GOOGLE_ID" class="col-md-3 form-label">@lang('settings.appID')</label>
                                    <div class="col-md-9">
                                        <input id="GOOGLE_ID" type="text"
                                            class="form-control @error('settings.GOOGLE_ID') is-invalid @enderror"
                                            name="settings[GOOGLE_ID]" value="{{ setting('GOOGLE_ID') ?? '' }}">
                                        @error('settings.GOOGLE_ID')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="GOOGLE_SECRET" class="col-md-3 form-label">@lang('settings.appSecret')</label>
                                    <div class="col-md-9">
                                        <input id="GOOGLE_SECRET" type="text"
                                            class="form-control @error('settings.GOOGLE_SECRET') is-invalid @enderror"
                                            name="settings[GOOGLE_SECRET]"
                                            value="{{ setting('GOOGLE_SECRET') ?? '' }}">
                                        @error('settings.GOOGLE_SECRET')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-3">
                                        <label for="GOOGLE_REDIRECT" class="form-label">@lang('settings.callbackURL')</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="GOOGLE_REDIRECT" name="settings[GOOGLE_REDIRECT]"
                                            class="form-control"
                                            value="{{ route('social.handle', ['provider' => 'google']) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div id="integration" class="tab-pane fade">
                                <div class="form-group mb-3 row">
                                    <label for="enable_header_code"
                                        class="col-md-3 form-label">@lang('settings.enableHeadCode')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('settings.enable_header_code') is-invalid @enderror"
                                                id="enable_header_code" name="settings[enable_header_code]"
                                                value="1"
                                                {{ setting('enable_header_code') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="enable_footer_code"
                                        class="col-md-3 form-label">@lang('settings.enableFooterCode')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('enable_footer_code') is-invalid @enderror"
                                                id="enable_footer_code" name="settings[enable_footer_code]"
                                                value="1"
                                                {{ setting('enable_footer_code') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="header_code" class="col-md-3 form-label">@lang('settings.headCode')</label>
                                    <div class="col-md-9">
                                        <textarea id="header_code" type="text" rows="9"
                                            class="form-control @error('settings.header_code') is-invalid @enderror" name="settings[header_code]">{{ setting('header_code') ?? '' }}</textarea>
                                        @error('settings.header_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block text-muted small">@lang('settings.headCodeHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="footer_code" class="col-md-3 form-label">@lang('settings.footerCode')</label>
                                    <div class="col-md-9">
                                        <textarea id="footer_code" type="text" rows="9"
                                            class="form-control @error('settings.footer_code') is-invalid @enderror" name="settings[footer_code]">{{ setting('footer_code') ?? '' }}</textarea>
                                        @error('settings.footer_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block text-muted small">@lang('settings.footerCodeHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div id="recaptchaTab" class="tab-pane fade">
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_status"
                                        class="col-md-3 form-label">@lang('settings.enablereCAPTCHA')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('recaptcha_status') is-invalid @enderror"
                                                id="recaptcha_status" name="settings[recaptcha_status]"
                                                value="1" {{ setting('recaptcha_status') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_site" class="col-md-3 form-label">@lang('settings.reCAPTCHASiteKey')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <input id="recaptcha_site" type="text"
                                            class="form-control @error('settings.recaptcha_site') is-invalid @enderror"
                                            name="settings[recaptcha_site]"
                                            value="{{ setting('recaptcha_site') ?? old('settings.recaptcha_site') }}">
                                        @error('settings.recaptcha_site')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_secret"
                                        class="col-md-3 form-label">@lang('settings.reCAPTCHASecretKey')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <input id="recaptcha_secret" type="text"
                                            class="form-control @error('settings.recaptcha_secret') is-invalid @enderror"
                                            name="settings[recaptcha_secret]"
                                            value="{{ setting('recaptcha_secret') ?? old('settings.recaptcha_secret') }}">
                                        @error('settings.recaptcha_secret')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_login"
                                        class="col-md-3 form-label">@lang('settings.reCAPTCHAOnLogin')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('recaptcha_login') is-invalid @enderror"
                                                id="recaptcha_login" name="settings[recaptcha_login]" value="1"
                                                {{ setting('recaptcha_login') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_signup"
                                        class="col-md-3 form-label">@lang('settings.reCAPTCHAOnSignup')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('recaptcha_signup') is-invalid @enderror"
                                                id="recaptcha_signup" name="settings[recaptcha_signup]"
                                                value="1" {{ setting('recaptcha_signup') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_contact"
                                        class="col-md-3 form-label">@lang('settings.reCAPTCHAOnContact')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('recaptcha_contact') is-invalid @enderror"
                                                id="recaptcha_contact" name="settings[recaptcha_contact]"
                                                value="1"
                                                {{ setting('recaptcha_contact') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="recaptcha_on_admin_login"
                                        class="col-md-3 form-label">@lang('settings.reCAPTCHAOnAdminLogin')</label>
                                    <div class="col-md-9" data-conditional-name="settings[recaptcha_status]"
                                        data-conditional-value="1">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input
                                                class="switch-input @error('recaptcha_on_admin_login') is-invalid @enderror"
                                                id="recaptcha_on_admin_login"
                                                name="settings[recaptcha_on_admin_login]" value="1"
                                                {{ setting('recaptcha_on_admin_login') == 1 ? 'checked' : '' }}
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="viewsTab" class="tab-pane fade">
                                <div class="form-group mb-3 row">
                                    <label for="page_views" class="col-md-3 form-label">@lang('settings.pageViews')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('page_views') is-invalid @enderror"
                                                id="page_views" name="settings[page_views]" value="1"
                                                {{ setting('page_views') == 1 ? 'checked' : '' }} type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="tags_views" class="col-md-3 form-label">@lang('settings.tagsViews')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('tags_views') is-invalid @enderror"
                                                id="tags_views" name="settings[tags_views]" value="1"
                                                {{ setting('tags_views') == 1 ? 'checked' : '' }} type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="post_views" class="col-md-3 form-label">@lang('settings.postViews')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('post_views') is-invalid @enderror"
                                                id="post_views" name="settings[post_views]" value="1"
                                                {{ setting('post_views') == 1 ? 'checked' : '' }} type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="currencyTab" class="tab-pane fade">
                                <div class="form-group mb-3 row">
                                    <label for="currency" class="col-md-3 form-label">@lang('settings.currency')</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="settings[currency]" id="public_user_role">
                                            <option value="">@lang('common.selectOne')</option>
                                            @foreach ($currencies as $key => $currency)
                                                <option value="{{ $key }}"
                                                    @if ($key == setting('currency', 'USD')) selected @endif>
                                                    {{ $currency['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="help-block text-muted small">@lang('settings.currencyHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div id="webmasterTab" class="tab-pane fade">
                                <div class="form-group mb-3 row">
                                    <label for="google_analytics_id"
                                        class="col-md-3 form-label">@lang('settings.googleAnalytics')</label>
                                    <div class="col-md-9">
                                        <input id="google_analytics_id" type="text"
                                            class="form-control @error('settings.google_analytics_id') is-invalid @enderror"
                                            name="settings[google_analytics_id]"
                                            value="{{ setting('google_analytics_id') ?? '' }}">
                                        @error('settings.google_analytics_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block text-muted small">@lang('settings.googleAnalyticsHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="google_webmaster"
                                        class="col-md-3 form-label">@lang('settings.googleWebmaster')</label>
                                    <div class="col-md-9">
                                        <input id="google_webmaster" type="text"
                                            class="form-control @error('settings.google_webmaster') is-invalid @enderror"
                                            name="settings[google_webmaster]"
                                            value="{{ setting('google_webmaster') ?? old('settings.google_webmaster') }}">
                                        <span class="help-block text-muted small">@lang('settings.googleWebmasterHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="yandex_webmaster"
                                        class="col-md-3 form-label">@lang('settings.yandexWebmaster')</label>
                                    <div class="col-md-9">
                                        <input id="yandex_webmaster" type="text"
                                            class="form-control @error('settings.yandex_webmaster') is-invalid @enderror"
                                            name="settings[yandex_webmaster]"
                                            value="{{ setting('yandex_webmaster') ?? old('settings.yandex_webmaster') }}">
                                        <span class="help-block text-muted small">@lang('settings.yandexWebmasterHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="bing_webmaster" class="col-md-3 form-label">@lang('settings.bingWebmaster')</label>
                                    <div class="col-md-9">
                                        <input id="bing_webmaster" type="text"
                                            class="form-control @error('settings.bing_webmaster') is-invalid @enderror"
                                            name="settings[bing_webmaster]"
                                            value="{{ setting('bing_webmaster') ?? old('settings.bing_webmaster') }}">
                                        <span class="help-block text-muted small">@lang('settings.bingWebmasterHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="pintrest_webmaster"
                                        class="col-md-3 form-label">@lang('settings.pintrestWebmaster')</label>
                                    <div class="col-md-9">
                                        <input id="pintrest_webmaster" type="text"
                                            class="form-control @error('settings.pintrest_webmaster') is-invalid @enderror"
                                            name="settings[pintrest_webmaster]"
                                            value="{{ setting('pintrest_webmaster') ?? old('settings.pintrest_webmaster') }}">
                                        <span class="help-block text-muted small">@lang('settings.pintrestWebmasterHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label for="alexa_webmaster"
                                        class="col-md-3 form-label">@lang('settings.alexaWebmaster')</label>
                                    <div class="col-md-9">
                                        <input id="alexa_webmaster" type="text"
                                            class="form-control @error('settings.alexa_webmaster') is-invalid @enderror"
                                            name="settings[alexa_webmaster]"
                                            value="{{ setting('alexa_webmaster') ?? old('settings.alexa_webmaster') }}">
                                        <span class="help-block text-muted small">@lang('settings.alexaWebmasterHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div id="layoutTab" class="tab-pane fade">
                                <div class="form-group row mb-3">
                                    <label for="append_sitename"
                                        class="col-md-3 form-label">@lang('settings.appendSitename')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('append_sitename') is-invalid @enderror"
                                                id="append_sitename" name="settings[append_sitename]"
                                                @if (setting('append_sitename', 1) == 1) checked @endif value="1"
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                        <span class="help-block text-muted small d-block">@lang('settings.appendSitenameHelp')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="uploads" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.uploadsSettings')</h1>
                        <p>@lang('settings.uploadsSettingsDesc')</p>
                        <div class="form-group mb-3 row">
                            <label for="FILESYSTEM_DRIVER" class="col-md-3 col-form-label">@lang('settings.uploadsStorageMethod')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="settings[FILESYSTEM_DRIVER]"
                                    id="FILESYSTEM_DRIVER">
                                    <option value="public" @if ('public' == setting('FILESYSTEM_DRIVER') || old('settings.FILESYSTEM_DRIVER') == 'public') selected @endif>Local
                                        Disk(defalut)</option>
                                    <option value="s3" @if ('s3' == setting('FILESYSTEM_DRIVER') || old('settings.FILESYSTEM_DRIVER') == 's3') selected @endif>Amazon
                                        S3
                                    </option>
                                    <option value="wasabi" @if ('wasabi' == setting('FILESYSTEM_DRIVER') || old('settings.FILESYSTEM_DRIVER') == 'wasabi') selected @endif>Wasabi
                                    </option>
                                </select>
                                @error('settings.FILESYSTEM_DRIVER')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="AWS_ACCESS_KEY_ID" class="col-md-3">@lang('settings.amazonS3Key')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="s3">
                                <input id="AWS_ACCESS_KEY_ID" type="text"
                                    class="form-control @error('settings.AWS_ACCESS_KEY_ID') is-invalid @enderror"
                                    name="settings[AWS_ACCESS_KEY_ID]"
                                    value="{{ setting('AWS_ACCESS_KEY_ID') ?? '' }}">
                                @error('settings.AWS_ACCESS_KEY_ID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="AWS_SECRET_ACCESS_KEY" class="col-md-3">@lang('settings.amazonS3Secret')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="s3">
                                <input id="AWS_SECRET_ACCESS_KEY" type="text"
                                    class="form-control @error('settings.AWS_SECRET_ACCESS_KEY') is-invalid @enderror"
                                    name="settings[AWS_SECRET_ACCESS_KEY]"
                                    value="{{ setting('AWS_SECRET_ACCESS_KEY') ?? '' }}">
                                @error('settings.AWS_SECRET_ACCESS_KEY')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="AWS_DEFAULT_REGION" class="col-md-3">@lang('settings.amazonS3Region')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="s3">
                                <input id="AWS_DEFAULT_REGION" type="text"
                                    class="form-control @error('settings.AWS_DEFAULT_REGION') is-invalid @enderror"
                                    name="settings[AWS_DEFAULT_REGION]"
                                    value="{{ setting('AWS_DEFAULT_REGION') ?? '' }}">
                                @error('settings.AWS_DEFAULT_REGION')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="AWS_BUCKET" class="col-md-3">@lang('settings.amazonS3Bucket')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="s3">
                                <input id="AWS_BUCKET" type="text"
                                    class="form-control @error('settings.AWS_BUCKET') is-invalid @enderror"
                                    name="settings[AWS_BUCKET]" value="{{ setting('AWS_BUCKET') ?? '' }}">
                                @error('settings.AWS_BUCKET')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="WAS_ACCESS_KEY_ID" class="col-md-3">@lang('settings.wasabiKey')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="wasabi">
                                <input id="WAS_ACCESS_KEY_ID" type="text"
                                    class="form-control @error('settings.WAS_ACCESS_KEY_ID') is-invalid @enderror"
                                    name="settings[WAS_ACCESS_KEY_ID]"
                                    value="{{ setting('WAS_ACCESS_KEY_ID') ?? '' }}">
                                @error('settings.WAS_ACCESS_KEY_ID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="WAS_SECRET_ACCESS_KEY" class="col-md-3">@lang('settings.wasabiSecret')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="wasabi">
                                <input id="WAS_SECRET_ACCESS_KEY" type="text"
                                    class="form-control @error('settings.WAS_SECRET_ACCESS_KEY') is-invalid @enderror"
                                    name="settings[WAS_SECRET_ACCESS_KEY]"
                                    value="{{ setting('WAS_SECRET_ACCESS_KEY') ?? '' }}">
                                @error('settings.WAS_SECRET_ACCESS_KEY')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="WAS_DEFAULT_REGION" class="col-md-3">@lang('settings.wasabiRegion')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="wasabi">
                                <input id="WAS_DEFAULT_REGION" type="text"
                                    class="form-control @error('settings.WAS_DEFAULT_REGION') is-invalid @enderror"
                                    name="settings[WAS_DEFAULT_REGION]"
                                    value="{{ setting('WAS_DEFAULT_REGION') ?? '' }}">
                                @error('settings.WAS_DEFAULT_REGION')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="WAS_BUCKET" class="col-md-3">@lang('settings.wasabiBucket')</label>
                            <div class="col-md-9" data-conditional-name="settings[FILESYSTEM_DRIVER]"
                                data-conditional-value="wasabi">
                                <input id="WAS_BUCKET" type="text"
                                    class="form-control @error('settings.WAS_BUCKET') is-invalid @enderror"
                                    name="settings[WAS_BUCKET]" value="{{ setting('WAS_BUCKET') ?? '' }}">
                                @error('settings.WAS_BUCKET')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane tab-parent fade" id="usersTab">
                        <h1 class="h4">@lang('settings.usersSettings')</h1>
                        @if ($roles)
                            <div class="form-group mb-3 row">
                                <label for="public_user_role" class="col-md-3 form-label">@lang('settings.defaultUserRole')</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="settings[public_user_role]"
                                        id="public_user_role">
                                        <option value="">@lang('common.selectOne')</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($role->id == setting('public_user_role')) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="help-block text-muted small">@lang('settings.defaultUserRoleHelp')</span>
                                </div>
                            </div>
                        @endif
                        @if ($roles)
                            <div class="form-group mb-3 row">
                                <label for="SUPER_ADMIN_ROLE" class="col-md-3 form-label">@lang('settings.superUserRole')</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="settings[SUPER_ADMIN_ROLE]"
                                        id="SUPER_ADMIN_ROLE">
                                        <option value="">@lang('common.selectOne')</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($role->id == setting('SUPER_ADMIN_ROLE', 1)) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="help-block text-muted small">@lang('settings.superUserRoleHelp')</span>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-3 row">
                            <label for="activation_required" class="col-md-3 form-label">@lang('settings.activationRequired')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input class="switch-input @error('activation_required') is-invalid @enderror"
                                        id="activation_required" name="settings[activation_required]" value="1"
                                        {{ setting('activation_required') == 1 ? 'checked' : '' }} type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.activationRequiredHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="activation_max_attempts"
                                class="col-md-3 form-label">@lang('settings.resendActivationEmail')</label>
                            <div class="col-md-9" data-conditional-name="settings[activation_required]"
                                data-conditional-value="1">
                                <input id="activation_max_attempts" type="number"
                                    class="form-control @error('settings.activation_max_attempts') is-invalid @enderror"
                                    name="settings[activation_max_attempts]"
                                    value="{{ setting('activation_max_attempts') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.resendActivationEmailHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="activation_time_period"
                                class="col-md-3 form-label">@lang('settings.blockResendEmail')</label>
                            <div class="col-md-9" data-conditional-name="settings[activation_required]"
                                data-conditional-value="1">
                                <input id="activation_time_period" type="number"
                                    class="form-control @error('settings.activation_time_period') is-invalid @enderror"
                                    name="settings[activation_time_period]"
                                    value="{{ setting('activation_time_period') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.blockResendEmailHelp', ['number' => setting('activation_max_attempts')])</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="default_user_image" class="col-md-3 form-label">@lang('settings.defaultPicture')</label>
                            <div class="col-md-6">
                                <input id="default_user_image" type="file"
                                    class="form-control @error('settings.default_user_image') is-invalid @enderror"
                                    name="settings[default_user_image]">
                                @error('settings.default_user_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="help-block text-muted small">@lang('settings.defaultPictureHelp')</span>
                            </div>
                            @if (!empty(setting('default_user_image')))
                                <div class="col-md-3">
                                    <a href="{{ setting('default_user_image') }}" target="_blank">
                                        <img src="{{ setting('default_user_image') }}" height="75"
                                            alt="@lang('settings.defaultPicture')">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="restore_user_cutoff" class="col-md-3 form-label">@lang('settings.restoreCutOff')</label>
                            <div class="col-md-9">
                                <input id="restore_user_cutoff" type="number"
                                    class="form-control @error('settings.restore_user_cutoff') is-invalid @enderror"
                                    name="settings[restore_user_cutoff]"
                                    value="{{ setting('restore_user_cutoff') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.restoreCutOffHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="user_restore_key" class="col-md-3 form-label">@lang('settings.userRestoreKey')</label>
                            <div class="col-md-9">
                                <input id="user_restore_key" type="text"
                                    class="form-control @error('settings.user_restore_key') is-invalid @enderror"
                                    name="settings[user_restore_key]"
                                    value="{{ setting('user_restore_key') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.userRestoreKeyHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="restore_user_enc_type" class="col-md-3 form-label">@lang('settings.encryptionType')</label>
                            <div class="col-md-9">
                                <input id="restore_user_enc_type" type="text"
                                    class="form-control @error('settings.restore_user_enc_type') is-invalid @enderror"
                                    name="settings[restore_user_enc_type]"
                                    value="{{ setting('restore_user_enc_type') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.encryptionTypeHelp')</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane tab-parent fade" id="footerTab">
                        <h1 class="h4">@lang('settings.footerSettings')</h1>
                        <div class="form-group mb-3 row">
                            <label for="footer_widgets" class="col-md-3 form-label">@lang('settings.footerWidgets')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input class="switch-input @error('settings.footer_widgets') is-invalid @enderror"
                                        id="footer_widgets" name="settings[footer_widgets]" value="1"
                                        {{ setting('footer_widgets', 1) == 1 ? 'checked' : '' }} type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.footerWidgetsHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="footer_widget_columns"
                                class="col-md-3 form-label">@lang('settings.footerWidgetsColumns')</label>
                            <div class="col-md-9" data-conditional-name="settings[footer_widgets]">
                                <div class="range-slider">
                                    <input id="footer_widget_columns" class="range-slider__range"
                                        name="settings[footer_widget_columns]" type="range"
                                        value="{{ setting('footer_widget_columns', 4) }}" min="1"
                                        max="6">
                                    <span
                                        class="range-slider__value">{{ setting('footer_widget_columns', 4) }}</span>
                                </div>
                                <span class="help-block text-muted small d-block">@lang('settings.footerWidgetsColumnsHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="footer_copyright_bar"
                                class="col-md-3 form-label">@lang('settings.copyrightBar')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input
                                        class="switch-input @error('settings.footer_copyright_bar') is-invalid @enderror"
                                        id="footer_copyright_bar" name="settings[footer_copyright_bar]"
                                        value="1"
                                        {{ setting('footer_copyright_bar', 1) == 1 ? 'checked' : '' }}
                                        type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.copyrightBarHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="footer_center_copyright"
                                class="col-md-3 form-label">@lang('settings.centerCopyrightContent')</label>
                            <div class="col-md-9" data-conditional-name="settings[footer_copyright_bar]">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input
                                        class="switch-input @error('settings.footer_center_copyright') is-invalid @enderror"
                                        id="footer_center_copyright" name="settings[footer_center_copyright]"
                                        value="1"
                                        {{ setting('footer_center_copyright', 1) == 1 ? 'checked' : '' }}
                                        type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.centerCopyrightContentHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="_footer_copyright" class="col-md-3 form-label">@lang('settings.copyrightText')</label>
                            <div class="col-md-9" data-conditional-name="settings[footer_copyright_bar]">
                                <textarea id="_footer_copyright" type="text" rows="9"
                                    class="form-control @error('settings._footer_copyright') is-invalid @enderror"
                                    name="settings[_footer_copyright]">{{ setting('_footer_copyright', '© 2022 DotArtisan, LLC. All rights reserved. Powered By: <a href="https://dotartisan.com">DotArtisan, LLC</a>') ?? '' }}</textarea>
                                @error('settings._footer_copyright')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="help-block text-muted small">@lang('settings.copyrightTextHelp')</span>
                            </div>
                        </div>
                        <h5>@lang('admin.socialLinks')</h5>
                        <div class="form-group mb-3 row">
                            <label for="social_links_facebook"
                                class="col-md-3 form-label">@lang('settings.facebook')</label>
                            <div class="col-md-9">
                                <input id="social_links_facebook" type="text"
                                    class="form-control @error('settings.social_links_facebook') is-invalid @enderror"
                                    name="settings[social_links_facebook]"
                                    value="{{ setting('social_links_facebook') ?? old('settings.social_links_facebook') }}">
                                @error('settings.social_links_facebook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="social_links_twitter"
                                class="col-md-3 form-label">@lang('settings.twitter')</label>
                            <div class="col-md-9">
                                <input id="social_links_twitter" type="text"
                                    class="form-control @error('settings.social_links_twitter') is-invalid @enderror"
                                    name="settings[social_links_twitter]"
                                    value="{{ setting('social_links_twitter') ?? old('settings.social_links_twitter') }}">
                                @error('settings.social_links_twitter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="social_links_linkedin"
                                class="col-md-3 form-label">@lang('settings.linkedin')</label>
                            <div class="col-md-9">
                                <input id="social_links_linkedin" type="text"
                                    class="form-control @error('settings.social_links_linkedin') is-invalid @enderror"
                                    name="settings[social_links_linkedin]"
                                    value="{{ setting('social_links_linkedin') ?? old('settings.social_links_linkedin') }}">
                                @error('settings.social_links_linkedin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="social_links_youtube"
                                class="col-md-3 form-label">@lang('settings.youtube')</label>
                            <div class="col-md-9">
                                <input id="social_links_youtube" type="text"
                                    class="form-control @error('settings.social_links_youtube') is-invalid @enderror"
                                    name="settings[social_links_youtube]"
                                    value="{{ setting('social_links_youtube') ?? old('settings.social_links_youtube') }}">
                                @error('settings.social_links_youtube')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="mail" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.mailSettings')</h1>
                        <div class="form-group mb-3 row">
                            <label for="mail_from_name" class="col-md-3 form-label">@lang('settings.fromName')</label>
                            <div class="col-md-9">
                                <input id="mail_from_name" type="text"
                                    class="form-control @error('settings.mail_from_name') is-invalid @enderror"
                                    name="settings[mail_from_name]" value="{{ setting('mail_from_name') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.fromNameHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_from_address" class="col-md-3 form-label">@lang('settings.fromEmail')</label>
                            <div class="col-md-9">
                                <input id="mail_from_address" type="text"
                                    class="form-control @error('settings.mail_from_address') is-invalid @enderror"
                                    name="settings[mail_from_address]"
                                    value="{{ setting('mail_from_address') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.fromEmailHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_use_smtp" class="col-md-3 form-label">@lang('settings.useSMTP')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input class="switch-input @error('mail_use_smtp') is-invalid @enderror"
                                        id="mail_use_smtp" name="settings[mail_use_smtp]" value="smtp"
                                        {{ setting('mail_use_smtp') == 'smtp' ? 'checked' : '' }} type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.useSMTPHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_smtp_host" class="col-md-3 form-label">@lang('settings.smtpHost')</label>
                            <div class="col-md-9" data-conditional-name="settings[mail_use_smtp]"
                                data-conditional-value="1">
                                <input id="mail_smtp_host" type="text"
                                    class="form-control @error('mail_smtp_host.mail_host') is-invalid @enderror"
                                    name="settings[mail_smtp_host]" value="{{ setting('mail_smtp_host') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.smtpHostHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_smtp_port" class="col-md-3 form-label">@lang('settings.smtpPort')</label>
                            <div class="col-md-9" data-conditional-name="settings[mail_use_smtp]"
                                data-conditional-value="1">
                                <input id="mail_smtp_port" type="text"
                                    class="form-control @error('settings.mail_smtp_port') is-invalid @enderror"
                                    name="settings[mail_smtp_port]" value="{{ setting('mail_smtp_port') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.smtpPortHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_smtp_encryption"
                                class="col-md-3 form-label">@lang('settings.encryption')</label>
                            <div class="col-md-9 form-label" data-conditional-name="settings[mail_use_smtp]"
                                data-conditional-value="1">
                                <div class="form-check">
                                    <input id="no_encryption" type="radio"
                                        class="form-check-input @error('settings.mail_smtp_encryption') is-invalid @enderror"
                                        name="settings[mail_smtp_encryption]" value="null"
                                        {{ setting('mail_smtp_encryption') == 'null' ? 'checked' : '' }}>
                                    <label for="no_encryption">@lang('settings.noEncryption')</label>
                                </div>
                                <div class="form-check">
                                    <input id="ssl_encryption" type="radio"
                                        class="form-check-input @error('settings.mail_smtp_encryption') is-invalid @enderror"
                                        name="settings[mail_smtp_encryption]" value="ssl"
                                        {{ setting('mail_smtp_encryption') == 'ssl' ? 'checked' : '' }}>
                                    <label for="ssl_encryption">@lang('settings.sslEncryption')</label>
                                </div>
                                <div class="form-check">
                                    <input id="tls_encryption" type="radio"
                                        class="form-check-input @error('settings.mail_smtp_encryption') is-invalid @enderror"
                                        name="settings[mail_smtp_encryption]" value="tls"
                                        {{ setting('mail_smtp_encryption') == 'tls' ? 'checked' : '' }}>
                                    <label for="tls_encryption">@lang('settings.tlsEncryption')</label>
                                </div>
                                <span class="help-block text-muted small">@lang('settings.smtpPortHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_smtp_username" class="col-md-3 form-label">@lang('settings.smtpUsername')</label>
                            <div class="col-md-9" data-conditional-name="settings[mail_use_smtp]"
                                data-conditional-value="1">
                                <input id="mail_smtp_username" type="text"
                                    class="form-control @error('settings.mail_smtp_username') is-invalid @enderror"
                                    name="settings[mail_smtp_username]"
                                    value="{{ setting('mail_smtp_username') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.smtpUsernameHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="mail_smtp_password" class="col-md-3 form-label">@lang('settings.smtpPassword')</label>
                            <div class="col-md-9" data-conditional-name="settings[mail_use_smtp]"
                                data-conditional-value="1">
                                <input id="mail_smtp_password" type="text"
                                    class="form-control @error('settings.mail_smtp_password') is-invalid @enderror"
                                    name="settings[mail_smtp_password]"
                                    value="{{ setting('mail_smtp_password') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.smtpPasswordHelp')</span>
                            </div>
                        </div>
                    </div>

                    <div id="advance" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.advanceSettings')</h1>
                        <div class="form-group row mb-3">
                            <label for="debug" class="col-md-3 form-label">@lang('settings.debug')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input class="switch-input @error('debug') is-invalid @enderror" id="debug"
                                        name="settings[debug]" value="true"
                                        {{ setting('debug') === 'true' ? 'checked' : '' }} type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.debugHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="cookies_consent" class="col-md-3 form-label">@lang('settings.cookiesConsent')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input class="switch-input @error('cookies_consent') is-invalid @enderror"
                                        id="cookies_consent" name="settings[cookies_consent]" value="true"
                                        {{ setting('cookies_consent') === 'true' ? 'checked' : '' }}
                                        type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block">@lang('settings.cookiesConsentHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="form-label col-md-3">@lang('settings.rebuildLocales')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('system.rebuild') }}"
                                    id="rebuild_locales"
                                    class="btn btn-warning btn-sm requestAjax text-white rounded-pill px-4">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.rebuildLocales')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.rebuildLocalesHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="col-md-3">@lang('settings.sitemap')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('sitemap.generate') }}"
                                    id="clear_cache"
                                    class="btn btn-primary btn-sm rounded-pill text-white px-4 btn-sm requestAjax">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.generateSitemap')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.generateSitemapHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="form-label col-md-3">@lang('settings.clearCache')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('system.cache') }}" id="clear_cache"
                                    class="btn btn-info btn-sm requestAjax text-white rounded-pill px-4">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.clearCache')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.clearCacheHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="form-label col-md-3">@lang('settings.optimize')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('system.optimize') }}"
                                    id="clear_cache"
                                    class="btn btn-info btn-sm requestAjax text-white rounded-pill px-4">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.optimize')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.optimizeHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="form-label col-md-3">@lang('settings.clearViewsCache')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('system.view') }}" id="clear_view"
                                    class="btn btn-info btn-sm requestAjax text-white rounded-pill px-4">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.clearViewsCache')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.clearViewsCacheHelp')</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="maintenance_mode" class="form-label col-md-3">@lang('settings.clearRoutesCache')</label>
                            <div class="col-md-9">
                                <button type="button" data-url="{{ route('system.route') }}" id="clear_route"
                                    class="btn btn-info btn-sm requestAjax text-white rounded-pill px-4">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="sr-only">@lang('common.loading')</span>
                                    </div> @lang('settings.clearRoutesCache')
                                </button>
                                <span class="help-block text-muted small d-block">@lang('settings.clearRoutesCacheHelp')</span>
                            </div>
                        </div>
                    </div>
                    <div id="maintenanceMode" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.maintenanceMode')</h1>
                        <div class="form-group mb-3 row">
                            <label for="maintenance_mode" class="col-md-3 form-label">@lang('settings.enableMaintenanceMode')</label>
                            <div class="col-md-9">
                                <label class="switch switch-pill switch-label switch-primary">
                                    <input
                                        class="switch-input @error('settings.maintenance_mode') is-invalid @enderror"
                                        id="maintenance_mode" name="settings[maintenance_mode]" value="1"
                                        {{ setting('maintenance_mode') == 1 ? 'checked' : '' }} type="checkbox">
                                    <span class="switch-slider" data-checked="&#x2713;"
                                        data-unchecked="&#x2715;"></span>
                                </label>
                                <span class="help-block text-muted small d-block"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="maintenance_token" class="col-md-3 form-label">@lang('settings.maintenanceToken')</label>
                            @php
                                $token = setting('maintenance_token', Str::random(25));
                                $access_url = URL::to($token);
                            @endphp
                            <div class="col-md-9" data-conditional-name="settings[maintenance_mode]"
                                data-conditional-value="1">
                                <input id="maintenance_token" type="text"
                                    class="form-control @error('settings.maintenance_token') is-invalid @enderror"
                                    name="settings[maintenance_token]"
                                    value="{{ setting('maintenance_token') ?? $token }}">
                                @error('settings.maintenance_token')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="text-muted small">@lang('settings.maintenanceTokenHelp', ['access_url' => $access_url])</span>
                            </div>
                        </div>
                    </div>
                    <div id="paymentGateways" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.paymentGateways')</h1>
                        <ul class="nav">
                            <li class="nav-item"><a href="#paypalTab" class="nav-link active"
                                    data-coreui-toggle="tab">@lang('settings.paypal')</a></li>
                            <li class="nav-item"><a href="#stripeTab" class="nav-link"
                                    data-coreui-toggle="tab">@lang('settings.stripe')</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="paypalTab" class="tab-pane fade show active">
                                <div class="form-group row mb-3">
                                    <label for="paypal_allow"
                                        class="col-md-3 form-label">@lang('settings.paypal')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('paypal_allow') is-invalid @enderror"
                                                id="paypal_allow" name="settings[PAYPAL_ALLOW]"
                                                @if (setting('PAYPAL_ALLOW') == 1) checked @endif value="1"
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                        <span class="help-block text-muted small d-block">@lang('settings.paypalHelp')</span>
                                    </div>
                                </div>
                                <div class="paypal-options">
                                    <div class="row" data-conditional-name="settings[PAYPAL_ALLOW]"
                                        data-conditional-value="1">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_MODE"
                                            class="col-md-3 form-label">@lang('settings.paypalMode')</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_ALLOW]"
                                            data-conditional-value="1">
                                            <select class="form-control" id="PAYPAL_MODE"
                                                name="settings[PAYPAL_MODE]">
                                                <option value="sandbox"
                                                    @if (setting('PAYPAL_MODE') == 'sandbox') selected @endif>
                                                    Sandbox
                                                </option>
                                                <option value="live"
                                                    @if (setting('PAYPAL_MODE') == 'live') selected @endif>
                                                    Live
                                                </option>
                                            </select>
                                            <span
                                                class="help-block text-muted small d-block">@lang('settings.paypalModeHelp')</span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_VALIDATE_SSL"
                                            class="col-md-3 form-label">@lang('settings.sslSetting')</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_ALLOW]"
                                            data-conditional-value="1">
                                            <select class="form-control" id="PAYPAL_VALIDATE_SSL"
                                                name="settings[PAYPAL_VALIDATE_SSL]">
                                                <option value="TRUE"
                                                    @if (setting('PAYPAL_VALIDATE_SSL') == 'TRUE') checked @endif>
                                                    True
                                                </option>
                                                <option value="FALSE"
                                                    @if (setting('PAYPAL_VALIDATE_SSL') == 'FALSE') checked @endif>
                                                    False
                                                </option>
                                            </select>
                                            <span
                                                class="help-block text-muted small d-block">@lang('settings.sslSettingHelp')</span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_LIVE_CLIENT_ID"
                                            class="col-md-3 form-label">@lang('settings.clientId')
                                            Live</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_MODE]"
                                            data-conditional-value="live">
                                            <input id="PAYPAL_LIVE_CLIENT_ID" type="text"
                                                class="form-control @error('settings.PAYPAL_LIVE_CLIENT_ID') is-invalid @enderror"
                                                name="settings[PAYPAL_LIVE_CLIENT_ID]"
                                                value="{{ setting('PAYPAL_LIVE_CLIENT_ID') ?? '' }}">
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.clientIdHelp')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_LIVE_CLIENT_SECRET"
                                            class="col-md-3 form-label">@lang('settings.clientSeceret')
                                            Live</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_MODE]"
                                            data-conditional-value="live">
                                            <input id="PAYPAL_LIVE_CLIENT_SECRET" type="text"
                                                class="form-control @error('settings.PAYPAL_LIVE_CLIENT_SECRET') is-invalid @enderror"
                                                name="settings[PAYPAL_LIVE_CLIENT_SECRET]"
                                                value="{{ setting('PAYPAL_LIVE_CLIENT_SECRET') ?? '' }}">
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.clientSeceretHelp')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_LIVE_APP_ID"
                                            class="col-md-3 form-label">@lang('settings.appid')
                                            Live</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_MODE]"
                                            data-conditional-value="live">
                                            <input id="PAYPAL_LIVE_APP_ID" type="text"
                                                class="form-control @error('settings.PAYPAL_LIVE_APP_ID') is-invalid @enderror"
                                                name="settings[PAYPAL_LIVE_APP_ID]"
                                                value="{{ setting('PAYPAL_LIVE_APP_ID') ?? '' }}">
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.appidHelp')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_SANDBOX_CLIENT_ID"
                                            class="col-md-3 form-label">@lang('settings.clientId')</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_MODE]"
                                            data-conditional-value="sandbox">
                                            <input id="PAYPAL_SANDBOX_CLIENT_ID" type="text"
                                                class="form-control @error('settings.PAYPAL_SANDBOX_CLIENT_ID') is-invalid @enderror"
                                                name="settings[PAYPAL_SANDBOX_CLIENT_ID]"
                                                value="{{ setting('PAYPAL_SANDBOX_CLIENT_ID') ?? '' }}">
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.clientIdHelp')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_SANDBOX_CLIENT_SECRET"
                                            class="col-md-3 form-label">@lang('settings.clientSeceret')</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_MODE]"
                                            data-conditional-value="sandbox">
                                            <input id="PAYPAL_SANDBOX_CLIENT_SECRET" type="text"
                                                class="form-control @error('settings.PAYPAL_SANDBOX_CLIENT_SECRET') is-invalid @enderror"
                                                name="settings[PAYPAL_SANDBOX_CLIENT_SECRET]"
                                                value="{{ setting('PAYPAL_SANDBOX_CLIENT_SECRET') ?? '' }}">
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.clientSeceretHelp')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="PAYPAL_NOTIFY_URL"
                                            class="col-md-3 form-label">@lang('settings.paypalNotifyUrl')
                                            Live</label>
                                        <div class="col-md-9" data-conditional-name="settings[PAYPAL_NOTIFY_URL]"
                                            data-conditional-value="live">
                                            <input id="PAYPAL_NOTIFY_URL" type="text"
                                                class="form-control @error('settings.PAYPAL_NOTIFY_URL') is-invalid @enderror"
                                                name="settings[PAYPAL_NOTIFY_URL]"
                                                value="{{ setting('PAYPAL_NOTIFY_URL', route('payments.webhook-listener')) }}"
                                                readonly>
                                            <span class="help-block text-muted small d-block">
                                                @lang('settings.paypalNotifyUrlHelp')
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="stripeTab" class="tab-pane fade">
                                <div class="form-group row mb-3">
                                    <label for="stripe_allow"
                                        class="col-md-3 form-label">@lang('settings.stripe')</label>
                                    <div class="col-md-9">
                                        <label class="switch switch-pill switch-label switch-primary">
                                            <input class="switch-input @error('stripe_allow') is-invalid @enderror"
                                                id="stripe_allow" name="settings[STRIPE_ALLOW]"
                                                @if (setting('STRIPE_ALLOW') == 1) checked @endif value="1"
                                                type="checkbox">
                                            <span class="switch-slider" data-checked="&#x2713;"
                                                data-unchecked="&#x2715;"></span>
                                        </label>
                                        <span class="help-block text-muted small d-block">@lang('settings.stripeHelp')</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" data-conditional-name="settings[STRIPE_ALLOW]"
                                        data-conditional-value="1">
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="stripeKey" class="col-md-3 form-label">@lang('settings.stripeKey')</label>
                                    <div class="col-md-9" data-conditional-name="settings[STRIPE_ALLOW]"
                                        data-conditional-value="1">
                                        <input id="stripeKey" type="text"
                                            class="form-control @error('settings.STRIPE_KEY') is-invalid @enderror"
                                            name="settings[STRIPE_KEY]" value="{{ setting('STRIPE_KEY') ?? '' }}">
                                        <span class="help-block text-muted small d-block">@lang('settings.stripeKeyHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="stripeSecret"
                                        class="col-md-3 form-label">@lang('settings.stripeSecret')</label>
                                    <div class="col-md-9" data-conditional-name="settings[STRIPE_ALLOW]"
                                        data-conditional-value="1">
                                        <input id="stripeSecret" type="text"
                                            class="form-control @error('settings.STRIPE_SECRET') is-invalid @enderror"
                                            name="settings[STRIPE_SECRET]"
                                            value="{{ setting('STRIPE_SECRET') ?? '' }}">
                                        <span class="help-block text-muted small d-block">@lang('settings.stripeSecretHelp')</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="usecasesTab" class="tab-pane tab-parent fade">
                        <h1 class="h4">@lang('settings.usecaseUsageSetting')</h1>
                        <div class="form-group mb-3 row">
                            <label for="no_of_words" class="col-md-3 form-label">@lang('settings.noOfWords')</label>
                            <div class="col-md-9">
                                <input id="no_of_words" type="text"
                                    class="form-control @error('settings.no_of_words') is-invalid @enderror"
                                    name="settings[no_of_words]" value="{{ setting('no_of_words') ?? 0 }}">
                                @error('settings.no_of_words')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="text-muted small">@lang('settings.noOfWordsHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="usecase_daily_limit" class="col-md-3 form-label">@lang('settings.usecaseDailyLimit')</label>
                            <div class="col-md-9">
                                <input id="usecase_daily_limit" type="text"
                                    class="form-control @error('settings.usecase_daily_limit') is-invalid @enderror"
                                    name="settings[usecase_daily_limit]"
                                    value="{{ setting('usecase_daily_limit') ?? 0 }}">
                                @error('settings.usecase_daily_limit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="text-muted small">@lang('settings.usecaseDailyLimitHelp')</span>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="OPEN_API_KEY" class="col-md-3 form-label">@lang('settings.openaiKey')</label>
                            <div class="col-md-9">
                                <input id="OPEN_API_KEY" type="text"
                                    class="form-control @error('settings.OPEN_API_KEY') is-invalid @enderror"
                                    name="settings[OPEN_API_KEY]"
                                    value="{{ setting('OPEN_API_KEY') ?? '' }}">
                                <span class="help-block text-muted small">@lang('settings.openaiKeyHelp')</span>
                            </div>
                        </div>

                    </div>
                    @if (!empty($theme_file))
                        <div id="themeOptions" class="tab-pane tab-parent fade">
                            <h1 class="h4">@lang('settings.themeOptions')</h1>
                            @include($theme_file)
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-12 settings-footer text-end">
                <button class="btn btn-lg btn-primary rounded-pill px-5 text-white" id="settings-btn"
                    type="submit" name="action">@lang('settings.saveSettings')</button>
            </div>
        </div>
    </form>
    @section('footer_scripts')
        <script type="module" src="https://unpkg.com/vanilla-colorful?module"></script>
        <script>
            const ARTISAN_APP = function() {
                const tabsStorage = function() {
                        const leftTabs = document.querySelectorAll('#leftTabs a[data-coreui-toggle="tab"]')
                        const tabMain = document.querySelectorAll('.tab-main a[data-coreui-toggle="tab"]')
                        leftTabs.forEach(element => {
                            element.addEventListener('shown.coreui.tab', function(e) {
                                localStorage.setItem('leftTab', e.target.getAttribute('href'));
                            });
                        });
                        tabMain.forEach(element => {
                            element.addEventListener('show.coreui.tab', function(e) {
                                localStorage.setItem('activeTab', e.target.getAttribute('href'));
                            });
                        });

                        var leftTab = localStorage.getItem('leftTab');
                        if (leftTab) {
                            coreui.Tab.getOrCreateInstance(document.querySelector('a[href="' + leftTab + '"]')).show()
                        }
                        var activeTab = localStorage.getItem('activeTab');
                        if (activeTab) {
                            coreui.Tab.getOrCreateInstance(document.querySelector('a[href="' + activeTab + '"]')).show()
                        }
                    },
                    deleteCheckbox = function() {
                        if (document.querySelectorAll('.delete-box').length > 0) {
                            document.querySelectorAll('.delete-box').forEach(element => {
                                element.addEventListener('change', checkbox => {
                                    if (checkbox.target.checked) {
                                        checkbox.target.parentNode.style.display = 'none';
                                    }
                                })
                            });
                        }
                    },
                    initColorpicker = function() {
                        document.querySelectorAll('hex-color-picker').forEach(el => {
                            var field = el.parentElement.parentElement.parentElement.parentElement.querySelector(
                                'input');
                            var backgroundSpan = el.parentElement.parentElement.querySelector('span');
                            var backgroundParentSpan = el.parentElement.parentElement.parentElement.parentElement
                                .querySelector(
                                    'span');
                            el.addEventListener('color-changed', (event) => {
                                field.value = event.detail.value;
                                backgroundSpan.style.backgroundColor = event.detail.value;
                                backgroundParentSpan.style.backgroundColor = event.detail.value;
                            });
                        });
                    },
                    requestAjax = function(target) {
                        if (target) {
                            let $url = target.dataset.url;
                            if ($url) {
                                target.disabled = true;
                                target.querySelector('.spinner-border').classList.remove('d-none');

                                axios.get($url)
                                    .then(function(response) {
                                        if (response.data.success) {
                                            DotArtisan.sweetSuccess(response.data.message);
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                    }).then(function() {
                                        target.disabled = false
                                        target.querySelector('.spinner-border').classList.add('d-none')
                                    });
                            }
                        }
                    },
                    attachEvents = function() {
                        const ajaxActions = document.querySelectorAll('.requestAjax')
                        if (ajaxActions.length > 0) {
                            ajaxActions.forEach(button => {
                                button.addEventListener('click', e => {
                                    e.preventDefault()
                                    requestAjax(e.target)
                                })
                            });
                        }
                    };

                return {
                    init: function() {
                        tabsStorage();
                        deleteCheckbox();
                        initColorpicker();
                        attachEvents();
                        document.querySelector('.settings-tabs').classList.remove('invisible');
                    }
                }
            }();
            document.addEventListener("DOMContentLoaded", function(event) {
                ARTISAN_APP.init();
            });
        </script>
    @endsection
</x-app-layout>
