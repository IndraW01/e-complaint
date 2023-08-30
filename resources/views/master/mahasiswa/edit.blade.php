<x-main-layout title="E-Complaint Mahasiswa-Edit">
    <div class="card m-auto col-10">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Edit Mahasiswa</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('master.mahasiswa.update', $mahasiswa) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $mahasiswa->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="nim">Nim</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                name="nim" value="{{ old('nim', $mahasiswa->nim) }}">
                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="jurusan_id">Jurusan</label>
                            <select class="form-select @error('jurusan_id') is-invalid @enderror" id="jurusan_id"
                                name="jurusan_id">
                                <option selected disabled>Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option @selected(old('jurusan_id', $mahasiswa->jurusan_id) === $jurusan->id) value="{{ $jurusan->id }}">
                                        {{ $jurusan->name }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="angkatan">Angkatan</label>
                            <select class="form-select @error('angkatan') is-invalid @enderror" id="angkatan"
                                name="angkatan">
                                <option selected disabled>Pilih Angkatan</option>
                                @foreach ($angkatans as $angkatan)
                                    <option @selected(old('angkatan', $mahasiswa->angkatan) == $angkatan) value="{{ $angkatan }}">
                                        {{ $angkatan }}</option>
                                @endforeach
                            </select>
                            @error('angkatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Ubah</button>
                <a href="{{ route('master.mahasiswa.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>
            </form>
        </div>
    </div>
</x-main-layout>
