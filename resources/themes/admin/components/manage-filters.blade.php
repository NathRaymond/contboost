@props([
    'search' => false,
    'searchPlaceholder' => __('common.searchStr'),
    'searchRoute' => null,
    'button' => __('common.createNew'),
    'button_class' => 'btn btn-outline-primary',
    'route' => null,
    'value' => request()->get('q'),
])

<div {{ $attributes->merge(['class' => 'row row-cols-lg-auto g-3 align-items-center justify-content-between mb-3']) }}>
    <div class="col-12">
        @if ($search)
            <form class="form-inline" action="{{ $searchRoute }}" method="get">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="{{ $searchPlaceholder }}"
                        value="{{ $value }}">
                    <button type="submit" class="btn btn-primary"><i class="lni lni-search"></i></button>
                </div>
            </form>
        @endif
    </div>
    <div class="col-12">
        @if ($route)
            <a href="{{ $route }}" class="{{ $button_class }}">{{ $button }}</a>
        @endif
        {{ $slot }}
    </div>
</div>
