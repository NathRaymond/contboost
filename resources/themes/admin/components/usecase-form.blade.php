@props([
    'usecase' => null,
    'locales',
])
<form action="{{ isset($usecase) ? route('admin.usecases.update', $usecase) : route('admin.usecases.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $usecase->id ?? null }}">
    <div class="row match-height">
        <div class="col-md-8 mb-3">
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
                            @if (isset($usecase))
                                @php($usecase_locale = $usecase->translate($locale->locale))
                            @endif
                            <div class="tab-pane @if ($index == 0) active @endif"
                                id="locale_{{ $locale->locale }}" role="tabpanel">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('common.name')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.name') is-invalid @enderror slug_title"
                                        id="{{ $locale->locale }}[name]" name="{{ $locale->locale }}[name]"
                                        value="{{ $usecase_locale->name ?? old($locale->locale . '.name') }}"
                                        type="text" placeholder="@lang('common.enterName')"
                                        @if ($index == 0) required autofocus @endif>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">@lang('common.description')</label>
                                    <textarea class="form-control @error($locale->locale . '.description') is-invalid @enderror"
                                        id="{{ $locale->locale }}[description]" name="{{ $locale->locale }}[description]">{{ $usecase_locale->description ?? old($locale->locale . '.description') }}</textarea>
                                    <span class="small text-muted">@lang('admin.descriptionHelpusecase')</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-12">
                            <label for="command" class="form-label">@lang('admin.command')</label>
                            <textarea class="form-control" id="command" name="command" type="text" placeholder="@lang('admin.command')">{{ $usecase->command ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-12">
                            <label for="command" class="form-label">@lang('admin.availableCodes')</label>
                            <div id="available-tags">
                                <button type="button" class="btn btn-sm btn-primary tagsbtn"
                                    data-value="[language]">[language]</button>
                                <button type="button" class="btn btn-sm btn-primary tagsbtn"
                                    data-value="[tone]">[tone]</button>
                                <button type="button" class="btn btn-sm btn-primary tagsbtn"
                                    data-value="[creativity]">[creativity]</button>
                                <button type="button" class="btn btn-sm btn-primary tagsbtn"
                                    data-value="[style]">[writing style]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"> @lang('common.icon')</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-12">
                            <label for="order" class="form-label">@lang('admin.order')</label>
                            <input class="form-control" id="order" name="order"
                                value="{{ $usecase->order ?? old('order') }}" type="number"
                                placeholder="@lang('admin.order')">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-label">@lang('admin.iconType')</label>
                            <select class="form-control" name="icon_type" id="icon_type">
                                <option value="file" @if (isset($usecase) && $usecase->icon_type == 'file') selected @endif>
                                    @lang('admin.file')</option>
                                <option value="class" @if (isset($usecase) && $usecase->icon_type == 'class') selected @endif>
                                    @lang('admin.class')</option>
                            </select>
                        </div>
                        <span class="small text-muted">@lang('admin.usecaseIconTypeHelp')</span>
                    </div>
                    <div class="form-group row mt-2">
                        <div class="input-group" data-conditional-name="icon_type" data-conditional-value="file">
                            <input
                                class="form-control @error(isset($usecase) && $usecase->icon) is-invalid @enderror filepicker"
                                id="icon" name="icon" value="{{ $usecase->icon ?? '' }}" type="file">
                        </div>
                        <span class="small text-muted">@lang('admin.usecaseIconHelp')</span>
                    </div>
                    <div class="form-group mb-3">
                        <div class="col-md-12" data-conditional-name="icon_type" data-conditional-value="class">
                            <label class="form-label">@lang('admin.iconClassName')</label>
                            <input class="form-control" id="class-list-name" name="icon_class" type="text"
                                value="{{ $usecase->icon_class ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <div class="icons-wrap" data-conditional-name="icon_type" data-conditional-value="class">
                            <ul id="icons" class="icons-list p-0 m-0">
                                @foreach (icons_class_lists() as $icons)
                                    <li data-toggle="usecasetip" title="{{ $icons }}">
                                        <button data-type="{{ $icons }}" type="button"
                                            class="usecase-icon-select btn btn-sm btn-dark"
                                            onclick="getClassListAttr(this)">
                                            <i class="an an-{{ $icons }}"></i>
                                            <span>{{ $icons }}</span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0"> @lang('admin.fields')</h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-primary btn-sm pull-right" onclick="addTextField()"><i
                                class="nav-icon lni lni-plus"></i> @lang('admin.textField')</a>
                        <a class="btn btn-primary btn-sm pull-right" onclick="addAreaField()"><i
                                class="nav-icon lni lni-plus"></i> @lang('admin.textArea')</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <ul id="sortlist" class="list-group list-group-flush">
                                @if (isset($usecase) && $usecase->fields != null)
                                    @foreach ($usecase->fields as $fields)
                                        <li class="list-group-item p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="accordion accordion-flush">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                id="headingtext_loop_{{ $loop->iteration }}">
                                                                <button class="accordion-button collapsed"
                                                                    type="button" data-coreui-toggle="collapse"
                                                                    data-coreui-target="#collapsetext_loop_{{ $loop->iteration }}"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    @if (isset($fields->type))
                                                                        <strong>
                                                                            {{ $fields->type == 'textfield' ? 'TextField' : 'TextArea' }}
                                                                        </strong>
                                                                    @endif
                                                                </button>
                                                            </h2>
                                                            <div class="accordion-collapse collapse"
                                                                id="collapsetext_loop_{{ $loop->iteration }}"
                                                                aria-labelledby="headingtext_loop_{{ $loop->iteration }}"
                                                                data-coreui-parent="#accordionExample">
                                                                <div class="accordion-body pt-4">
                                                                    <input type="hidden"
                                                                        value="{{ $fields->type ?? '' }}"
                                                                        name="field_type[]" />
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                class="form-label">@lang('admin.label')</label>
                                                                            <input class="form-control" name="label[]"
                                                                                type="text"
                                                                                value="{{ $fields->label ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                class="form-label">@lang('admin.placeholder')</label>
                                                                            <input class="form-control"
                                                                                name="placeholder[]" type="text"
                                                                                value="{{ $fields->placeholder ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                class="form-label">@lang('admin.maxLimit')</label>
                                                                            <input class="form-control" name="max[]"
                                                                                type="text"
                                                                                value="{{ $fields->max ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                class="form-label">@lang('admin.required')</label>
                                                                            <select class="form-control"
                                                                                name="required[]">
                                                                                <option value="1">Yes</option>
                                                                                <option value="0">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                class="form-label">@lang('admin.shortCodeToReplace')</label>
                                                                            <input class="form-control"
                                                                                name="short_code[]" type="text"
                                                                                value="{{ $fields->short_code ?? '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <button type="submit" class="btn btn-primary">@lang('common.save')</button>
    </div>
</form>

@section('footer_scripts')
    <script>
        function getClassListAttr(elem) {
            document.getElementById('class-list-name').value = elem.dataset.type;
        }
    </script>
    <script>
        function slist(target) {
            // (A) SET CSS + GET ALL LIST ITEMS
            target.classList.add("slist");
            let items = target.getElementsByTagName("li"),
                current = null;

            // (B) MAKE ITEMS DRAGGABLE + SORTABLE
            for (let i of items) {
                // (B1) ATTACH DRAGGABLE
                i.draggable = true;

                // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
                i.ondragstart = e => {
                    current = i;
                    for (let it of items) {
                        if (it != current) {
                            it.classList.add("hint");
                        }
                    }
                };

                // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
                i.ondragenter = e => {
                    if (i != current) {
                        i.classList.add("active");
                    }
                };

                // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
                i.ondragleave = () => i.classList.remove("active");

                // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
                i.ondragend = () => {
                    for (let it of items) {
                        it.classList.remove("hint");
                        it.classList.remove("active");
                    }
                };

                // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
                i.ondragover = e => e.preventDefault();

                // (B7) ON DROP - DO SOMETHING
                i.ondrop = e => {
                    e.preventDefault();
                    if (i != current) {
                        let currentpos = 0,
                            droppedpos = 0;
                        for (let it = 0; it < items.length; it++) {
                            if (current == items[it]) {
                                currentpos = it;
                            }
                            if (i == items[it]) {
                                droppedpos = it;
                            }
                        }
                        if (currentpos < droppedpos) {
                            i.parentNode.insertBefore(current, i.nextSibling);
                        } else {
                            i.parentNode.insertBefore(current, i);
                        }
                    }
                };
            }
        }

        slist(document.getElementById("sortlist"));
    </script>

    <script>
        var text_count = 0;

        function addTextField() {
            text_count++;
            var ul = document.getElementById('sortlist');
            textHtml = `<div class="row">
                                        <div class="col-md-12">
                                            <div class="accordion accordion-flush">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingtext_` + text_count +
                    `">
                                                        <button class="accordion-button collapsed fw-bold" type="button"
                                                            data-coreui-toggle="collapse" data-coreui-target="#collapsetext_` +
                    text_count + `"
                                                            aria-expanded="false" aria-controls="collapseOne">
                                                            TextField
                                                        </button>
                                                    </h2>
                                                    <div class="accordion-collapse collapse" id="collapsetext_` +
                    text_count + `"
                                                        aria-labelledby="headingtext_` + text_count + `"
                                                        data-coreui-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <input type="hidden" value="textfield"
                                                                name="field_type[]" />
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Label</label>
                                                                    <input class="form-control"
                                                                        name="label[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Placeholder</label>
                                                                    <input class="form-control"
                                                                        name="placeholder[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Max Limit</label>
                                                                    <input class="form-control"
                                                                        name="max[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Required</label>
                                                                    <select class="form-control"
                                                                        name="required[]" >
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Short Code To be Replaced</label>
                                                                    <input class="form-control"
                                                                        name="short_code[]" required type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
            var tempNode = document.createElement('li');
            tempNode.classList = 'list-group-item p-0';
            tempNode.id = `remove_div_text_${text_count}`
            tempNode.innerHTML = textHtml;
            ul.appendChild(tempNode);
            slist(ul);
        }
    </script>
    <script>
        var area_count = 0;

        function addAreaField() {
            area_count++;
            var ul = document.getElementById('sortlist');
            var areaHtml = `<div class="row">
                                        <div class="col-md-12">
                                            <div class="accordion accordion-flush">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading_` + area_count + `">
                                                        <button class="accordion-button collapsed fw-bold" type="button"
                                                            data-coreui-toggle="collapse" data-coreui-target="#collapse_` +
                    area_count + `"
                                                            aria-expanded="false" aria-controls="collapseOne">
                                                            TextArea
                                                        </button>
                                                    </h2>
                                                    <div class="accordion-collapse collapse" id="collapse_` + area_count + `"
                                                        aria-labelledby="heading_` + area_count + `"
                                                        data-coreui-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <input type="hidden" value="textarea"
                                                                name="field_type[]" />
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Label</label>
                                                                    <input class="form-control"
                                                                        name="label[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Placeholder</label>
                                                                    <input class="form-control"
                                                                        name="placeholder[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Max Limit</label>
                                                                    <input class="form-control"
                                                                        name="max[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Required</label>
                                                                    <select class="form-control"
                                                                        name="required[]" >
                                                                        <option value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                        </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Short Code To be Replaced</label>
                                                                    <input class="form-control"
                                                                        name="short_code[]" required type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
            var tempNode = document.createElement('li');
            tempNode.classList = 'list-group-item p-0';
            tempNode.id = `remove_div_${area_count}`
            tempNode.innerHTML = areaHtml;
            ul.appendChild(tempNode);
            slist(ul);
        }
    </script>
    <script>
        document.querySelectorAll('.tagsbtn').forEach(button => {
            button.onclick = function() {
                var textareaPromp = document.getElementById("command");
                textareaPromp.value = textareaPromp.value + ' ' + button.getAttribute('data-value');
            }
        });
    </script>
@endsection
