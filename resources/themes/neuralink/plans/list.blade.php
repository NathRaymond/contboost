<x-front-layout>
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
                                        <div class="col-sm-12 col-lg-4 col-md-4">
                                            <div
                                                class="pricing box-shadow @if ($plan->recommended == 1) featured @endif p-0">
                                                @if ($plan->recommended == 1)
                                                    <div class="listing-badges">
                                                        <span class="featured">Featured</span>
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
                                        <div class="col-sm-12 col-lg-4 col-md-4">
                                            <div
                                                class="pricing box-shadow @if ($plan->recommended == 1) featured @endif p-0">
                                                @if ($plan->recommended == 1)
                                                    <div class="listing-badges">
                                                        <span class="featured">@lang('common.featured')</span>
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
</x-front-layout>
