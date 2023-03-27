@props([
    'documents' => null,
])
<table class="table mb-0">
    @if ($documents->hasPages())
        <caption>
            <div class="pagination float-end mt-2">
                {{ $documents->links('pagination::bootstrap-5') }}
            </div>
        </caption>
    @endif
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">@lang('document.name')</th>
            <th scope="col">@lang('document.words')</th>
            <th scope="col">@lang('document.favourite')</th>
            <th scope="col">@lang('document.action')</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($documents as $document)
            <tr>
                <th scope="row" class="file-type"><i class="an an-file-alt"></i></th>
                <td>
                    <a href="{{ route('document.index', ['document_id' => $document->id]) }}">
                        {{ $document->name }}
                    </a>
                </td>
                <td>{{ $document->no_of_words }}</td>
                <td class="fav @if ($document->is_favourite == 1) fav-active @endif">
                    <a href="{{ route('document.favouriteAction', ['document' => $document->id]) }}">
                        <i class="an an-star-alt"></i>
                    </a>
                </td>
                <td>
                    <div class="dropdown">
                        <a type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="an an-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('document.deleteDocument', ['document' => $document->id]) }}">
                                    <i class="an an-trash"></i> @lang('common.delete')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('document.index', ['document_id' => $document->id]) }}">
                                    <i class="an an-write"></i> @lang('common.edit')
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="20">@lang('document.noDocuments')</td>
            </tr>
        @endforelse
    </tbody>
</table>
