@props([
    'plan' => null,
    'locales',
    'usecases' => null,
])
<form action="{{ isset($plan) ? route('admin.plans.update', $plan) : route('admin.plans.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $plan->id ?? null }}">

    <div class="row match-height">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ isset($tag) ? __('common.edit') : __('common.createNew') }}</h6>
                </div>
                <div class="card-body">
                    @if ($locales->count() > 1)
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($locales as $index => $locale)
                                <li class="nav-item">
                                    <a class="nav-link @if ($index == 0) active @endif"
                                        data-coreui-toggle="tab" href="#locale_{{ $locale->locale }}" role="tab"
                                        aria-controls="{{ $locale->name }}">
                                        <i class="icon-arrow-right"></i> {{ $locale->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="tab-content">
                        @foreach ($locales as $index => $locale)
                            @if (isset($plan))
                                @php($plan_locale = $plan->translate($locale->locale))
                            @endif
                            <div class="tab-pane @if ($index == 0) active @endif"
                                id="locale_{{ $locale->locale }}" role="tabpanel">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('common.name')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.name') is-invalid @enderror slug_title"
                                        id="{{ $locale->locale }}[name]" name="{{ $locale->locale }}[name]"
                                        value="{{ $plan_locale->name ?? old($locale->locale . '.name') }}"
                                        type="text" placeholder="@lang('common.enterName')"
                                        @if ($index == 0) required autofocus @endif>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('common.description')</label>
                                    <textarea class="form-control @error($locale->locale . '.description') is-invalid @enderror"
                                        id="{{ $locale->locale }}[description]" name="{{ $locale->locale }}[description]">{{ $plan_locale->description ?? old($locale->locale . '.description') }}</textarea>
                                    <span class="small text-muted">@lang('admin.descriptionHelpPlan')</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="yearly_price" class="form-label">@lang('admin.yearlyPrice')</label>
                            <input class="form-control" id="yearly_price" name="yearly_price"
                                value="{{ $plan->yearly_price ?? old('yearly_price') }}" type="number"
                                placeholder="@lang('admin.yearlyPrice')">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="monthly_price" class="form-label">@lang('admin.monthlyPrice')</label>
                            <input class="form-control" id="monthly_price" name="monthly_price"
                                value="{{ $plan->monthly_price ?? old('monthly_price') }}" type="number"
                                placeholder="@lang('admin.monthlyPrice')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">@lang('admin.options')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="no_of_words" class="form-label">@lang('admin.noOfWords')</label>
                            <input class="form-control" id="no_of_words" name="no_of_words"
                                value="{{ $plan->no_of_words ?? old('no_of_words') }}" type="number"
                                placeholder="@lang('admin.words')">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="usecase_daily_limit" class="form-label">@lang('admin.usecaseDailyLimit')</label>
                            <input class="form-control" id="usecase_daily_limit" name="usecase_daily_limit"
                                value="{{ $plan->usecase_daily_limit ?? old('usecase_daily_limit') }}" type="number"
                                placeholder="@lang('admin.usecaseDailyLimit')">
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="form-check form-switch form-switch-xl mb-3">
                                <input class="form-check-input" value="1"
                                    @if (isset($plan) && $plan->is_support == 1) checked @endif id="is_support" name="is_support"
                                    type="checkbox">
                                <label class="form-check-label ms-2" for="is_support">@lang('admin.support')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">@lang('admin.useCases')</h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    <div class="row">
                        @if ($usecases != null)
                            @foreach ($usecases as $usecase)
                                <div class="col-md-3">
                                    <div class="form-check form-switch form-switch-xl mb-3">
                                        <input class="form-check-input" value="{{ $usecase->id }}"
                                            id="usecases_{{ $usecase->id }}" name="usecases[]" type="checkbox"
                                            @if (isset($plan) && $plan->usecases->where('id', $usecase->id)->count() > 0) checked @endif>
                                        <label class="form-check-label ms-2"
                                            for="usecases_{{ $usecase->id }}">{{ $usecase->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <button type="submit" class="btn btn-primary">@lang('common.save')</button>
    </div>
</form>
