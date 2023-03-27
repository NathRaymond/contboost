<ul class="nav">
    <li class="nav-item"><a href="#themeGeneral" class="nav-link active" data-coreui-toggle="tab">@lang('settings.general')</a></li>
    <li class="nav-item"><a href="#lightTheme" class="nav-link" data-coreui-toggle="tab">@lang('settings.fontColors')</a></li>
    <li class="nav-item"><a href="#darkTheme" class="nav-link" data-coreui-toggle="tab">@lang('settings.fontColorsDark')</a></li>
    <li class="nav-item"><a href="#fontSizes" class="nav-link" data-coreui-toggle="tab">@lang('settings.fontSizes')</a></li>
    <li class="nav-item"><a href="#fontLineheight" class="nav-link" data-coreui-toggle="tab">@lang('settings.fontLineheight')</a></li>
    @if ($fonts)
        <li class="nav-item"><a href="#typography" class="nav-link" data-coreui-toggle="tab">@lang('settings.typography')</a></li>
    @endif
</ul>
<div class="tab-content">
    <div id="themeGeneral" class="tab-pane fade show active">
        @if ($menus)
            <div class="form-group mb-3 row">
                <label for="_main_menu" class="col-md-3 col-form-label">@lang('settings.mainMenu')</label>
                <div class="col-md-9">
                    <select class="form-control" name="settings[_main_menu]" id="_main_menu">
                        <option value="">@lang('common.selectOne')</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->name }}" @if ($menu->name == setting('_main_menu')) selected @endif>
                                {{ $menu->name }}</option>
                        @endforeach
                    </select>
                    <span class="help-block text-muted small">@lang('settings.mainMenuHelp')</span>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label for="_document_menu" class="col-md-3 col-form-label">@lang('settings.documentMenu')</label>
                <div class="col-md-9">
                    <select class="form-control" name="settings[_document_menu]" id="_document_menu">
                        <option value="">@lang('common.selectOne')</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->name }}" @if ($menu->name == setting('_document_menu')) selected @endif>
                                {{ $menu->name }}</option>
                        @endforeach
                    </select>
                    <span class="help-block text-muted small">@lang('settings.documentMenuHelp')</span>
                </div>
            </div>
        @endif
        <div class="form-group mb-3 row">
            <label for="homepage_banner" class="col-md-3 form-label">@lang('settings.homePageBannerImage')</label>
            <div class="col-md-3">
                <input id="homepage_banner" type="file"
                    class="form-control @error('settings.homepage_banner') is-invalid @enderror"
                    name="settings[homepage_banner]">
                @error('settings.homepage_banner')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span class="help-block d-block text-muted small">@lang('settings.homePageBannerImageHelp')</span>
            </div>
            @if (!empty(setting('homepage_banner', '/themes/neuralink/images/browser.jpg')))
                <div class="col-md-6">
                    <a href="{{ url(setting('homepage_banner', '/themes/neuralink/images/browser.jpg')) }}"
                        target="_blank">
                        <img src="{{ url(setting('homepage_banner', '/themes/neuralink/images/browser.jpg')) }}"
                            height="59" alt="{{ setting('app_name') }}">
                    </a>
                </div>
            @endif
        </div>
        <div class="form-group row mb-3">
            <label for="enable_dark_mode" class="col-md-3 form-label">@lang('neuralink.enableDarkMode')</label>
            <div class="col-md-9">
                <label class="switch switch-pill switch-label switch-primary">
                    <input class="switch-input @error('neuralink.enable_dark_mode') is-invalid @enderror"
                        id="enable_dark_mode" name="settings[neuralink][enable_dark_mode]" value="1"
                        {{ isset($themeOptions->enable_dark_mode) && $themeOptions->enable_dark_mode == '1' ? 'checked' : '' }}
                        type="checkbox">
                    <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
                </label>
                <span class="help-block d-block text-muted small">@lang('neuralink.enableDarkModeHelp')</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="dark_default_theme" class="col-md-3 form-label">@lang('neuralink.darkThemeDefault')</label>
            <div class="col-md-9" data-conditional-name="settings[neuralink][enable_dark_mode]"
                data-conditional-value="1">
                <label class="switch switch-pill switch-label switch-primary">
                    <input class="switch-input @error('neuralink.dark_default_theme') is-invalid @enderror"
                        id="dark_default_theme" name="settings[neuralink][dark_default_theme]" value="dark"
                        {{ isset($themeOptions->dark_default_theme) && $themeOptions->dark_default_theme == 'dark' ? 'checked' : '' }}
                        type="checkbox">
                    <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
                </label>
                <span class="help-block d-block text-muted small">@lang('neuralink.darkThemeDefaultHelp')</span>
            </div>
        </div>
    </div>
    <div id="lightTheme" class="tab-pane fade show">
        <div class="form-group row mb-3">
            <label for="primary_color" class="col-md-3 form-label">@lang('settings.primaryColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="primary_color" class="form-control"
                        name="settings[neuralink][light][primary_color]"
                        value="{{ $themeOptions->light->primary_color ?? '#0084FF' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->primary_color ?? '#0084FF' }}">
                        <x-color-picker :color="$themeOptions->light->primary_color ?? '#0084FF'" />
                    </span>
                </div>
                <span class="help-block text-muted small">@lang('settings.primaryColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#0084FF'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="secondary_color" class="col-md-3 form-label">@lang('settings.secondaryColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="secondary_color" class="form-control"
                        name="settings[neuralink][light][secondary_color]"
                        value="{{ $themeOptions->light->secondary_color ?? '#eff7ff' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->secondary_color ?? '#eff7ff' }}">
                        <x-color-picker :color="$themeOptions->light->secondary_color ?? '#eff7ff'" />
                    </span>
                </div>
                <span class="help-block text-muted small">@lang('settings.primaryColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#eff7ff'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="background_color" class="col-md-3 form-label">@lang('settings.backgroundColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="background_color" class="form-control"
                        name="settings[neuralink][light][background_color]"
                        value="{{ $themeOptions->light->background_color ?? '#FAFCFF' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->background_color ?? '#FAFCFF' }}">
                        <x-color-picker :color="$themeOptions->light->background_color ?? '#FAFCFF'" />
                    </span>
                </div>
                <span class="help-block text-muted small">@lang('settings.backgroundColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#FAFCFF'])</span>
            </div>
        </div>
        {{-- <div class="form-group row mb-3">
            <label for="header_background_color" class="col-md-3 form-label">@lang('neuralink.headerBackgroundColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="header_background_color" class="form-control"
                        name="settings[neuralink][light][header_background_color]"
                        value="{{ $themeOptions->light->header_background_color ?? '#ffffff' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->header_background_color ?? '#ffffff' }}">
                        <x-color-picker :color="$themeOptions->light->header_background_color ?? '#ffffff'" />
                    </span>
                </div>
                <span class="help-block text-muted small">@lang('neuralink.headerBackgroundColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#ffffff'])</span>
            </div>
        </div> --}}
        <div class="form-group row mb-3">
            <label for="body_color" class="col-md-3 form-label">@lang('settings.bodyTextColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="body_color" class="form-control"
                        name="settings[neuralink][light][body_color]"
                        value="{{ $themeOptions->light->body_color ?? '#212529' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->body_color ?? '#212529' }}">
                        <x-color-picker :color="$themeOptions->light->body_color ?? '#212529'" />
                    </span>
                </div>
                <span class="help-block text-muted small">@lang('settings.bodyTextColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#212529'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="border_color" class="col-md-3 form-label">@lang('settings.borderColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="border_color" class="form-control"
                        name="settings[neuralink][light][border_color]"
                        value="{{ $themeOptions->light->border_color ?? '#ecf2ff' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->light->border_color ?? '#ecf2ff' }}">
                        <x-color-picker :color="$themeOptions->light->border_color ?? '#ecf2ff'" />
                </div>
                <span class="help-block text-muted small">@lang('settings.borderColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#ecf2ff'])</span>
            </div>
        </div>
    </div>
    <div id="darkTheme" class="tab-pane fade show">
        <div class="form-group row mb-3">
            <label for="dark_primary_color" class="col-md-3 form-label">@lang('neuralink.darkPrimaryColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="dark_primary_color" class="form-control"
                        name="settings[neuralink][dark][primary_color]"
                        value="{{ $themeOptions->dark->primary_color ?? '#080717' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->dark->primary_color ?? '#080717' }}">
                        <x-color-picker :color="$themeOptions->dark->primary_color ?? '#080717'" />
                </div>
                <span class="help-block text-muted small">@lang('settings.primaryColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#080717'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="dark_secondary_color" class="col-md-3 form-label">@lang('neuralink.darkSecondaryColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="dark_secondary_color" class="form-control"
                        name="settings[neuralink][dark][secondary_color]"
                        value="{{ $themeOptions->dark->secondary_color ?? '#131220' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->dark->secondary_color ?? '#131220' }}">
                        <x-color-picker :color="$themeOptions->dark->secondary_color ?? '#131220'" />
                </div>
                <span class="help-block text-muted small">@lang('settings.secondaryColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#131220'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="dark_body_text_color" class="col-md-3 form-label">@lang('settings.bodyTextColorDark')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="dark_body_text_color" class="form-control"
                        name="settings[neuralink][dark][body_text_color]"
                        value="{{ $themeOptions->dark->body_text_color ?? '#eff7ff' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->dark->body_text_color ?? '#eff7ff' }}">
                        <x-color-picker :color="$themeOptions->dark->body_text_color ?? '#eff7ff'" />
                </div>
                <span class="help-block text-muted small">@lang('settings.bodyTextColorDarkHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#eff7ff'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="dark_border_color" class="col-md-3 form-label">@lang('settings.borderColor')</label>
            <div class="col-md-9">
                <div class="input-group colorPicker">
                    <input type="text" id="dark_border_color" class="form-control"
                        name="settings[neuralink][dark][border_color]"
                        value="{{ $themeOptions->dark->border_color ?? '#272634' }}" />
                    <span class="input-group-append"
                        style="background-color:{{ $themeOptions->dark->border_color ?? '#272634' }}">
                        <x-color-picker :color="$themeOptions->dark->border_color ?? '#272634'" />
                </div>
                <span class="help-block text-muted small">@lang('settings.borderColorHelp')</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '#272634'])</span>
            </div>
        </div>
    </div>
    <div id="fontSizes" class="tab-pane fade">
        <div class="form-group row mb-3">
            <label for="body_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'Body'])</label>
            <div class="col-md-9">
                <input type="text" id="body_font_size" class="form-control"
                    name="settings[neuralink][body_font_size]"
                    value="{{ $themeOptions->body_font_size ?? '1rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'Body'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '.875rem'])</span>
            </div>
        </div>
        <h5 class="mb-4">@lang('settings.headingSize')</h5>
        <div class="form-group row mb-3">
            <label for="h1_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H1'])</label>
            <div class="col-md-9">
                <input type="text" id="h1_font_size" class="form-control" name="settings[elegant][h1_font_size]"
                    value="{{ $themeOptions->h1_font_size ?? '1.5rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H1'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1.5rem'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="h2_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H2'])</label>
            <div class="col-md-9">
                <input type="text" id="h2_font_size" class="form-control" name="settings[elegant][h2_font_size]"
                    value="{{ $themeOptions->h2_font_size ?? '1.25rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H2'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1.25rem'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="h3_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H3'])</label>
            <div class="col-md-9">
                <input type="text" id="h3_font_size" class="form-control" name="settings[elegant][h3_font_size]"
                    value="{{ $themeOptions->h3_font_size ?? '1.125rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H3'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1.125rem'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="h4_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H4'])</label>
            <div class="col-md-9">
                <input type="text" id="h4_font_size" class="form-control" name="settings[elegant][h4_font_size]"
                    value="{{ $themeOptions->h4_font_size ?? '1rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H4'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1rem'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="h5_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H5'])</label>
            <div class="col-md-9">
                <input type="text" id="h5_font_size" class="form-control" name="settings[elegant][h5_font_size]"
                    value="{{ $themeOptions->h5_font_size ?? '1.09375rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H5'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1.09375rem'])</span>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="h6_font_size" class="col-md-3 form-label">@lang('settings.tagFontSize', ['tag' => 'H6'])</label>
            <div class="col-md-9">
                <input type="text" id="h6_font_size" class="form-control" name="settings[elegant][h6_font_size]"
                    value="{{ $themeOptions->h6_font_size ?? '0.875rem' }}" />
                <span class="help-block text-muted small">@lang('settings.tagFontSizeHelp', ['tag' => 'H6'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '0.875rem'])</span>
            </div>
        </div>
    </div>
    <div id="fontLineheight" class="tab-pane fade">
        <div class="form-group row mb-3">
            <label for="body_line_height" class="col-md-3 form-label">@lang('settings.tagLineheight', ['tag' => 'Body'])</label>
            <div class="col-md-9">
                <input type="text" id="body_line_height" class="form-control"
                    name="settings[neuralink][body_line_height]"
                    value="{{ $themeOptions->body_line_height ?? '1.5' }}" />
                <span class="help-block text-muted small">@lang('settings.tagLineheightHelp', ['tag' => 'Body'])</span>
                <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => '1.5'])</span>
            </div>
        </div>
    </div>
    @if ($fonts)
        <div id="typography" class="tab-pane fade">
            <div class="form-group row mb-3">
                <label for="body_font" class="col-md-3 form-label">@lang('settings.tagFont', ['tag' => 'Body'])</label>
                <div class="col-md-9">
                    <select id="body_font" class="form-control selectedFont"
                        name="settings[neuralink][body_font][family]">
                        <option value="">@lang('common.selectOne')</option>
                        @php
                            $variants = [];
                            $selected = '';
                        @endphp
                        @foreach ($fonts as $index => $font)
                            @php
                                if (isset($themeOptions->body_font->family) && $themeOptions->body_font->family == $font['family']) {
                                    $variants = $font['variants'];
                                    $selected = $themeOptions->body_font->family;
                                }
                            @endphp
                            <option data-index="{{ $index }}" value="{{ $font['family'] }}"
                                @if ($selected === $font['family']) selected @endif>{{ $font['family'] }}</option>
                        @endforeach
                    </select>
                    <span class="help-block text-muted small">@lang('settings.tagFontHelp', ['tag' => 'Body'])</span>
                    <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => 'Nunito'])</span>
                    <div class="fontVariants">
                        <select id="body_font_variant" class="form-control"
                            name="settings[neuralink][body_font][variant][]" size="8" multiple>
                            @foreach ($variants as $index => $variant)
                                <option data-index="{{ $index }}" value="{{ $variant }}"
                                    @if (isset($themeOptions->body_font->variant) && in_array($variant, $themeOptions->body_font->variant)) selected @endif>{{ $variant }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="heading_font" class="col-md-3 form-label">@lang('settings.tagFont', ['tag' => 'Heading'])</label>
                <div class="col-md-9">
                    <select id="heading_font" class="form-control selectedFont"
                        name="settings[neuralink][heading_font][family]">
                        @php
                            $variants = [];
                            $selected = '';
                        @endphp
                        <option value="">@lang('common.selectOne')</option>
                        @foreach ($fonts as $index => $font)
                            @php
                                if (isset($themeOptions->heading_font->family) && $themeOptions->heading_font->family == $font['family']) {
                                    $variants = $font['variants'];
                                    $selected = $themeOptions->heading_font->family;
                                }
                            @endphp
                            <option data-index="{{ $index }}" value="{{ $font['family'] }}"
                                @if ($selected == $font['family']) selected @endif>{{ $font['family'] }}</option>
                        @endforeach
                    </select>
                    <span class="help-block text-muted small">@lang('settings.tagFontHelp', ['tag' => 'Heading'])</span>
                    <span class="help-block text-muted small">@lang('settings.defaultValue', ['value' => 'Nunito'])</span>
                    <div class="fontVariants">
                        <select id="heading_font_variant" class="form-control"
                            name="settings[neuralink][heading_font][variant][]" size="8" multiple>
                            @foreach ($variants as $index => $variant)
                                <option data-index="{{ $index }}" value="{{ $variant }}"
                                    @if (isset($themeOptions->heading_font->variant) && in_array($variant, $themeOptions->heading_font->variant)) selected @endif>{{ $variant }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
