<div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    wire:change="sluglable" wire:model.lazy="name">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="form-label" for="slug">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                    name="slug" readonly wire:model.lazy="slug">
                @error('slug')
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
                <label class="form-label" for="kaprodi">Kaprodi</label>
                <input type="text" class="form-control @error('kaprodi') is-invalid @enderror" id="kaprodi"
                    name="kaprodi" value="{{ old('kaprodi', $jurusan?->kaprodi) }}">
                @error('kaprodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
