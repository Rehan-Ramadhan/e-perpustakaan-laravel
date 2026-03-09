<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/favicon.png') }}" alt="Logo" width="25">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">e-perpus</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is('home*') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Halaman Utama</div>
            </a>
        </li>

        @if(auth()->user()->role == 'admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kelola Data</span>
            </li>

            <li class="menu-item {{ request()->is('buku*') ? 'active' : '' }}">
                <a href="{{ route('buku.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Tables">Data Buku</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('pengguna*') ? 'active' : '' }}">
                <a href="{{ route('pengguna.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tables">Data Pengguna</div>
                </a>
            </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Layanan</span>
        </li>

        <li class="menu-item {{ request()->is('peminjaman*') ? 'active' : '' }}">
            <a href="{{ route('peminjaman.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-repost"></i>
                <div data-i18n="Tables">Peminjaman</div>
            </a>
        </li>

        {{-- <li class="menu-item {{ request()->is('peminjamandetails*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-repost"></i>
                <div data-i18n="Tables">Detail Peminjaman</div>
            </a>
        </li> --}}

        <li class="menu-item {{ request()->is('pengembalian*') ? 'active' : '' }}">
            <a href="{{ route('pengembalian.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-rotate-left"></i>
                <div data-i18n="Tables">Pengembalian</div>
            </a>
        </li>


        @if(auth()->user()->role == 'admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>

            <li class="menu-item {{ Request::is('admin/reports*') ? 'active' : '' }}">
                <a href="{{ route('reports.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                    <div data-i18n="Analytics">Analitik & Laporan</div>
                </a>
            </li>
        @endif
    </ul>
</aside>