<x-main-layout title="E-Complaint - Kategori">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Kategori</h4>
            </div>
            <div class="header-action">
                <a href="{{ route('master.kategori.create') }}" class="btn btn-sm btn-primary"><i
                        class="fa-solid fa-circle-plus fa-fw"></i> Tambah Kategori</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $key => $kategori)
                            <tr>
                                <td>{{ $kategoris->firstItem() + $key }}</td>
                                <td>{{ $kategori->name }}</td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 12px">
                                        {{ $kategori->slug }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('master.kategori.edit', $kategori) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i>
                                        Edit</a>
                                    <form method="POST" x-data="deleteData" @submit.prevent="deleteModel"
                                        data-model="{{ $kategori->name }}"
                                        action="{{ route('master.kategori.destroy', $kategori) }}" class="d-inline">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Kategori Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>

    @push('my-js')
        <script>
            const deleteData = () => {
                return {
                    deleteModel(e) {
                        Swal.fire({
                            title: `Apa kamu yakin ?`,
                            text: `Anda tidak akan dapat mengembalikan data ${e.target.dataset.model}!`,
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus itu!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                e.target.submit();
                            }
                        })
                    },
                }
            };
        </script>
    @endpush
</x-main-layout>
