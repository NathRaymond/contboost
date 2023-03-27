<x-app-layout>
    <x-manage-filters :button="__('common.createNew')" :route="route('admin.posts.create')" :search="true" :search-route="route('admin.posts')" />
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">@lang('admin.managePost')</div>
                <div class="card-body px-3">
                    <table class="table table-responsive-sm mb-0">
                        <thead>
                            <tr class="align-middle">
                                <th></th>
                                <th>@lang('common.title')</th>
                                <th>@lang('admin.author')</th>
                                <th>@lang('admin.tags')</th>
                                <th>@lang('admin.categories')</th>
                                <th>@lang('common.status')</th>
                                <th>@lang('common.dateAdded')</th>
                                <th width="150">@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr class="align-middle">
                                    <td>
                                        @if ($post->getFirstMediaUrl('featured-image'))
                                            <img src="{{ $post->getFirstMediaUrl('featured-image') }}"
                                                alt="{{ $post->title }}" class="img-fluid rounded" width="75">
                                        @endif
                                    </td>
                                    <td><strong>{{ $post->title }}</strong></td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>
                                        @foreach ($post->tags as $tag)
                                            <span class="badge badge-pill bg-dark">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($post->categories as $category)
                                            <span class="badge badge-pill bg-dark">{{ $category->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="badge text-capitalize {{ $post->status == 'draft' ? 'bg-warning' : 'bg-success' }}">
                                            {{ $post->status }} </span>
                                    </td>
                                    <td>{{ $post->created_at->format(setting('datetime_format', 'F d, Y h:ia')) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content start">
                                            @if (!empty($post->slug))
                                                <a href="#" target="_blank" class="btn btn-link text-body"
                                                    role="button" data-toggle="tooltip" data-placement="left"
                                                    title="@lang('common.view')"><span class="lni lni-eye"></span></a>
                                            @endif
                                            <a href="{{ route('admin.posts.edit', $post) }}"
                                                class="btn btn-link text-body" role="button" data-toggle="tooltip"
                                                data-original-title="@lang('common.edit')"><span
                                                    class="lni lni-pencil-alt"></span></a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
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
                @if ($posts->hasPages())
                    <div class="card-footer">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
