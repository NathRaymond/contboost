@props([
    'route' => route('admin.tools.edit', $tool),
    'title' => __('admin.editTool'),
    'button_text' => __('common.save'),
    'tool' => null,
    'locales',
    'categories',
    'tags',
])

<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $tool->id ?? null }}">
    <div class="row">
        <div class="col-md-12">
            @if ($locales->count() !== 1)
                <ul class="nav nav-tabs mb-3" role="tablist">
                    @foreach ($locales as $locale)
                        <li class="nav-item">
                            <a class="nav-link @if ($loop->first) active @endif" data-coreui-toggle="tab"
                                href="#locale_{{ $locale->locale }}" role="tab" aria-controls="{{ $locale->name }}">
                                <i class="icon-arrow-right"></i> {{ $locale->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="tab-content">
        @foreach ($locales as $locale)
            @if (isset($tool))
                @php($tool_locale = $tool->translate($locale->locale))
            @endif
            <div class="tab-pane @if ($loop->first) active @endif" id="locale_{{ $locale->locale }}">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card mb-4">
                            <div class="card-header">{{ $title }}</div>
                            <div class="card-body">
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <input
                                            class="form-control @error($locale->locale . '.name') is-invalid @enderror name"
                                            id="{{ $locale->locale }}-name" placeholder="@lang('common.name')"
                                            name="{{ $locale->locale }}[name]"
                                            value="{{ $tool_locale->name ?? old($locale->locale . '.name') }}"
                                            type="text" @if ($loop->first) required autofocus @endif>
                                        @error($locale->locale . '.name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <span class="small text-muted">@lang('admin.nameHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <input
                                            class="form-control @error($locale->locale . '.title') is-invalid @enderror slug_title"
                                            id="{{ $locale->locale }}-title" name="{{ $locale->locale }}[title]"
                                            placeholder="@lang('common.title')"
                                            value="{{ $tool_locale->title ?? old($locale->locale . '.title') }}"
                                            type="text" @if ($loop->first) required @endif>
                                        @error($locale->locale . '.title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <span class="small text-muted">@lang('admin.titleHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <input class="form-control @error($tool->slug) is-invalid @enderror slug"
                                            id="slug" placeholder="@lang('admin.slug')" name="slug"
                                            value="{{ $tool->slug ?? old($tool->slug) }}" type="text"
                                            @if ($loop->first) required autofocus @endif>
                                        @error($tool->slug)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <span class="small text-muted">@lang('admin.slugHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <textarea class="form-control @error($locale->locale . '.content') is-invalid @enderror"
                                            id="{{ $locale->locale }}-content" placeholder="@lang('common.content')" name="{{ $locale->locale }}[description]">{{ $tool_locale->description ?? old($locale->locale . '.description') }}</textarea>
                                        <span class="small text-muted">@lang('admin.contentHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <textarea id="{{ $locale->locale }}_editor" name="{{ $locale->locale }}[content]" class="editor">{!! $tool_locale->content ?? old($locale->locale . '.content') !!}</textarea>
                                    </div>
                                </div>
                                @if (isset($tool) && $tool->icon)
                                    <div class="form-group mb-2">
                                        <img src="{{ url($tool->icon) }}" class="img-fluid rounded">
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <label for="icon" class="form-col-form-label">@lang('admin.icon')</label>
                                    <div class="input-group">
                                        <input class="form-control @error($tool->icon) is-invalid @enderror filepicker"
                                            id="icon" name="icon" value="{{ $tool->icon }}" type="file">
                                        <span class="small text-muted">@lang('common.ogImageHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit"> {{ $button_text }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-header">@lang('common.seoSettings')</div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-meta_title">@lang('common.metaTitle')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.meta_title') is-invalid @enderror"
                                        id="{{ $locale->locale }}-meta_title" name="{{ $locale->locale }}[meta_title]"
                                        value="{{ $tool_locale->meta_title ?? old($locale->locale . '.meta_title') }}"
                                        type="text">
                                    <span class="small text-muted">@lang('common.metaTitleHelp')</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-meta_description">@lang('common.metaDescription')</label>
                                    <textarea class="form-control @error($locale->locale . '.meta_description') is-invalid @enderror"
                                        id="{{ $locale->locale }}-meta_description" name="{{ $locale->locale }}[meta_description]">{{ $tool_locale->meta_description ?? old($locale->locale . '.meta_description') }}</textarea>
                                    <span class="small text-muted">@lang('common.metaDescriptionHelp')</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">@lang('common.ogSettings')</div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-og_title">@lang('common.ogTitle')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.og_title') is-invalid @enderror"
                                        id="{{ $locale->locale }}-og_title" name="{{ $locale->locale }}[og_title]"
                                        value="{{ $tool_locale->og_title ?? old($locale->locale . '.og_title') }}"
                                        type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-og_description">@lang('common.ogDescription')</label>
                                    <textarea class="form-control @error($locale->locale . '.og_description') is-invalid @enderror"
                                        id="{{ $locale->locale }}-og_description" name="{{ $locale->locale }}[og_description]">{{ $tool_locale->og_description ?? old($locale->locale . '.og_description') }}</textarea>
                                    <span class="small text-muted">@lang('common.ogDescriptionHelp')</span>
                                </div>
                                @if (isset($tool_locale) && $tool_locale->og_image)
                                    <div class="form-group mb-2">
                                        <img src="{{ url($tool_locale->og_image) }}" class="img-fluid rounded">
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}_og_image"
                                        class="form-col-form-label">@lang('common.image')</label>
                                    <div class="input-group">
                                        <input
                                            class="form-control @error($locale->locale . '.og_image') is-invalid @enderror filepicker"
                                            id="{{ $locale->locale }}_og_image"
                                            name="{{ $locale->locale }}[og_image]"
                                            value="{{ $tool_locale->og_image ?? old($locale->locale . '.og_image') }}"
                                            type="file">
                                        <span class="small text-muted">@lang('common.ogImageHelp')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">@lang('admin.category')</div>
                            <div class="card-body">
                                <div class="form-group mb-3 row">
                                    <label for="author_id">@lang('admin.selectCategories')</label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="category" name="category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">@lang('admin.tags')</div>
                            <div class="card-body">
                                <div class="form-group mb-3 row">
                                    <label for="author_id">@lang('admin.selectTags')</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>

                                        <span class="small text-muted">@lang('admin.tagHelp')</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</form>

@section('footer_scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        document.querySelectorAll('.editor').forEach(elem => {
            ClassicEditor.create(elem, {
                    simpleUpload: {
                        uploadUrl: '{{ route('uploader.upload') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    },
                })
                .then(editor => {})
                .catch(error => {
                    console.log('error', error);
                });
        });

        Tags.init();
    </script>
@endsection
