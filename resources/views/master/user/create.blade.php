<x-main-layout title="E-Complaint User-Tambah">
    <div class="card m-auto col-10">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Tambah User</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('master.user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
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
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label" for="role_id">Role</label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role_id"
                                name="role_id">
                                <option selected disabled>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option @selected(old('role_id') === $role->id) value="{{ $role->id }}">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div>
                            <label class="form-label">Jenis Kelamin</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                                name="jenis_kelamin" id="laki" value="laki" @checked(old('jenis_kelamin') == 'laki')>
                            <label class="form-check-label" for="laki">Laki-Laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                                name="jenis_kelamin" id="perempuan" value="perempuan" @checked(old('jenis_kelamin') == 'perempuan')>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                        @error('jenis_kelamin')
                            <div class="small text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Tambah</button>
                <a href="{{ route('master.user.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>

            </form>
        </div>
    </div>
</x-main-layout>
