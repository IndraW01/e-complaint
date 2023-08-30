<x-main-layout title="E-Complaint - User">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h4 class="card-title">User</h4>
            </div>
            <div class="header-action">
                <div class="text-end mb-2">
                    <a href="{{ route('master.user.create') }}" class="btn btn-sm btn-primary"><i
                            class="fa-solid fa-circle-plus fa-fw"></i> Tambah User</a>
                </div>
                <form method="GET">
                    <div class="d-flex gap-2">
                        <input class="form-control form-control-sm" type="text" placeholder="Cari User"
                            name="searchUser" value="{{ request()->searchUser }}">
                        <select class="form-select form-select-sm" name="searchRole">
                            <option disabled selected>Filter Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected($role == request()->searchRole)>
                                    {{ \Str::title($role) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary d-inline"> Search</button>
                        <a href="{{ route('master.user.index') }}" class="btn btn-sm btn-outline-warning">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $key => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jenis_kelamin }}</td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 12px">
                                        {{ $user->Role->name }}
                                    </span>
                                </td>
                                <td>
                                    <img class="theme-color-default-img img-fluid avatar avatar-45 avatar-rounded"
                                        src="{{ $user->foto ? asset('storage/profile/' . $user->foto) : asset('assets/images/avatars/01.png') }}"
                                        alt="foto-profile">
                                </td>
                                <td>
                                    <a href="{{ route('master.user.edit', $user) }}" class="btn btn-warning btn-sm"><i
                                            class="fa-solid fa-pen-to-square fa-fw"></i>
                                        Edit Role</a>
                                    <form method="POST" x-data="deleteData" @submit.prevent="deleteModel"
                                        data-model="{{ $user->name }}"
                                        action="{{ route('master.user.destroy', $user) }}" class="d-inline">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash-can fa-fw"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">User Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $users->links() }}
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
