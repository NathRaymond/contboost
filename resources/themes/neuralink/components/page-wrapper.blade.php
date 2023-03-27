@props([
    'title' => false,
    'subTitle' => false,
    'heading' => 'h2',
])
<div class="wrap-content">
    @if ($title || $subTitle)
        <div class="hero-title">
            @if ($title)
                <{{ $heading }}>{{ $title }}</{{ $heading }}>
            @endif
            @if ($subTitle)
                <p>{{ $subTitle ?? '' }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
