@props(['pengaduan'])
@php
    $ratings = [1, 2, 3, 4, 5];
@endphp

<div class="modal fade" id="tambahRatingModal" tabindex="-1" aria-labelledby="tambahRatingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('mahasiswa.pengaduanSaya.update', $pengaduan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRatingModalLabel">Tambah Rating Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-select" name="rating" id="rating">
                            <option disabled>Pilih Rating Pengaduan</option>
                            @foreach ($ratings as $rating)
                                <option value="{{ $rating }}">{{ $rating }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
