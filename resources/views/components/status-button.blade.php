@php
    $statusButton = [
        'failed' => ['danger', '<i class="fa-solid fa-circle-xmark fa-fw"></i>'],
        'success' => ['success', '<i class="fa-solid fa-circle-check fa-fw"></i>'],
        'process' => ['warning', '<i class="fa-solid fa-spinner fa-fw"></i>'],
        'pending' => ['secondary', '<i class="fa-solid fa-circle-info fa-fw"></i>'],
    ];
@endphp

@foreach ($statusButton as $key => $button)
    @if ($status == $key)
        <span class="d-inline-block py-1 badge bg-{{ $button[0] }}">
            {!! $button[1] !!} {{ $status }}</span>
    @endif
@endforeach
