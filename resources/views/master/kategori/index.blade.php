<x-main-layout>
    @push('my-css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.bootstrap5.min.css">

        <style>
            #kategoriDatatable {
                margin: 25px 0 !important;
            }

            #loadingAdd {
                display: none;
            }
        </style>
    @endpush
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Kategori</h4>
            </div>
            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i
                    class="fa-solid fa-circle-plus fa-fw"></i> Tambah Kategori</a>
        </div>
        <div class="card-body">
            <table id="kategoriDatatable" class="table table-striped">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>No</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <x-modal-create title="Tambah Kategori">
        <form id="formAddKategori">
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
                <label class="form-label" for="slug">Slug</label>
                <input type="name" class="form-control" name="slug" id="slug" readonly>
            </div>
        </form>
    </x-modal-create>

    @push('my-js')
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>

        <script>
            // SweetAlert
            const sweetAlert = (icon = 'success', title = '', text = '') => {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text
                })
            };

            // String Invalid Feedback
            const stringError = (message) => {
                return `<div class="invalid-feedback">
                            ${message}
                        </div>`
            }

            // Datatable
            $(function() {
                const table = $('#kategoriDatatable').DataTable({
                    processing: false,
                    serverSide: true,
                    pageLength: 10,
                    lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                    ajax: "{{ route('master.kategori.datatable') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'slug',
                            name: 'slug'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });
            });

            // Generate Slug
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('change', async () => {
                try {
                    const {
                        data: {
                            slug
                        }
                    } = await axios.post("{{ route('master.kategori.slug') }}", {
                        name: nameInput.value
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    })

                    slugInput.value = slug;
                } catch (error) {
                    sweetAlert('error', 'Gagal generate slug', error);
                }
            });

            // Tambah Kategori
            const formAddKategori = document.getElementById('formAddKategori');
            const saveModal = document.getElementById('saveModal');
            const closeModal = document.getElementById('closeModal');

            saveModal.addEventListener('click', async (event) => {
                event.preventDefault();

                document.getElementById('loadingAdd').style.display = "inline";

                try {
                    const {
                        data: {
                            message
                        }
                    } = await axios({
                        method: 'POST',
                        url: "{{ route('master.kategori.store') }}",
                        data: new FormData(formAddKategori)
                    });

                    closeModal.click();

                    sweetAlert('success', 'Berhasil menambah kategori', 'Kategori berhasil ditambahkan!');

                    formAddKategori.reset();

                    document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
                    nameInput.classList.remove('is-invalid');
                    slugInput.classList.remove('is-invalid');

                    $(function() {
                        $('#kategoriDatatable').DataTable().ajax.reload();
                    });

                    document.getElementById('loadingAdd').style.display = "none";

                } catch ({
                    response: {
                        data: {
                            errors
                        }
                    }
                }) {
                    if (errors.name && errors.slug) {
                        if (nameInput.classList.contains('is-invalid') && slugInput.classList.contains(
                                'is-invalid')) {
                            document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
                            nameInput.classList.remove('is-invalid');
                            nameInput.classList.add('is-invalid');
                            nameInput.insertAdjacentHTML('afterend', stringError(errors.name))
                            slugInput.classList.remove('is-invalid');
                            slugInput.classList.add('is-invalid');
                            slugInput.insertAdjacentHTML('afterend', stringError(errors.slug))
                        } else {
                            nameInput.classList.add('is-invalid');
                            nameInput.insertAdjacentHTML('afterend', stringError(errors.name))
                            slugInput.classList.add('is-invalid');
                            slugInput.insertAdjacentHTML('afterend', stringError(errors.slug))
                        }
                    } else if (errors.name) {
                        if (nameInput.classList.contains('is-invalid')) {
                            nameInput.classList.remove('is-invalid');
                            document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
                            nameInput.classList.add('is-invalid');
                            nameInput.insertAdjacentHTML('afterend', stringError(errors.name))
                        } else {
                            nameInput.classList.add('is-invalid');
                            nameInput.insertAdjacentHTML('afterend', stringError(errors.name))
                        }
                    } else if (errors.slug) {
                        if (slugInput.classList.contains('is-invalid')) {
                            slugInput.classList.remove('is-invalid');
                            document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
                            slugInput.classList.add('is-invalid');
                            slugInput.insertAdjacentHTML('afterend', stringError(errors.slug))
                        } else {
                            slugInput.classList.add('is-invalid');
                            slugInput.insertAdjacentHTML('afterend', stringError(errors.slug))
                        }
                    }

                    document.getElementById('loadingAdd').style.display = "none";
                }

            });
        </script>
    @endpush
</x-main-layout>
