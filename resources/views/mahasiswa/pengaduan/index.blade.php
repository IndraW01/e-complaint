<x-main-layout title="E-Complaint - Pengaduan Saya">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h4 class="card-title">Pengaduan Saya</h4>
            </div>
            <div class="header-action">
                <div class="text-end mb-2">
                    <a href="{{ route('mahasiswa.pengaduanSaya.create') }}" class="btn btn-sm btn-primary"><i
                            class="fa-solid fa-circle-plus fa-fw"></i> Tambah Pengaduan</a>
                </div>
                <form method="GET">
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" name="searchStatus">
                            <option disabled selected>Filter Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($status == request()->searchStatus)>
                                    {{ \Str::title($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary d-inline"> Search</button>
                        <a href="{{ route('mahasiswa.pengaduanSaya.index') }}"
                            class="btn btn-sm btn-outline-warning">Reset</a>
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
                            <th>Author</th>
                            <th>Jurusan</th>
                            <th>Title</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Pengaduan Create</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduans as $key => $pengaduan)
                            <tr>
                                <td>{{ $pengaduans->firstItem() + $key }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="theme-color-default-img img-fluid avatar avatar-40 avatar-rounded"
                                            src="{{ $pengaduan->Tiket->Mahasiswa->foto ? asset('storage/profile/' . $pengaduan->Tiket->Mahasiswa->foto) : asset('assets/images/avatars/01.png') }}"
                                            alt="foto-profile">
                                        <h6 class="ms-2">{{ $pengaduan->Tiket->Mahasiswa->name }}</h6>
                                    </div>
                                </td>
                                <td>{{ $pengaduan->Tiket->Mahasiswa->Jurusan->name }}</td>
                                <td>
                                    {{ \Str::limit($pengaduan->title, 10) }}
                                </td>
                                <td>
                                    @foreach ($pengaduan->Kategoris as $kategori)
                                        <span class="badge bg-success" style="font-size: 12px">
                                            {{ $kategori->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <div
                                        class="{{ $pengaduan->status == 'failed' ? 'text-danger' : ($pengaduan->status == 'process' ? 'text-warning' : ($pengaduan->status == 'success' ? 'text-info' : 'text-secondary')) }}">
                                        {{ $pengaduan->status }}</div>
                                </td>
                                <td>
                                    {{ $pengaduan->tanggal_pengaduan }}
                                </td>
                                <td>
                                    {{ $pengaduan->created_at }}
                                </td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-info btn-sm"><i
                                            class="fa-solid fa-eye fa-fw"></i>
                                        Detail Pengaduan</a>
                                    @if ($pengaduan->status == 'pending')
                                        <form method="POST" x-data="deleteData" @submit.prevent="deleteModel"
                                            data-model="{{ $pengaduan->title }}"
                                            action="{{ route('mahasiswa.pengaduanSaya.destroy', $pengaduan) }}"
                                            class="d-inline">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Pengaduan Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $pengaduans->links() }}
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
