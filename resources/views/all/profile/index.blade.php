<x-main-layout title="E-Complaint - Profile">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">New User Information</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="profile-img-edit position-relative">
                    <img src="{{ Auth::user()->foto ? asset('storage/profile/' . Auth::user()->foto) : asset('assets/images/avatars/01.png') }}"
                        alt="profile-pic" class="theme-color-default-img profile-pic rounded avatar-100" id="preview-img">
                </div>
            </div>
            <div class="new-user-info">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" id="name" placeholder="Name"
                                value="{{ old('name', $userLogin->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Password" value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" id="email" placeholder="Email" @readonly(\Auth::guard('web')->check())
                                value="{{ $userLogin->email }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @auth('web')
                            <div class="form-group col-md-6">
                                <label class="form-label" for="role">Role</label>
                                <input type="text" class="form-control" name="role" id="role" placeholder="Role"
                                    readonly value="{{ $userLogin->Role->name }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin"
                                    placeholder="Jenis Kelamin" readonly value="{{ $userLogin->jenis_kelamin }}">
                            </div>
                        @endauth
                        @auth('mahasiswa')
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nim">NIM</label>
                                <input type="number" class="form-control" name="nim" id="nim" placeholder="Nim"
                                    readonly value="{{ $userLogin->nim }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="jurusan">Jurusan</label>
                                <input type="text" class="form-control" name="jurusan" id="jurusan"
                                    placeholder="Jurusan" readonly value="{{ $userLogin->Jurusan->name }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="angkatan">Angkatan</label>
                                <input type="text" class="form-control" name="angkatan" id="angkatan"
                                    placeholder="Angkatan" readonly value="{{ $userLogin->angkatan }}">
                            </div>
                        @endauth
                        <div class="form-group col-md-6">
                            <label class="form-label" for="foto">Foto</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                name="foto" id="foto" placeholder="Foto">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-pen-to-square fa-fw"></i>
                        Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    @push('my-js')
        <script>
            const foto = document.getElementById('foto');
            const previewImg = document.getElementById('preview-img');

            foto.addEventListener('change', (e) => {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = (e) => {
                    const fotoData = e.target.result;

                    previewImg.src = fotoData;
                }

                reader.readAsDataURL(file)
            });
        </script>
    @endpush
</x-main-layout>
