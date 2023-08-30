@if ($success)
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Buat Pengaduan anda</h4>
            </div>
        </div>
        <div class="card-body">
            <div id="pengaduanError"></div>
            <form method="POST" onsubmit="storePengaduan(event)" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="token">Tiket</label>
                    <input type="text" class="form-control" id="token" readonly name="token"
                        value="{{ $tiket->token }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="kategoris">Kategori</label>
                    <select class="kategori-select-multiple form-select" name="kategoris[]" id="kategoris"
                        multiple="multiple">
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control " id="title" name="title">
                </div>
                <div class="form-group">
                    <label class="form-label" for="deskripsi">deskripsi</label>
                    <textarea class="form-control " name="deskripsi" id="summernote"></textarea>
                </div>
                <div class="form-group">
                    <label for="fotos" class="form-label">Foto (Bisa lebih dari 1)</label>
                    <input class="form-control" type="file" id="fotos" name="fotos[]" multiple>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                        Tambah</button>
                    <a href="{{ route('mahasiswa.pengaduanSaya.index') }}" class="btn btn-secondary"><i
                            class="fa-solid fa-arrow-left fa-fw"></i>
                        Kembali</a>
                    <div id="pengaduanLoading">
                    </div>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Buat Pengaduan anda</h4>
            </div>
        </div>
        <div class="card-body">
            <h5 class="text-center">Buat Tiket anda terlebih dahulu</h5>
        </div>
    </div>
@endif
