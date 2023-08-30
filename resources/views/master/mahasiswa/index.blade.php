<x-main-layout title="E-Complaint - Mahasiswa">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h4 class="card-title">Mahasiswa</h4>
            </div>
            <div class="header-action">
                <div class="text-end mb-2">
                    <a href="{{ route('master.mahasiswa.create') }}" class="btn btn-sm btn-primary"><i
                            class="fa-solid fa-circle-plus fa-fw"></i> Tambah Mahasiswa</a>
                    <a href="{{ route('master.mahasiswa.export') }}" class="btn btn-sm btn-warning"><i
                            class="fa-sharp fa-solid fa-file-export fa-fw"></i> Export Mahasiswa</a>
                </div>
                <form method="GET">
                    <div class="d-flex gap-2">
                        <input class="form-control form-control-sm" type="text" placeholder="Cari Mahasiswa"
                            name="searchMahasiswa" value="{{ request()->searchMahasiswa }}">
                        <select class="form-select form-select-sm" name="searchJurusan">
                            <option disabled selected>Filter Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan }}" @selected($jurusan == request()->searchJurusan)>
                                    {{ \Str::title($jurusan) }}</option>
                            @endforeach
                        </select>
                        <select class="form-select form-select-sm" name="searchAngkatan">
                            <option disabled selected>Filter Angkatan</option>
                            @foreach ($angkatans as $angkatan)
                                <option value="{{ $angkatan }}" @selected($angkatan == request()->searchAngkatan)>
                                    {{ $angkatan }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary d-inline"> Search</button>
                        <a href="{{ route('master.mahasiswa.index') }}" class="btn btn-sm btn-outline-warning">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Foto</th>
                            <th>Jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswas as $key => $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswas->firstItem() + $key }}</td>
                                <td>{{ $mahasiswa->name }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>
                                    <img class="theme-color-default-img img-fluid avatar avatar-45 avatar-rounded"
                                        src="{{ $mahasiswa->foto ? asset('storage/profile/' . $mahasiswa->foto) : asset('assets/images/avatars/01.png') }}"
                                        alt="foto-profile">
                                </td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 12px">
                                        {{ $mahasiswa->Jurusan->name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master.mahasiswa.edit', $mahasiswa) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i>
                                        Edit</a>
                                    <form method="POST" x-data="deleteData" @submit.prevent="deleteModel"
                                        data-model="{{ $mahasiswa->name }}"
                                        action="{{ route('master.mahasiswa.destroy', $mahasiswa) }}" class="d-inline">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Mahasiswa Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>

    @push('my-js')
        <script>
            const deleteData = () => {
                return {
                    deleteModel(e) {
                        Swal.fire({
                            title: `Apa kamu yakin ?`,
                            text: `Anda tidak akan dapat mengembalikan data ${e.target.dataset.model}!`,
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus itu!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                e.target.submit();
                            }
                        })
                    },
                }
            };
        </script>
    @endpush
</x-main-layout>
