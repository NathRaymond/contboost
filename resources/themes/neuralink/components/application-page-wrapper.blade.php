<x-front-layout>
    <div class="container">
        <div class="page-wrapper my-5" id="page-content">
            <div class="row">
                <div class="col">
                    {{ $slot }}
                </div>
                @if (!Widget::group('pages-sidebar')->isEmpty())
                    <x-application-sidebar>
                        @widgetGroup('pages-sidebar')
                    </x-application-sidebar>
                @endif
            </div>
        </div>
    </div>
</x-front-layout>
