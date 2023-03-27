<x-app-layout>
    <div class="row">
        <div class="col-md-12">
            <x-manage-filters :search="true" :search-route="route('admin.usecases')" />
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">@lang('admin.manageUsecases')</h6></div>
                <div class="card-body px-3">
                    <table class="table table-responsive-sm mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th>@lang('admin.icon')</th>
                                <th>@lang('common.title')</th>
                                <th>@lang('common.description')</th>
                                <th>@lang('admin.order')</th>
                                <th>@lang('common.status')</th>
                                <th width="150">@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usecases as $usecase)
                                <tr class="align-middle">
                                    <td>@if ($usecase->icon_type == 'class')
                                            <i class="an an-{{ $usecase->icon_class }} text-muted"></i>
                                        @elseif ($usecase->getFirstMediaUrl('usecase-icon'))
                                            <img src="{{ $usecase->getFirstMediaUrl('usecase-icon') }}"
                                                alt="{{ $usecase->name }}" width="36">
                                        @endif</td>
                                    <td>{{ $usecase->name }}</td>
                                    <td class="text-muted">{{ $usecase->description }}</td>
                                    <td>{{ $usecase->order }}</td>
                                    <td>
                                        @if ($usecase->status == 1)
                                            <span class="badge me-1 bg-success">@lang('common.active')</span>
                                        @else
                                            <span class="badge me-1 bg-danger">@lang('common.inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content start">
                                            <a href="{{ route('admin.usecases.edit', $usecase) }}"
                                                class="btn btn-link text-body" role="button" data-toggle="tooltip"
                                                data-original-title="@lang('common.edit')"><span
                                                    class="lni lni-pencil-alt"></span></a>
                                            @if ($usecase->status == 0)
                                                <a href="{{ route('admin.usecases.status.change', ['id' => $usecase->id, 'status' => 1]) }}"
                                                    class="btn btn-link text-body" role="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.active')"><span
                                                        class="lni lni-checkmark-circle"></span></a>
                                            @else
                                                <a href="{{ route('admin.usecases.status.change', ['id' => $usecase->id, 'status' => 0]) }}"
                                                    class="btn btn-link text-body" role="button" data-toggle="tooltip"
                                                    data-original-title="@lang('common.active')"><span
                                                        class="lni lni-circle-minus"></span></a>
                                            @endif

                                            <form action="{{ route('admin.usecases.destroy', $usecase->id) }}" method="POST"
                                                class="d-inline-block">
                                                @method('DELETE')
                                                @csrf<button class="btn btn-link text-danger warning-delete frm-submit"
                                                    role="button" data-bs-toggle="tooltip" data-placement="right"
                                                    title="@lang('common.delete')"><span
                                                        class="lni lni-trash"></span></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="22">@lang('common.noRecordsFund')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($usecases->hasPages())
                    <div class="card-footer">
                        {{ $usecases->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
