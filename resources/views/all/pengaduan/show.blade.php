<x-main-layout title="E-Complaint Detail Pengaduan">
    <div class="card mx-auto col-12 col-md-8">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title text-center">{{ $pengaduan->title }}</h4>
                <div class="text-center">
                    @foreach ($pengaduan->Kategoris as $kategori)
                        <span class="badge bg-primary d-inline-block py-1">{{ $kategori->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between pb-4">
                <div class="header-title">
                    <div class="d-flex flex-wrap">
                        @if (\Auth::guard('mahasiswa')->id() == $pengaduan->Tiket->Mahasiswa->id || \Auth::guard('web')->check())
                            <div class="media-support-user-img me-3">
                                <img src="{{ $pengaduan->Tiket->Mahasiswa->foto ? asset('storage/profile/' . $pengaduan->Tiket->Mahasiswa->foto) : asset('assets/images/avatars/01.png') }}"
                                    alt="User-Profile" class="rounded-pill img-fluid avatar-60">
                            </div>
                            <div class="media-support-info mt-2">
                                <h5 class="mb-0">{{ $pengaduan->Tiket->Mahasiswa->name }}</h5>
                                <p class="mb-0 text-primary">{{ $pengaduan->Tiket->Mahasiswa->Jurusan->name }}</p>
                            </div>
                        @else
                            <div class="media-support-user-img me-3">
                                <img class="rounded-pill img-fluid avatar-60 bg-soft-danger p-1 ps-2"
                                    src="{{ asset('assets/images/avatars/01.png') }}" alt="">
                            </div>
                            <div class="media-support-info mt-2">
                                <h5 class="mb-0">{{ \Str::mask($pengaduan->Tiket->Mahasiswa->nim, '*', 5) }}</h5>
                                <p class="mb-0 text-primary">{{ $pengaduan->Tiket->Mahasiswa->Jurusan->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-end">
                        {{ $pengaduan->created_at }}
                    </div>
                    <div>
                        {{ $pengaduan->Tiket->token }}
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="user-post">
                    <a href="#"><img
                            src="{{ $pengaduan->FotoPengaduans->count() > 0 ? asset('storage/pengaduan/' . $pengaduan->FotoPengaduans[0]->name) : asset('assets/images/place-holder.jpg') }}"
                            alt="post-image" class="img-fluid" width="100%"></a>
                </div>
                <div class="comment-area p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if ($pengaduan->status === 'success' && !is_null($pengaduan->rating))
                                <div class="d-flex align-items-center message-icon me-3">
                                    @if ($pengaduan->rating == 5)
                                        @for ($i = 0; $i < $pengaduan->rating; $i++)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @endfor
                                    @else
                                        @php
                                            $noRating = 5 - $pengaduan->rating;
                                        @endphp
                                        @for ($i = 0; $i < $pengaduan->rating; $i++)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @endfor
                                        @for ($i = 0; $i < $noRating; $i++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor
                                    @endif
                                    <span class="ms-1">{{ $pengaduan->rating }}</span>
                                </div>
                            @elseif ($pengaduan->status === 'success' && is_null($pengaduan->rating))
                                @auth('mahasiswa')
                                    @can('updateRating', $pengaduan)
                                        <div class="me-3">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#tambahRatingModal">
                                                <i class="fa-solid fa-star fa-fw"></i> Tambah Rating
                                            </button>
                                        </div>
                                    @else
                                        <div class="me-3">
                                            Mahasiswa Belum memberi rating
                                        </div>
                                    @endcan
                                @endauth
                            @else
                                <div class="me-3">
                                    Belum ada rating
                                </div>
                            @endif
                            <div class="d-flex align-items-center feather-icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10Z" />
                                </svg>

                                @livewire('pengaduan-count', ['pengaduanId' => $pengaduan->id])
                            </div>
                        </div>
                        <div>
                            <button
                                class="btn btn-sm {{ $pengaduan->status == 'failed' ? 'btn-danger' : ($pengaduan->status == 'process' ? 'btn-warning' : ($pengaduan->status == 'success' ? 'btn-info' : 'btn-secondary')) }}"
                                disabled>{!! $pengaduan->status == 'failed'
                                    ? '<i class="fa-solid fa-circle-xmark fa-fw"></i>'
                                    : ($pengaduan->status == 'process'
                                        ? '<i class="fa-solid fa-spinner fa-fw"></i>'
                                        : ($pengaduan->status == 'success'
                                            ? '<i class="fa-solid fa-circle-check fa-fw"></i>'
                                            : '<i class="fa-solid fa-circle-info fa-fw"></i>')) !!}
                                {{ $pengaduan->status }}</button>
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#modalFotoPengaduan">
                                <i class="fa-solid fa-images fa-fw"></i> Foto Pengaduan
                            </button>
                            @if ($pengaduan->status == 'success')
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#modalFotoPengaduanSuccess">
                                    <i class="fa-solid fa-images fa-fw"></i> Foto Pengaduan Success
                                </button>
                            @endif
                            @auth('web')
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#ubahStatusModal">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i> Ubah Status
                                </button>
                            @endauth
                        </div>
                    </div>
                    <hr>
                    {!! $pengaduan->deskripsi !!}
                    <hr>

                    @livewire('comment-pengaduan', ['pengaduanId' => $pengaduan->id])

                    @can('update', $pengaduan)
                        @livewire('create-comment-pengaduan', ['pengaduanId' => $pengaduan->id])
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <x-modal-status :pengaduan="$pengaduan" />
    <x-modal-rating :pengaduan="$pengaduan" />
    <div class="modal fade" id="modalFotoPengaduan" tabindex="-1" aria-labelledby="modalFotoPengaduanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalFotoPengaduanLabel">Foto Pengaduan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($pengaduan->FotoPengaduans()->foto(false) as $foto)
                        <img src="{{ asset('storage/pengaduan/' . $foto->name) }}" alt="{{ $pengaduan->title }}"
                            class="w-75 mb-3 d-block text-center mx-auto">
                    @empty
                        <p class="text-center">Foto Tidak Ada</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFotoPengaduanSuccess" tabindex="-1"
        aria-labelledby="modalFotoPengaduanSuccessLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalFotoPengaduanSuccessLabel">Foto Pengaduan Success</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($pengaduan->FotoPengaduans()->foto(true) as $foto)
                        <img src="{{ asset('storage/pengaduan/admin/' . $foto->name) }}"
                            alt="{{ $pengaduan->title }}" class="w-75 mb-3 d-block text-center mx-auto">
                    @empty
                        <p class="text-center">Foto Tidak Ada</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('my-js')
        <script>
            window.Livewire.on('success', (message) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: message,
                })
            })

            window.Livewire.on('error', (message) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: message,
                })
            })

            const selectStatus = document.getElementById('status');
            const fotoSuccess = document.getElementById('fotoSuccess');


            const stringInputFoto = () => `<div class="mb-3">
                                                <label for="fotos" class="form-label">Foto (Bisa lebih dari 1)</label>
                                                <input class="form-control" type="file" id="fotos" name="fotos[]" multiple>
                                                </div>`;

            if (selectStatus.value == 'success') {
                fotoSuccess.innerHTML = stringInputFoto();
            }

            selectStatus.addEventListener('change', (e) => {
                if (e.target.value == 'success') {
                    fotoSuccess.innerHTML = stringInputFoto();
                } else {
                    fotoSuccess.innerHTML = '';
                }
            });
        </script>
    @endpush
</x-main-layout>
