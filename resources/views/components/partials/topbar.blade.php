@props(['pengaduanNotification'])

<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">
        <a href="../dashboard/index.html" class="navbar-brand">
            {{-- Title Mobile --}}
            <h4 class="logo-title">E- Complaint</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" height="20px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>
        <div class="input-group search-input">
            <span class="input-group-text" id="search-input">
                <svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></circle>
                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
            <input type="search" class="form-control" placeholder="Search...">
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="mt-2 navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                @auth('web')
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="notification-drop" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-bell fa-fw" style="font-size: 1.3rem;"></i>
                            <span class="dots">{{ $pengaduanNotification->count() }}</span>
                        </a>
                        <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="notification-drop">
                            <div class="m-0 shadow-none card">
                                <div class="py-3 card-header d-flex justify-content-between bg-primary">
                                    <div class="header-title">
                                        <h5 class="mb-0 text-white">All Notifications</h5>
                                    </div>
                                </div>
                                @forelse ($pengaduanNotification as $notification)
                                    <div class="p-0 card-body">
                                        <a href="#" class="iq-sub-card pengaduanNotification"
                                            data-notif="{{ $notification->id }}">
                                            <div class="d-flex align-items-center">
                                                <img class="theme-color-default-img img-fluid avatar avatar-40 avatar-rounded"
                                                    src="{{ $notification->Mahasiswa->foto ? asset('storage/profile/' . $notification->Mahasiswa->foto) : asset('assets/images/avatars/01.png') }}"
                                                    alt="foto-profile">
                                                <div class="ms-3 w-100">
                                                    <h6 class="mb-0 ">
                                                        {{ \Str::limit($notification->Pengaduan->title, 10) }}</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">{{ $notification->Mahasiswa->name }}</p>
                                                        <small
                                                            class="float-end font-size-12">{{ $notification->Pengaduan->created_at }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="p-0 card-body">
                                        <a href="#" class="iq-sub-card">
                                            Pengaduan Notifikasi tidak ada
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->foto ? asset('storage/profile/' . Auth::user()->foto) : asset('assets/images/avatars/01.png') }}"
                            alt="User-Profile"
                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                        <div class="caption ms-3 d-none d-md-block ">
                            <h6 class="mb-0 caption-title">{{ \Auth::user()->name }}</h6>
                            <p class="mb-0 caption-sub-title">
                                {{ \Auth::guard('mahasiswa')->check() ? 'Mahasiswa' : \Auth::user()->Role->name }}
                            </p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fa-solid fa-user fa-fw"></i> Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form
                                action="{{ \Auth::guard('mahasiswa')->check() ? route('logout.mahasiswa') : route('logout') }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i
                                        class="fa-solid fa-arrow-right-from-bracket fa-fw"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@auth('web')
    @push('my-js')
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script>
            // Get response pengauan notification
            const getResponsePengaduanNotification = async (id) => {
                return await axios.put(`https://e-complaint.dev/master/pengaduan-notification/${id}`, {}, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
            }

            const pengaduanNotification = document.querySelectorAll('.pengaduanNotification');
            pengaduanNotification.forEach((notification, key) => {
                notification.addEventListener('click', async (e) => {
                    try {
                        const {
                            data
                        } = await getResponsePengaduanNotification(notification.dataset
                            .notif);

                        window.location =
                            `https://e-complaint.dev/pengaduan/${data.slug}`
                    } catch (error) {
                        console.log(error);
                    }
                });
            });
        </script>
    @endpush
@endauth
