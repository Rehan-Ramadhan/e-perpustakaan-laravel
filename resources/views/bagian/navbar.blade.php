<header>
    <div class="container-fluid">
        <div class="row py-3 border-bottom">

            <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                <div class="main-logo">
                    <a href="{{ route('home') }}"
                        class="text-decoration-none d-flex align-items-center justify-content-center justify-content-sm-start">
                        <img src="{{ asset('pengguna/images/favicon/logo.png') }}" alt="logo" class="img-fluid"
                            width="65">
                        <span class="app-brand-text demo menu-text fw-bolder ms-2 text-dark"
                            style="text-transform: uppercase; letter-spacing: 1px;">
                            e-perpustakaan
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
                <div class="search-bar row bg-light p-2 my-2 rounded-4">
                    <div class="col-md-3 d-none d-md-block">
                        <select class="form-select border-0 bg-transparent">
                            <option>Kategori</option>
                            <option>Groceries</option>
                            <option>Drinks</option>
                            <option>Chocolates</option>
                        </select>
                    </div>
                    <div class="col-11 col-md-8">
                        <form id="search-form" class="text-center" action="#" method="post">
                            <input type="text" name="q" class="form-control" placeholder="Cari buku..."
                                value="{{ request('q') }}">
                        </form>
                    </div>
                    <div class="col-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                <div class="support-box text-end d-none d-xl-block">
                    <span class="fs-6 text-muted">Untuk Dukungan?</span>
                    <h5 class="mb-0">62+ 123-4567-8910</h5>
                </div>

                <ul class="d-flex justify-content-end list-unstyled m-0 align-items-center">
                    @auth
                        <li class="nav-item dropdown mx-1">
                            <a href="#"
                                class="rounded-circle bg-light p-2 d-flex align-items-center justify-content-center dropdown-toggle hide-arrow"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 45px; height: 45px;">
                                <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="30" height="30"
                                    alt="{{ auth()->user()->name }}">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li class="px-3 py-2"><strong>Halo, {{ auth()->user()->name }}!</strong></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-bag me-2"></i> Pesanan</a></li>
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item text-primary" href="{{ route('admin.dashboard') }}"
                                            target="_blank"><i class="bi bi-speedometer2 me-2"></i> Admin
                                            Panel</a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i
                                                class="bi bi-box-arrow-right me-2"></i>
                                            Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        {{-- Wishlist --}}
                        <li class="mx-1">
                            <a href="#"
                                class="rounded-circle bg-light p-2 d-flex align-items-center justify-content-center position-relative"
                                style="width: 45px; height: 45px;">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg>
                            </a>
                        </li>

                    @else
                        <li class="nav-item me-2">
                            <a class="nav-link fw-bold" href="#">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-warning rounded-pill px-3 btn-sm" href="#">Daftar</a>
                        </li>
                    @endauth
                </ul>

                <div class="cart text-end d-none d-lg-block">
                    <a href="#" class="border-0 bg-transparent d-flex flex-column gap-2 lh-1 text-decoration-none">
                        <span class="fs-6 text-muted">Keranjang Saya</span>
                        <span class="cart-total fs-5 fw-bold text-dark">
                            Total 0
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>