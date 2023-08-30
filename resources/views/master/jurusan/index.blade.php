<x-main-layout title="E-Complaint - Jurusan">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Jurusan</h4>
            </div>
            <div class="header-action">
                <a href="{{ route('master.jurusan.create') }}" class="btn btn-sm btn-primary"><i
                        class="fa-solid fa-circle-plus fa-fw"></i> Tambah Jurusan</a>
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
                            <th>Kaprodi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurusans as $key => $jurusan)
                            <tr>
                                <td>{{ $jurusans->firstItem() + $key }}</td>
                                <td>{{ $jurusan->name }}</td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 12px">
                                        {{ $jurusan->slug }}
                                    </span>
                                </td>
                                <td>{{ $jurusan->kaprodi }}</td>
                                <td>
                                    <a href="{{ route('master.jurusan.edit', $jurusan) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square fa-fw"></i>
                                        Edit</a>
                                    <form method="POST" x-data="deleteData" @submit.prevent="deleteModel"
                                        data-model="{{ $jurusan->name }}"
                                        action="{{ route('master.jurusan.destroy', $jurusan) }}" class="d-inline">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Jurusan Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $jurusans->links() }}
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
