<div class="card-body">
    <form action="{{ route('master.mahasiswa.exportable') }}" method="GET">
        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select class="form-select" name="jurusan" id="jurusan" wire:model="selectedJurusan"
                wire:change="updateAngkatan">
                <option selected disabled>Pilih Jurusan</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                @endforeach
            </select>
        </div>
        @if ($angkatans)
            <div class="mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <select class="form-select" name="angkatan" id="angkatan">
                    <option selected disabled>Pilih Angkatan</option>
                    @foreach ($angkatans as $angkatan)
                        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div wire:loading.inline>
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
        </div>
        <button type="submit" class="btn btn-primary" wire:loading.class="d-none"><i
                class="fa-solid fa-circle-plus fa-fw"></i>
            Export</button>
        <a href="{{ route('master.mahasiswa.index') }}" class="btn btn-secondary"><i
                class="fa-solid fa-arrow-left fa-fw"></i>
            Kembali</a>
    </form>

</div>
