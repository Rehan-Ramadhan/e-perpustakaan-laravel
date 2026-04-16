@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
  <div>
    <section class="py-3"
      style="background-image: url('{{ asset('pengguna/images/background-pattern.jpg') }}');background-repeat: no-repeat;background-size: cover;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            {{-- banner --}}
            <div class="banner-blocks">

              <div class="banner-ad large bg-info block-1">
                <div class="swiper main-swiper">
                  <div class="swiper-wrapper">

                    {{-- Slide 1: Welcome --}}
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories my-3">Koleksi Digital Terlengkap</div>
                          <h3 class="display-4">Jendela Dunia di Ujung Jari</h3>
                          <p>Temukan ribuan referensi buku, jurnal, dan literatur pilihan untuk mendukung riset dan
                            wawasan Anda.</p>
                          <a href="#unggulan"
                            class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Mulai
                            Membaca</a>
                        </div>
                        <div class="img-wrapper col-md-5">
                          <img src="{{ asset('pengguna/images/buku.png') }}" class="img-fluid">
                        </div>
                      </div>
                    </div>

                    {{-- Slide 2: New Arrivals --}}
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories mb-3 pb-3">Rekomendasi Pekan Ini</div>
                          <h3 class="banner-title">Koleksi Buku Populer 2026</h3>
                          <p>Dapatkan akses ke buku-buku best-seller terbaru yang baru saja mendarat di rak digital kami.
                          </p>
                          <a href="#terpopuler" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Lihat
                            Koleksi</a>
                        </div>
                        <div class="img-wrapper col-md-5">
                          <img src="{{ asset('pengguna/images/buku.png') }}" class="img-fluid">
                        </div>
                      </div>
                    </div>

                    {{-- Slide 3: Literasi & Fun Fact --}}
                    <div class="swiper-slide">
                      <div class="row banner-content p-5">
                        <div class="content-wrapper col-md-7">
                          <div class="categories mb-3 pb-3">Wawasan & Fun Fact</div>
                          <h3 class="banner-title">Tahukah Kamu?</h3>
                          <p>Membaca buku 15 menit sehari bisa mengurangi stres hingga 68%. Temukan fakta menarik lainnya
                            dan tips meningkatkan minat baca di blog kami.</p>

                          <a href="#latest-blog" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                            Baca Artikel
                          </a>
                        </div>
                        <div class="img-wrapper col-md-5">
                          <img src="{{ asset('pengguna/images/buku.png') }}" class="img-fluid">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-pagination"></div>
                </div>
              </div>

              {{-- Banner Kecil Atas --}}
              <div class="banner-ad bg-success-subtle block-2"
                style="background:url('{{ asset('pengguna/images/buku.png') }}') no-repeat;background-position: right bottom">
                <div class="row banner-content p-5">
                  <div class="content-wrapper col-md-7">
                    <div class="categories mb-3 pb-3">Kategori</div>
                    <h3 class="banner-title">Sains & Teknologi</h3>
                    <a href="#" class="d-flex align-items-center nav-link">Cek Rak Buku <svg width="24" height="24">
                        <use xlink:href="#arrow-right"></use>
                      </svg></a>
                  </div>
                </div>
              </div>

              {{-- Banner Kecil Bawah --}}
              <div class="banner-ad bg-danger block-3"
                style="background:url('{{ asset('pengguna/images/buku.png') }}') no-repeat;background-position: right bottom">
                <div class="row banner-content p-5">
                  <div class="content-wrapper col-md-7">
                    <div class="categories mb-3 pb-3">Paling Dicari</div>
                    <h3 class="item-title">Sastra & Fiksi</h3>
                    <a href="#" class="d-flex align-items-center nav-link">Cek Rak Buku <svg width="24" height="24">
                        <use xlink:href="#arrow-right"></use>
                      </svg></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Banner Blocks -->

          </div>
        </div>
      </div>
    </section>

    {{-- kategori --}}
    <section class="py-5 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header d-flex flex-wrap justify-content-between mb-5">
              <h2 class="section-title">Kategori</h2>
              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                  <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="category-carousel swiper">
              <div class="swiper-wrapper">
                @foreach($categories as $category)
                  <a href="#" class="nav-link category-item swiper-slide">
                    <img src="{{ $category->image_url ?? asset('pengguna/images/icon-category.png') }}"
                      alt="{{ $category->nama }}">
                    <h3 class="category-title">{{ $category->nama }}</h3>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- populer --}}
    <section id="terpopuler" class="py-5 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header d-flex flex-wrap justify-content-between my-5">
              <h2 class="section-title">Terpopuler</h2
              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">Lihat Semua Kategori →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                  <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                </div>
              </div>
            </div>
          </div>
        </div
        <div class="row">
          <div class="col-md-12">
            <div class="products-carousel swiper">
              <div class="swiper-wrapper">
                @foreach($popularBooks as $buku)
                  <div class="product-item swiper-slide">
                    @if($buku->stok <= 0)
                      <span class="badge bg-danger position-absolute m-3">Habis</span>
                    @elseif($buku->is_featured)
                      <span class="badge bg-success position-absolute m-3">Unggulan</span>
                    @endif
                    <a href="#" class="btn-wishlist">
                      <svg width="24" height="24">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </a>
                    <figure>
                      <a href="{{ route('admin.buku.show', $buku->id) }}" title="{{ $buku->nama }}">
                        @php
                          $cover = $buku->gambarBukus->first();
                          $path = $cover ? asset('storage/' . $cover->lokasi_gambar) : asset('pengguna/images/no-cover.png');
                        @endphp
                        <img src="{{ $path }}" class="tab-image" style="height: 250px; object-fit: cover;">
                      </a>
                    </figure>
                    <h3>{{ Str::limit($buku->nama, 35) }}</h3>
                    <span class="qty">{{ $buku->penerbit }}</span>
                    <span class="rating">
                      <svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 5.0
                    </span>
                    <span class="price">{{ $buku->kategori->nama ?? 'Umum' }}</span>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="product-qty-info">
                        <span class="badge border text-dark fw-light">Tersedia: {{ $buku->stok }}</span>
                      </div>
                      <a href="#" class="nav-link fw-bold">Pinjam <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- terbaru --}}
    <section id="terbaru" class="py-5 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">
              <h2 class="section-title">Terbaru</h2>
              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                  <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="brand-carousel swiper">
              <div class="swiper-wrapper">
                @foreach($latestBooks as $buku)
                  <div class="swiper-slide">
                    <div class="card mb-3 p-3 rounded-4 shadow border-0">
                      <a href="{{ route('admin.buku.show', $buku->id) }}" class="nav-link">
                        <div class="row g-0">
                          <div class="col-md-4">
                            @php
                              $cover = $buku->gambarBukus->first();
                              $path = $cover ? asset('storage/' . $cover->lokasi_gambar) : asset('pengguna/images/no-cover.png');
                            @endphp
                            <img src="{{ $path }}" class="img-fluid rounded"
                              style="height: 100px; width: 100%; object-fit: cover;" alt="{{ $buku->nama }}">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body py-0">
                              <p class="text-muted mb-0">{{ $buku->pengarang }}</p>
                              <h5 class="card-title">{{ Str::limit($buku->nama, 25) }}</h5>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- diskon --}}
    <section class="py-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="banner-ad bg-danger mb-3"
              style="background: url('{{ asset('pengguna/images/buku.png') }}'); background-repeat: no-repeat; background-position: right bottom; background-size: contain; border-radius: 15px;">
              <div class="banner-content p-5">
                <div class="row">
                  <div class="col-md-7">
                    <div class="categories text-primary fs-3 fw-bold">Koleksi Spesial</div>
                    <h3 class="categories text-primary fs-3 fw-bold">Sastra Dunia</h3>
                    <p>Jelajahi karya-karya sastra klasik hingga modern dari penulis ternama.</p>
                    <a href="#" class="btn btn-dark text-uppercase mt-3">Cek Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="banner-ad bg-info"
              style="background: url('{{ asset('pengguna/images/buku.png') }}'); background-repeat: no-repeat; background-position: right bottom; background-size: contain; border-radius: 15px;">
              <div class="banner-content p-5">
                <div class="row">
                  <div class="col-md-7">
                    <div class="categories text-primary fs-3 fw-bold">E-Journal</div>
                    <h3 class="categories text-primary fs-3 fw-bold">Riset & Jurnal</h3>
                    <p>Akses gratis ribuan jurnal ilmiah untuk mendukung tugas akhir Anda.</p>
                    <a href="#" class="btn btn-dark text-uppercase mt-3">Cek Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- unggulan --}}
    <section id="unggulan" class="py-5 overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="section-header d-flex flex-wrap justify-content-between my-5">
              <h2 class="section-title">Unggulan</h2>
              <div class="d-flex align-items-center">
                <a href="#" class="btn-link text-decoration-none">Lihat Semua Kategori →</a>
                <div class="swiper-buttons">
                  <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                  <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="products-carousel swiper">
              <div class="swiper-wrapper">
                @foreach($featuredBooks as $buku)
                  <div class="product-item swiper-slide">
                    @if($buku->stok <= 0)
                      <span class="badge bg-danger position-absolute m-3">Habis</span>
                    @elseif($buku->is_featured)
                      <span class="badge bg-success position-absolute m-3">Unggulan</span>
                    @endif
                    <a href="#" class="btn-wishlist">
                      <svg width="24" height="24">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </a>
                    <figure>
                      <a href="{{ route('admin.buku.show', $buku->id) }}" title="{{ $buku->nama }}">
                        @php
                          $cover = $buku->gambarBukus->first();
                          $path = $cover ? asset('storage/' . $cover->lokasi_gambar) : asset('pengguna/images/no-cover.png');
                        @endphp
                        <img src="{{ $path }}" class="tab-image" style="height: 250px; object-fit: cover;">
                      </a>
                    </figure>
                    <h3>{{ Str::limit($buku->nama, 35) }}</h3>
                    <span class="qty">{{ $buku->penerbit }}</span>
                    <span class="rating">
                      <svg width="24" height="24" class="text-primary">
                        <use xlink:href="#star-solid"></use>
                      </svg> 5.0
                    </span>
                    <span class="price">{{ $buku->kategori->nama ?? 'Umum' }}</span>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="product-qty-info">
                        <span class="badge border text-dark fw-light">Tersedia: {{ $buku->stok }}</span>
                      </div>
                      <a href="#" class="nav-link fw-bold">Pinjam <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- atas footer --}}
    <section class="py-5">
      <div class="container-fluid">
        <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5 g-4">
          <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper mb-3 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z" />
                  </svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5 class="fw-bold fs-6 mb-2">Pengiriman Gratis</h5>
                    <p class="card-text small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper mb-3 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                  </svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5 class="fw-bold fs-6 mb-2">Pembayaran 100% Aman</h5>
                    <p class="card-text small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper mb-3 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                  </svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5 class="fw-bold fs-6 mb-2">Jaminan Kualitas</h5>
                    <p class="card-text small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper mb-3 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                  </svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5 class="fw-bold fs-6 mb-2">Hemat</h5>
                    <p class="card-text small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 text-center">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper mb-3 text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                  </svg>
                </div>
                <div class="col-md-10">
                  <div class="card-body p-0">
                    <h5 class="fw-bold fs-6 mb-2">Penawaran Harian</h5>
                    <p class="card-text small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection