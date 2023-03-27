<x-front-layout>
    <section class="home-banner">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    <div class="contant">
                        <h1 class="typing-effect uppercase">
                            @lang('home.bannerHead')
                            <div class="mt-3">
                                <span class="typed-text"></span>
                                <span class="cursor">&nbsp;</span>
                            </div>
                        </h1>
                        <p>@lang('home.bannerSubtitle')</p>
                        <a href="{{ route('document.index') }}" type="button"
                            class="btn btn-primary btn-lg px-5">@lang('common.tryFree')</a>
                    </div>
                </div>
            </div>
            <div class="banner-wrap">
                <div class="cover">
                    <img src="{{ Vite::asset('resources/themes/neuralink/assets/images/main-image.svg') }}"
                        alt="banner">
                </div>
                <div class="banner-image">
                    <img src="{{ Vite::asset('resources/themes/neuralink/assets/images/browser.jpg') }}" alt="banner">
                </div>
            </div>
        </div>
    </section>
    <section class="facts-card">
        <div class="container">
            <div class="row match-height">
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="item card box-shadow">
                        <div class="icon d-flex justify-content-center align-items-center bg-primary">
                            <i class="an an-usd-sign"></i>
                        </div>
                        <h5>@lang('home.saveMoney')</h5>
                        <p class="text-muted">@lang('home.saveMoneyDesc')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="item card box-shadow">
                        <div class="icon d-flex justify-content-center align-items-center bg-warning">
                            <i class="an an-clock"></i>
                        </div>
                        <h5>@lang('home.saveTime')</h5>
                        <p class="text-muted">@lang('home.saveTimeDesc')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="item card box-shadow">
                        <div class="icon d-flex justify-content-center align-items-center bg-danger">
                            <i class="an an-check-double"></i>
                        </div>
                        <h5>@lang('home.smartWork')</h5>
                        <p class="text-muted">@lang('home.smartWorkDesc')</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="item card box-shadow">
                        <div class="icon d-flex justify-content-center align-items-center bg-blue">
                            <i class="an an-thumbs-up"></i>
                        </div>
                        <h5>@lang('home.easyLife')</h5>
                        <p class="text-muted">@lang('home.easyLifeDesc')</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="tools">
        <div class="container">
            <div class="title mb-5">
                <h2 class="uppercase">@lang('home.discoverApp')</h2>
                <p>@lang('home.discoverAppDesc')</p>
            </div>
            <div class="row tools-wrap match-height">
                @foreach ($usecases as $usecase)
                    <div class="col-md-4">
                        <div class="item box-shadow">
                            <a href="{{ route('document.index', ['usecase' => $usecase->id]) }}">
                                <div class="card">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        @if ($usecase->icon_type == 'class')
                                            <i class="an an-{{ $usecase->icon_class }}"></i>
                                        @elseif ($usecase->getFirstMediaUrl('usecase-icon'))
                                            <img src="{{ $usecase->getFirstMediaUrl('usecase-icon') }}"
                                                alt="{{ $usecase->name }}" width="36">
                                        @endif
                                    </div>
                                    <div class="contant">
                                        <h4>{{ $usecase->name }}</h4>
                                        <p>{{ $usecase->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="faster-writing">
        <div class="container">
            <div class="row">
                <div class="title col-lg-12 col-md-6 col-sm-12">
                    <h2 class="uppercase">@lang('home.generateEffortlessly')</h2>
                    <p>@lang('home.generateEffortlesslyDesc')</p>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="icon bg-warning d-flex justify-content-center align-items-center">
                            <i class="an an-crown"></i>
                        </div>
                        <div class="contant">
                            <h6>@lang('home.stepOne')</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="icon bg-primary d-flex justify-content-center align-items-center">
                            <i class="an an-credit-card-alt"></i>
                        </div>
                        <div class="contant">
                            <h6>@lang('home.stepTwo')</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="icon bg-danger d-flex justify-content-center align-items-center">
                            <i class="an an-feather"></i>
                        </div>
                        <div class="contant">
                            <h6>@lang('home.stepThree')</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="how-it-works">
        <div class="container">
            <div class="title mb-5">
                <h2 class="uppercase">@lang('home.howItWorks')</h2>
                <p>@lang('home.howItWorksDesc')</p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/themes/neuralink/assets/images/start.svg') }}"
                                alt="@lang('home.howItWorks')">
                        </div>
                        <div class="contant">
                            <h5>@lang('home.howItWorksOne')</h5>
                            <p>@lang('home.howItWorksOneDesc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/themes/neuralink/assets/images/generate.svg') }}"
                                alt="@lang('home.howItWorksTwo')">
                        </div>
                        <div class="contant">
                            <h5>@lang('home.howItWorksTwo')</h5>
                            <p>@lang('home.howItWorksTwoDesc')</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/themes/neuralink/assets/images/revies.svg') }}"
                                alt="@lang('home.howItWorksThree')">
                        </div>
                        <div class="contant">
                            <h5>@lang('home.howItWorksThree')</h5>
                            <p>@lang('home.howItWorksThreeDesc')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pricing-table">
        <div class="container">
            <div class="title text-center">
                <h1>@lang('common.pricingTable')</h1>
                <p>@lang('common.pricingTableDescription')</p>
            </div>
            <div class="row">
                <div class="container">
                    <div class="row white-bg top-0">
                        <input type="hidden" id="dateinput" name="date" />
                        <div id="content">
                            <input id="input-switch-month" type="radio" name="input-switch-os"
                                onclick="ChangeStateInfos()" checked="checked" />
                            <input id="input-switch-year" type="radio" name="input-switch-os"
                                onclick="ChangeStateInfos()" />
                            <div id="top-switch-labels">
                                <label id="top-switch-label-month" for="input-switch-month">@lang('common.monthly')</label>
                                <label id="top-switch-label-year" for="input-switch-year">@lang('common.yearly')</label>
                            </div>
                            <div id="month-new-wrapper">
                                <div class="row">
                                    @foreach ($plans as $plan)
                                        <div
                                            class="col-sm-12 col-lg-{{ floor(12 / $plans->count()) }} col-md-{{ floor(12 / $plans->count()) }}">
                                            <div
                                                class="pricing box-shadow @if ($plan->recommended == 1) featured @endif p-0">
                                                @if ($plan->recommended == 1)
                                                    <div class="listing-badges">
                                                        <span class="featured">@lang('common.recommended')</span>
                                                    </div>
                                                @endif
                                                <div class="price-header">
                                                    <div class="price">
                                                        <x-money amount="{{ $plan->monthly_price }}"
                                                            currency="{{ setting('currency', 'usd') }}" convert />
                                                        <span> / @lang('common.month')</span>
                                                    </div>
                                                    <div class="plan-title">{{ $plan->name }}</div>
                                                </div>
                                                <div class="content">
                                                    <ul class="list-check mb-0">
                                                        <li class="check">
                                                            <p>@lang('common.countNoOfWords', ['words' => $plan->no_of_words]) </p>
                                                        </li>
                                                        <li class="check">
                                                            <p>@lang('common.countUsecaseDailyUsageLimit', ['usecase' => $plan->usecase_daily_limit])</p>
                                                        </li>
                                                        <li
                                                            class="@if ($plan->is_support == 1) check @else cross @endif">
                                                            <p>@lang('common.support')</p>
                                                        </li>
                                                        <li class="check">
                                                            <p>@lang('common.countUsecases', ['usecases' => $plan->usecases->count()])</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price-footer">
                                                    <a href="{{ route('payments.checkout', ['plan_id' => $plan->id, 'type' => 'monthly']) }}"
                                                        class="btn btn-primary">@lang('common.getStarted')</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="year-new-wrapper">
                                <div class="row">
                                    @foreach ($plans as $plan)
                                        <div
                                            class="col-sm-12 col-lg-{{ floor(12 / $plans->count()) }} col-md-{{ floor(12 / $plans->count()) }}">
                                            <div
                                                class="pricing box-shadow @if ($plan->recommended == 1) featured @endif p-0">
                                                @if ($plan->recommended == 1)
                                                    <div class="listing-badges">
                                                        <span class="featured">@lang('common.recommended')</span>
                                                    </div>
                                                @endif
                                                <div class="price-header">
                                                    <div class="price">
                                                        <x-money amount="{{ $plan->yearly_price }}"
                                                            currency="{{ setting('currency', 'usd') }}" convert />
                                                        <span> / @lang('common.year')</span>
                                                    </div>
                                                    <div class="plan-title">{{ $plan->name }}</div>
                                                </div>
                                                <div class="content">
                                                    <ul class="list-check mb-0">
                                                        <li class="check">
                                                            <p>@lang('common.countNoOfWords', ['words' => $plan->no_of_words]) </p>
                                                        </li>
                                                        <li class="check">
                                                            <p>@lang('common.countUsecaseDailyUsageLimit', ['usecase' => $plan->usecase_daily_limit])</p>
                                                        </li>
                                                        <li
                                                            class="@if ($plan->is_support == 1) check @else cross @endif">
                                                            <p>@lang('common.support')</p>
                                                        </li>
                                                        <li class="check">
                                                            <p>@lang('common.countUsecases', ['usecases' => $plan->usecases->count()])</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price-footer">
                                                    <a href="{{ route('payments.checkout', ['plan_id' => $plan->id, 'type' => 'yearly']) }}"
                                                        class="btn btn-primary">@lang('common.getStarted')</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('page_scripts')
        <script>
            const APP = function() {
                const typedTextSpan = document.querySelector(".typed-text");
                const cursorSpan = document.querySelector(".cursor");
                const textArray = @json(__('HomepageWriting'));
                const typingDelay = 200;
                const erasingDelay = 100;
                const newTextDelay = 3000;
                let textArrayIndex = 0;
                let charIndex = 0;
                const type = function() {
                        if (charIndex < textArray[textArrayIndex].length) {
                            if (!cursorSpan.classList.contains("typing")) cursorSpan.classList.add("typing");
                            typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
                            charIndex++;
                            setTimeout(type, typingDelay);
                        } else {
                            cursorSpan.classList.remove("typing");
                            setTimeout(erase, newTextDelay);
                        }

                    },
                    erase = function() {
                        if (charIndex > 0) {
                            if (!cursorSpan.classList.contains("typing")) cursorSpan.classList.add("typing");
                            typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
                            charIndex--;
                            setTimeout(erase, erasingDelay);
                        } else {
                            cursorSpan.classList.remove("typing");
                            textArrayIndex++;
                            if (textArrayIndex >= textArray.length) textArrayIndex = 0;
                            setTimeout(type, typingDelay + 1100);
                        }
                    };
                return {
                    init: function() {
                        type()
                    }
                }
            }();

            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-front-layout>
