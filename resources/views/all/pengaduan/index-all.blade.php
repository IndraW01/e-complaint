<x-main-layout title="E-Complaint - Pengaduan Masuk All">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h4 class="card-title">Pengaduan All</h4>
            </div>
            <div class="header-action">
                @can('exportPengaduan', App\Models\Pengaduan::class)
                    <div class="text-end mb-2">
                        <a href="{{ route('pengaduan.export') }}" class="btn btn-sm btn-warning"><i
                                class="fa-sharp fa-solid fa-file-export fa-fw"></i> Export Pengaduan</a>
                    </div>
                @endcan
                <form method="GET">
                    <div class="d-flex gap-2">
                        @auth('web')
                            <input class="form-control form-control-sm" type="text" placeholder="Cari Mahasiswa"
                                name="searchMahasiswa" value="{{ request()->searchMahasiswa }}">
                        @endauth
                        <select class="form-select form-select-sm" name="searchJurusan">
                            <option disabled selected>Filter Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan }}" @selected($jurusan == request()->searchJurusan)>
                                    {{ \Str::title($jurusan) }}</option>
                            @endforeach
                        </select>
                        @if (Auth::guard('mahasiswa')->check() ||
                                Auth::guard('web')->user()->Role->name == 'Admin' ||
                                Auth::guard('web')->user()->Role->name == 'Superadmin')
                            <select class="form-select form-select-sm" name="searchKategori">
                                <option disabled selected>Filter Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori }}" @selected($kategori == request()->searchKategori)>
                                        {{ \Str::title($kategori) }}</option>
                                @endforeach
                            </select>
                        @endif
                        <select class="form-select form-select-sm" name="searchStatus">
                            <option disabled selected>Filter Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($status == request()->searchStatus)>
                                    {{ \Str::title($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary d-inline"> Search</button>
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-warning">Reset</a>
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
                                        @auth('web')
                                            <h6 class="ms-2">{{ $pengaduan->Tiket->Mahasiswa->name }}</h6>
                                        @else
                                            <h6>{{ \Str::mask($pengaduan->Tiket->Mahasiswa->nim, '*', 5) }}</h6>
                                        @endauth
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
</x-main-layout>
