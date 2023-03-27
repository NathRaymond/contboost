@props([
    'target' => false,
])
<x-button type="button" class="copy-clipboard btn btn-link text-body" data-clipboard-target="#{{ $target }}"
    data-copied="@lang('common.copied')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('common.copyToClipboard') }}">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 368 512" style="enable-background:new 0 0 368 512;" xml:space="preserve">
        <path
            d="M298.1,466.9c0,7.3-5.9,13.1-13.1,13.1H13.1C5.9,480,0,474.1,0,466.9V115.1c0-7.3,5.9-13.1,13.1-13.1h30.6v321.1
	c0,7.3,5.9,13.1,13.1,13.1h241.3V466.9z M278.7,32v80.4c0,4.9,3.9,8.8,8.8,8.8h80.3L278.7,32z M367.8,149.2H259.6
	c-4.9,0-8.8-3.9-8.8-8.8V32H100.4c-7.3,0-13.1,5.9-13.1,13.1v343c0,7.3,5.9,13.1,13.1,13.1h254.5c7,0,12.7-5.4,13.1-12.2v-0.9
	L367.8,149.2z" />
    </svg>
</x-button>
