@props([
    'langs' => null,
    'tones' => null,
    'variants' => null,
    'creativities' => null,
    'usecases' => null,
    'selected_document' => null,
    'selected_usecase' => null,
])
<x-form method="post" :route="route('document.storeDocument', ['document' => $selected_document->id ?? null])" id="document-form">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="language" class="form-label">@lang('document.selectLang')</label>
            <select class="form-select" aria-label="Default select example" name="language">
                @foreach ($langs as $key => $lang)
                    <option value="{{ $lang }}" @if ($key == app()->getLocale()) selected @endif>
                        {{ $lang }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="tone" class="form-label">@lang('document.selectTone')</label>
            <select class="form-select" aria-label="Default select example" name="tone">
                @foreach ($tones as $key => $tone)
                    <option value="{{ $key }}">{{ $tone }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="language" class="form-label">@lang('document.selectUsecase')</label>
            <select id="usecase_id" class="form-select" aria-label="Default select example"
                name="usecase_id" onchange="getFields()">
                @foreach ($usecases as $usecase)
                    <option value="{{ $usecase->id }}" @if ($selected_usecase != null && $selected_usecase->id == $usecase->id) selected @endif>
                        {{ $usecase->name }}</option>
                @endforeach
            </select>
        </div>
        <div id="fields-div">
        </div>
        <div class="col-md-6 mb-3">
            <label for="variants" class="form-label">@lang('document.noOfVariant')</label>
            <select class="form-select" aria-label="Default select example" name="variant">
                @foreach ($variants as $key => $variant)
                    <option value="{{ $variant }}">{{ $variant }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="language" class="form-label">@lang('document.writtingStyle')</label>
            <select class="form-select" aria-label="Default select example" name="style">
                @foreach ($creativities as $key => $creativity)
                    <option value="{{ $key }}">{{ $creativity }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 mb-3">
            @if ($selected_document == null)
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            @else
                <button type="button" id="submit-form" class="btn btn-primary w-100">Submit</button>
            @endif
        </div>
    </div>
</x-form>
