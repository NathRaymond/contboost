@props([
    'route' => null,
    'method' => 'post',
    'id' => null,
    'enctype' => 'multipart/form-data',
])
<form id="{{$id}}" method="{{ $method }}" action='{{ $route }}' enctype='{{$enctype}}'>
    @csrf
    {{ $slot }}
</form>
