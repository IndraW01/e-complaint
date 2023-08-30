<x-main-layout title="E-Complaint Pengaduan-Tambah">
    @if ($pengaduanNotSuccessCount == 0)
        @push('my-css')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
            <style>
                .select2-container--default .select2-selection--multiple .select2-selection__choice {
                    background-color: #7e94ff !important;
                    color: white !important;
                }

                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                    color: white !important;
                }

                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
                    color: #2d2d2d !important;
                }

                .note-insert>button:nth-child(2),
                .note-insert>button:nth-child(3) {
                    display: none !important;
                }
            </style>
        @endpush
        <div class="row justify-content-between">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Generate Tiket Pengaduan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tokenError"></div>
                        <form method="POST" id="formCreateToken">
                            <div class="form-group">
                                <label class="form-label" for="token">Token</label>
                                <input type="text" class="form-control " id="token" name="token"
                                    value="{{ $tiketNotPengaduanCount->count() > 0 ? $tiketNotPengaduanCount[0]->token : '' }}"
                                    readonly>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <a href="#" id="generateToken"
                                    class="btn btn-sm btn-success {{ $tiketNotPengaduanCount->count() > 0 ? 'd-none' : '' }}"><i
                                        class="fa-solid fa-layer-group fa-fw"></i>
                                    Generate Token</a>
                                <button type="submit" class="btn btn-sm btn-primary d-none" id="createToken"><i
                                        class="fa-solid fa-circle-plus fa-fw"></i>
                                    Create Token</button>
                                <a href="{{ route('mahasiswa.pengaduanSaya.index') }}"
                                    class="btn btn-sm btn-secondary"><i class="fa-solid fa-arrow-left fa-fw"></i>
                                    Kembali</a>
                                <div id="tokenLoading">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-7" id="createPengaduan">

            </div>
        </div>

        @push('my-js')
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
            <script>
                // Generate UUID
                const uuidv4 = () => {
                    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                    );
                }

                // Get response token
                const getResponseToken = async () => {
                    return await axios.post("https://e-complaint.dev/mahasiswa/pengaduan-saya/create/token", {
                        token: inputToken.value,
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                }

                const getResponseStorePengaduan = async (formData) => {
                    return await axios.post("https://e-complaint.dev/mahasiswa/pengaduan-saya", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                }

                // Get response html create pengaduan
                const getResponsePengaduan = async () => {
                    return await axios.get("https://e-complaint.dev/mahasiswa/pengaduan-saya/create/cek-pengaduan", )
                }

                // Tampil Error Token
                const errorToken = (message) => {
                    const htmlTokenError = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            ${message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`

                    // Hapus Content html sebelumnya
                    tokenError.innerHTML = '';

                    tokenError.innerHTML = htmlTokenError;
                }

                // Tampil Error Pengadun
                const errorPengaduan = (message) => {
                    let liPengaduan = '';
                    for (const key in message) {
                        liPengaduan += `<li>${message[key]}</li>`;
                    }

                    const htmlPengaduanError = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            ${liPengaduan}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`

                    // Hapus Content html sebelumnya
                    pengaduanError.innerHTML = '';

                    pengaduanError.innerHTML = htmlPengaduanError;
                }

                const generateToken = document.getElementById('generateToken');
                const inputToken = document.getElementById('token');
                const createToken = document.getElementById('createToken');
                const formCreateToken = document.getElementById('formCreateToken');
                const htmlCreatePengaduan = document.getElementById('createPengaduan');
                const tokenError = document.getElementById('tokenError');
                const tokenLoading = document.getElementById('tokenLoading');

                generateToken.addEventListener('click', (e) => {
                    e.preventDefault();

                    inputToken.value = uuidv4();
                    createToken.classList.remove('d-none');
                })

                formCreateToken.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    tokenLoading.innerHTML = `<div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>`;

                    try {
                        const {
                            data: responseToken
                        } = await getResponseToken();

                        // Hapus token loading
                        tokenLoading.innerHTML = '';
                        // Hapus error jika ada
                        tokenError.innerHTML = '';

                        // Hilangkan Tombol Generate Token dan Create Token
                        generateToken.classList.add('d-none');
                        createToken.classList.add('d-none');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: responseToken.success,
                        })

                        tampilCreatePengaduan()
                    } catch ({
                        response: {
                            data: {
                                errors: errorResponseToken
                            }
                        }
                    }) {
                        // Hapus token loading
                        tokenLoading.innerHTML = '';

                        errorToken(errorResponseToken.token)
                    }
                });

                const tampilCreatePengaduan = async () => {
                    const {
                        data: htmlPengaduan
                    } = await getResponsePengaduan();

                    // Hapus content html sebelumnya
                    htmlCreatePengaduan.innerHTML = '';

                    htmlCreatePengaduan.innerHTML = htmlPengaduan;

                    $('.kategori-select-multiple').select2({
                        placeholder: "Pilih Kategori anda",
                        allowClear: true,
                        maximumSelectionLength: 2
                    });

                    $('#summernote').summernote({
                        tabsize: 2,
                        height: 100
                    });
                };

                tampilCreatePengaduan();

                const storePengaduan = async (e) => {
                    e.preventDefault();

                    const formData = new FormData(e.target);
                    const pengaduanError = document.getElementById('pengaduanError');
                    const pengaduanLoading = document.getElementById('pengaduanLoading');

                    pengaduanLoading.innerHTML = `<div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>`;
                    try {
                        const {
                            data: responseStorePengaduanSaya
                        } = await getResponseStorePengaduan(formData)

                        // Hapus pengaduan loading
                        pengaduanLoading.innerHTML = '';
                        // Hapus error jika ada
                        pengaduanError.innerHTML = '';

                        Swal.fire({
                            title: 'Berhasil',
                            text: responseStorePengaduanSaya.success,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Oke'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })

                    } catch ({
                        response: {
                            data
                        }
                    }) {
                        // Hapus pengaduan loading
                        pengaduanLoading.innerHTML = '';

                        if (data.errors) {
                            errorPengaduan(data.errors);
                        } else {
                            // Hapus error jika ada
                            pengaduanError.innerHTML = '';

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.error,
                            })
                        }
                    }
                };
            </script>
        @endpush
    @else
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Buat Pengaduan anda</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5>Pengaduan Sebelumnya masih proses!</h5>
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-main-layout>
