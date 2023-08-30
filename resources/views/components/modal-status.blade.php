@props(['pengaduan'])
@php
    $statuses = ['failed', 'process', 'success'];
@endphp

<div class="modal fade" id="ubahStatusModal" tabindex="-1" aria-labelledby="ubahStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahStatusModalLabel">Edit Status Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option disabled>Pilih Status Pengaduan</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($pengaduan->status === $status)>{{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="fotoSuccess">

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
