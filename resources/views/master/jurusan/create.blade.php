<x-main-layout title="E-Complaint Jurusan-Tambah">
    <div class="card m-auto col-8">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Tambah Jurusan</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('master.jurusan.store') }}" method="POST">
                @csrf

                <livewire:slug-pretty :jurusan="$jurusan" />

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Tambah</button>
                <a href="{{ route('master.jurusan.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>

            </form>
        </div>
    </div>
</x-main-layout>
