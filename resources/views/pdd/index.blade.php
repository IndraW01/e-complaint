<x-main-layout title="E-Complaint - Mahasiswa">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h4 class="card-title">Mahasiswa</h4>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Foto</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswas as $key => $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswas->firstItem() + $key }}</td>
                                <td>{{ $mahasiswa->name }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>
                                    <img class="theme-color-default-img img-fluid avatar avatar-45 avatar-rounded"
                                        src="{{ $mahasiswa->foto ? asset('storage/profile/' . $mahasiswa->foto) : asset('assets/images/avatars/01.png') }}"
                                        alt="foto-profile">
                                </td>
                                <td>
                                    <span class="badge bg-success" style="font-size: 12px">
                                        {{ $mahasiswa->Jurusan->name }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Mahasiswa Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-2">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>

</x-main-layout>
