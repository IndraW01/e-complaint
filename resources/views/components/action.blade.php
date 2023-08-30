@if ($route !== 'pengaduan')
    <a href="{{ route('master.' . $route . '.edit', $data) }}" class="btn btn-warning btn-sm"><i
            class="fa-solid fa-pen-to-square fa-fw"></i> {{ $route == 'user' ? 'Edit Role' : 'Edit' }}</a>
    <form method="POST" x-data="deleteData" @submit.prevent="deleteModel" data-model="{{ $data->name }}"
        action="{{ route('master.' . $route . '.destroy', $data) }}" class="d-inline">
        @csrf
        <input name="_method" type="hidden" value="DELETE">
        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
    </form>
@else
    <a href="{{ route($route . '.show', $data) }}" class="btn btn-info btn-sm"><i class="fa-solid fa-eye fa-fw"></i>
        Detail Pengaduan</a>
@endif
