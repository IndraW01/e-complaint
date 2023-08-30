<div>
    <form class="comment-text d-flex align-items-center mt-3" wire:submit.prevent="save">
        <input type="text" class="form-control rounded @error('pesan') is-invalid @enderror"
            placeholder="Komentar anda!" wire:model.lazy="pesan">
        <div class="comment-attagement d-flex">
            <button type="submit" class="border-0 btn">
                <i class="fa-solid fa-play"></i>
            </button>
        </div>
    </form>
    @error('pesan')
        <div class="text-danger">
            <span class="text-small">{{ $message }}</span>
        </div>
    @enderror
    <div class="text-primary" wire:loading>
        <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
        Loading...
    </div>
</div>
