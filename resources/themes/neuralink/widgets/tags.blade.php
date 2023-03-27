@if ($tags && $tags->count() > 0)
    <x-widget-wrapper :title="$title">
        @foreach ($tags as $tag)
            <a class="btn btn-primary rounded-pill me-1 mb-2"
                href="{{ route('blog.tag', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
        @endforeach
    </x-widget-wrapper>
@endif
