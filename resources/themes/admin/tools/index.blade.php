<x-app-layout>
    <x-manage-filters :search="true" :search-route="route('admin.tools')" />
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">@lang('admin.manageTools')</div>
                <div class="card-body px-3">
                    <table class="table table-responsive-sm mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th>@lang('common.title')</th>
                                <th>@lang('common.status')</th>
                                <th>@lang('common.dateAdded')</th>
                                <th width="150">@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tools as $tool)
                                <tr class="align-middle">
                                    <td><strong>{{ $tool->title }}</strong></td>
                                    <td>
                                      @if ($tool->status === 1)
                                          <span class="badge bg-success"> @lang('common.active') </span>
                                      @else
                                          <span class="badge bg-danger">@lang('common.inactive')</span>
                                      @endif
                                    </td>
                                    <td>{{ $tool->created_at->format(setting('datetime_format', 'F d, Y h:ia')) }}</td>
                                    <td>
                                      <div class="d-flex align-items-center justify-content start">
                                          @if (!empty($tool->slug))
                                              <a href="#" target="_blank" class="btn btn-link text-body"
                                                  role="button" data-toggle="tooltip" data-placement="left"
                                                  title="@lang('common.view')"><span class="lni lni-eye"></span></a>
                                          @endif
                                          <a href="{{ route('admin.tools.edit', $tool) }}"
                                              class="btn btn-link text-body" role="button" data-toggle="tooltip"
                                              data-original-title="@lang('common.edit')"><span
                                                  class="lni lni-pencil-alt"></span></a>
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
                @if ($tools->hasPages())
                    <div class="card-footer">
                        {{ $tools->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
