<x-main-layout title="E-Complaint User-Edit Role">
    <div class="card m-auto col-10">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Edit User Role</h4>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('master.user.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="role_id">Role</label>
                    <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                        <option selected disabled>Pilih Role</option>
                        @foreach ($roles as $role)
                            <option @selected($user->role_id === $role->id) value="{{ $role->id }}">
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Edit</button>
                <a href="{{ route('master.user.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>

            </form>
        </div>
    </div>
</x-main-layout>
