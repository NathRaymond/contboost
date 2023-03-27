<x-front-layout>
    <div class="container">
        <div class="blog-wrapper my-5" id="blog-content">
            <div class="row">
                <div class="col">
                    {{ $slot }}
                </div>
                @if (!Widget::group('post-sidebar')->isEmpty())
                    <x-application-sidebar>
                        @widgetGroup('post-sidebar')
                    </x-application-sidebar>
                @endif
            </div>
        </div>
    </div>
</x-front-layout>
