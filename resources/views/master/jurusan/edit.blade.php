<x-main-layout title="E-Complaint Jurusan-Edit">
    <div class="card m-auto col-8">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Edit Jurusan</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('master.jurusan.update', $jurusan) }}" method="POST">
                @csrf
                @if (request()->routeIs('master.jurusan.edit'))
                    @method('PUT')
                @endif

                <livewire:slug-pretty :jurusan="$jurusan" />

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Edit</button>
                <a href="{{ route('master.jurusan.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>
            </form>
        </div>
    </div>
</x-main-layout>
