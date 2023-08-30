<x-main-layout title="E-Complaint Mahasiswa-Export">
    <div class="card m-auto col-10">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Export Pengaduan</h4>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pengaduan.exportable') }}" method="GET">
                <div class="mb-3">
                    <label for="searchJurusan" class="form-label">Jurusan</label>
                    <select class="form-select @error('searchJurusan') is-invalid @enderror" name="searchJurusan"
                        id="searchJurusan">
                        <option selected disabled>Pilih Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->name }}">{{ $jurusan->name }}</option>
                        @endforeach
                    </select>
                    @error('searchJurusan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if (Auth::guard('mahasiswa')->check() ||
                        Auth::guard('web')->user()->Role->name == 'Admin' ||
                        Auth::guard('web')->user()->Role->name == 'Superadmin')
                    <div class="mb-3">
                        <label for="searchKategori" class="form-label">Kategori</label>
                        <select class="form-select @error('searchKategori') is-invalid @enderror" name="searchKategori"
                            id="searchKategori">
                            <option selected disabled>Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori }}">{{ $kategori }}</option>
                            @endforeach
                        </select>
                        @error('searchKategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
                <div class="mb-3">
                    <label for="searchStatus" class="form-label">Status</label>
                    <select class="form-select @error('searchStatus') is-invalid @enderror" name="searchStatus"
                        id="searchStatus">
                        <option selected disabled>Pilih status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('searchStatus')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" wire:loading.class="d-none"><i
                        class="fa-solid fa-circle-plus fa-fw"></i>
                    Export</button>
                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>
        </div>
        </form>
    </div>
    </div>
</x-main-layout>
