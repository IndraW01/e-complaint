<aside class="sidebar sidebar-default navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="#" class="navbar-brand">
            <!--Logo start-->
            {{-- <x-main-logo /> --}}
            <img src="{{ asset('assets/images/unmul.png') }}" alt="" width="30" height="30">
            <!--logo End-->
            <h4 class="logo-title">E-Complaint</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                @auth('web')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-house fa-fw"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    @if (\Auth::guard('web')->user()->Role->name == 'Superadmin' || \Auth::guard('web')->user()->Role->name == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chartPengaduan') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('chartPengaduan') }}">
                                <i class="fa-solid fa-chart-line fa-fw"></i>
                                <span class="item-name">Chart Pengaduan</span>
                            </a>
                        </li>
                    @endif
                @endauth

                @auth('web')
                    @if (\Auth::guard('web')->user()->Role->name == 'Superadmin' || \Auth::guard('web')->user()->Role->name == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('master.*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#master-menu" role="button" aria-expanded="false"
                                aria-controls="master-menu">
                                <i class="fa-solid fa-chart-simple fa-fw"></i>
                                <span class="item-name">Master</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="master-menu" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('master.kategori.*') ? 'active' : '' }}"
                                        href="{{ route('master.kategori.index') }}">
                                        <i class="fa-solid fa-list-ul fa-fw"></i>
                                        <i class="sidenav-mini-icon"> K </i>
                                        <span class="item-name"> Kategori </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('master.mahasiswa.*') ? 'active' : '' }}"
                                        href="{{ route('master.mahasiswa.index') }}">
                                        <i class="fa-solid fa-graduation-cap fa-fw"></i>
                                        <i class="sidenav-mini-icon"> M </i>
                                        <span class="item-name"> Mahasiswa </span>
                                    </a>
                                </li>
                                @if (\Auth::guard('web')->user()->Role->name == 'Superadmin')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('master.user.*') ? 'active' : '' }}"
                                            href="{{ route('master.user.index') }}">
                                            <i class="fa-solid fa-users fa-fw"></i>
                                            <i class="sidenav-mini-icon"> U </i>
                                            <span class="item-name"> User </span>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('master.jurusan.*') ? 'active' : '' }}"
                                        href="{{ route('master.jurusan.index') }}">
                                        <i class="fa-solid fa-school-flag fa-fw"></i>
                                        <i class="sidenav-mini-icon"> J </i>
                                        <span class="item-name"> Jurusan </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('master.role.*') ? 'active' : '' }}"
                                        href="{{ route('master.role.index') }}">
                                        <i class="fa-solid fa-users-gear fa-fw"></i>
                                        <i class="sidenav-mini-icon"> R </i>
                                        <span class="item-name"> Role </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}"
                        data-bs-toggle="collapse" href="#pengaduan-menu" role="button" aria-expanded="false"
                        aria-controls="pengaduan-menu">
                        <i class="fa-solid fa-folder-open fa-fw"></i>
                        <span class="item-name">Pengaduan</span>
                        <i class="right-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse" id="pengaduan-menu" data-bs-parent="#sidebar-menu">
                        @auth('mahasiswa')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mahasiswa.pengaduanSaya.*') ? 'active' : (request()->routeIs('pengaduan.show') ? 'active' : '') }}"
                                    href="{{ route('mahasiswa.pengaduanSaya.index') }}">
                                    <i class="fa-solid fa-message fa-fw"></i>
                                    <i class="sidenav-mini-icon"> PS </i>
                                    <span class="item-name"> Pengaduan Saya </span>
                                </a>
                            </li>
                        @endauth
                        @auth('web')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}"
                                    href="{{ route('pengaduan.index') }}">
                                    <i class="fa-solid fa-inbox fa-fw"></i>
                                    <i class="sidenav-mini-icon"> SM </i>
                                    <span class="item-name"> Semua Pengaduan </span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </li>
                <li>
                    <hr class="hr-horizontal">
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('profile.index') }}">
                        <i class="fa-solid fa-user fa-fw"></i>
                        <span class="item-name">Profile</span>
                    </a>
                </li>
            </ul>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
