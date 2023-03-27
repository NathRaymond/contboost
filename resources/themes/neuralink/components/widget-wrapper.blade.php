@props([
    'title' => false,
    'subTitle' => false,
])
<div {!! $attributes->merge(['class' => 'wrap-content widget-wrapper']) !!}>
    @if ($title || $subTitle)
        @if ($title)
            <h4>{{ $title }}</h4>
        @endif
    @endif
    {{ $slot }}
</div>
