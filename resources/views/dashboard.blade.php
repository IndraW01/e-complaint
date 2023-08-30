<x-main-layout title="E-Complaint | Dashboard">
    <div class="card">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title text-center">Dashboard Pengaduan</h4>
            </div>
        </div>
        @if ($pengaduan->count() > 0)
            <div class="card-body">
                @if (Auth::guard('web')->user()->Role->name == 'Admin' || Auth::guard('web')->user()->Role->name == 'Superadmin')
                    @foreach ($kategoris as $kategori)
                        <div class="row">
                            <h5 class="mb-3">Pengaduan {{ $kategori->RoleKategori->Role->name }}</h5>
                            @foreach ($pengaduan[$kategori->slug] as $key => $pCount)
                                <div class="col-lg-3 col-md-6">
                                    <div
                                        class="card bg-soft-{{ $key == 'pending' ? 'secondary' : ($key == 'process' ? 'warning' : ($key == 'success' ? 'success' : 'danger')) }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div
                                                    class="bg-soft-{{ $key == 'pending' ? 'secondary' : ($key == 'process' ? 'warning' : ($key == 'success' ? 'success' : 'danger')) }} rounded p-3">

                                                    {!! $key == 'pending'
                                                        ? '<i style="font-size: 1.6rem" class="fa-solid fa-circle-info fa-fw"></i>'
                                                        : ($key == 'process'
                                                            ? '<i style="font-size: 1.6rem" class="fa-solid fa-spinner fa-fw"></i>'
                                                            : ($key == 'success'
                                                                ? '<i style="font-size: 1.6rem" class="fa-solid fa-circle-check fa-fw"></i>'
                                                                : '<i style="font-size: 1.6rem" class="fa-solid fa-circle-xmark fa-fw"></i>')) !!}
                                                </div>
                                                <div class="text-end">
                                                    <h2 class="counter">{{ $pCount }}</h2>
                                                    {{ \Str::upper($key) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <h5 class="mb-3">Pengaduan {{ Auth::guard('web')->user()->Role->name }}</h5>
                        @foreach ($pengaduan as $key => $pCount)
                            <div class="col-lg-3 col-md-6">
                                <div
                                    class="card bg-soft-{{ $key == 'pending' ? 'secondary' : ($key == 'process' ? 'warning' : ($key == 'success' ? 'success' : 'danger')) }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div
                                                class="bg-soft-{{ $key == 'pending' ? 'secondary' : ($key == 'process' ? 'warning' : ($key == 'success' ? 'success' : 'danger')) }} rounded p-3">

                                                {!! $key == 'pending'
                                                    ? '<i style="font-size: 1.6rem" class="fa-solid fa-circle-info fa-fw"></i>'
                                                    : ($key == 'process'
                                                        ? '<i style="font-size: 1.6rem" class="fa-solid fa-spinner fa-fw"></i>'
                                                        : ($key == 'success'
                                                            ? '<i style="font-size: 1.6rem" class="fa-solid fa-circle-check fa-fw"></i>'
                                                            : '<i style="font-size: 1.6rem" class="fa-solid fa-circle-xmark fa-fw"></i>')) !!}
                                            </div>
                                            <div class="text-end">
                                                <h2 class="counter">{{ $pCount }}</h2>
                                                {{ \Str::upper($key) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="card-body">
                <h5 class="text-center">Pengaduan Kosong</h5>
            </div>
        @endif
    </div>

</x-main-layout>
