<x-document-layout>
    <div class="app-body">
        <div class="sidebar">
            <x-document-form :selected_usecase="$selected_usecase" :langs="$langs" :tones="$tones" :variants="$variants" :creativities="$creativities"
                :usecases="$usecases" :selected_document="$selected_document" />
        </div>
        <div class="main">
            <div class="dashboard-page-header d-flex align-items-center justify-content-between">
                <div class="page-title float-start ">
                    <h5 class="mb-0">
                        @if ($selected_document != null)
                            <x-form method="post" id="updateDocument" :route="route('document.updateDocument', ['document' => $selected_document->id])">
                                <input value="{{ $selected_document->name }}" type="text" required name="name"
                                    class="form-control" id="document-name-input" />
                            </x-form>
                        @else
                            @lang('document.documents')
                        @endif
                    </h5>
                </div>
                <div class="action float-end">
                    @if ($selected_document != null)
                        <a href="{{ route('document.downloadDocument', ['document' => $selected_document->id]) }}"
                            type="button" class="btn btn-primary rounded-pill btn-icon"><i
                                class="an an-file-alt"></i></a>
                        <a href="{{ route('document.favouriteAction', ['document' => $selected_document->id]) }}"
                            type="button" class="btn btn-warning rounded-pill btn-icon"><i
                                class="an @if ($selected_document->is_favourite == 1) an-star-alt @else an-star-alt @endif "></i></a>
                    @endif
                    <a href="{{ route('document.index') }}" type="button" class="btn btn-danger rounded-pill btn-icon">
                        <i class="an an-plus"></i>
                    </a>
                </div>
            </div>
            <div class="dashboard-contant">
                @if ($selected_document == null)
                    <x-document-list :documents="$documents" />
                @else
                    <x-document-open :selected_document="$selected_document" />
                @endif
            </div>
        </div>
    </div>
    @push('page_scripts')
        <script>
            const APP = function() {
                const getView = function() {
                        var usecase = document.getElementById('usecase_id').value;
                        FrontApp.showLoader()
                        axios.post(
                                '{{ route('document.getFields') }}', {
                                    id: usecase
                                })
                            .then((res) => {
                                FrontApp.hideLoader()
                                document.getElementById('fields-div').innerHTML = res.data.view;
                            })
                            .catch((err) => {
                                FrontApp.hideLoader()
                                resultError(element, cursor)
                            })
                    },
                    sendRequest = function() {
                        document.getElementById("submit-form").disabled = true;
                        document.getElementById("submit-form").innerHTML =
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                        serialized = FrontApp.serializeForm(document.getElementById('document-form'));
                        axios.post(
                                '{{ route('document.storeDocument', ['document' => $selected_document->id ?? 0]) }}',
                                serialized)
                            .then((res) => {
                                FrontApp.hideLoader()
                                if (res.data.success == true) {
                                    AIDocument.moveCursorToStart()
                                    var markdown = res.data.data + '\n\n — \n\n' + AIDocument.getMarkdown()
                                    AIDocument.setMarkdown(markdown, true)
                                    AIDocument.moveCursorToStart()
                                } else {
                                    FrontApp.toastError(res.data.message);
                                }
                                document.getElementById("submit-form").disabled = false;
                                document.getElementById("submit-form").innerHTML = 'Submit';

                            })
                            .catch((err) => {
                                console.log(err);
                                document.getElementById("submit-form").disabled = false;
                                document.getElementById("submit-form").innerHTML = 'Submit';
                            })
                    },
                    updateDocumentName = function() {
                        serialized = FrontApp.serializeForm(document.getElementById('updateDocument'));
                        axios.post(
                                '{{ route('document.updateDocument', ['document' => $selected_document->id ?? null]) }}',
                                serialized)
                            .then((res) => {
                                FrontApp.toastSuccess(res.data.message);
                            })
                            .catch((err) => {
                                console.log(err);
                            })
                    },
                    attachEvents = function() {
                        document.querySelectorAll('#usecase_id').forEach(button => {
                            button.onchange = function() {
                                getView()
                            }
                        });

                        document.querySelectorAll('#submit-form').forEach(button => {
                            button.onclick = function() {
                                sendRequest()
                            }
                        });

                        document.querySelectorAll('#document-name-input').forEach(button => {
                            button.onblur = function() {
                                updateDocumentName()
                            }
                        });
                    };
                return {
                    init: function() {
                        attachEvents();
                        getView();
                    }
                }
            }()
            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-document-layout>
