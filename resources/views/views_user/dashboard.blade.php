@extends('layouts.user.app')

@section('title')
    Dashboard
@endsection

@section('content')\
<section id="hero" style="background: url('{{ asset('img/gambar_landing.png') }}') center/cover no-repeat fixed; position: relative;">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                <div data-aos="zoom-out">
                    <h1>DinasSolution</h1>
                    <h2>Bimbel Kedinasan Terbaik di Indonesia</h2>
                    <h2>DinasSolution adalah lembaga bimbingan belajar (bimbel) khusus persiapan seleksi masuk Sekolah Tinggi Ilmu Statistik (STIS).</h2>

                    
                    <div class="text-center text-lg-start">
                        <a href="#pricing" class="btn-get-started scrollto">Show More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                <img src="{{ asset('img/hero-img.png') }}" class="img-fluid animated" alt="Hero Image">
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about" style="background: #ffff; position: relative;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch" data-aos="fade-right" style="position: relative; overflow: hidden;">
                    <img src="{{ asset('img/aset_dashboard.jpg') }}" class="img-fluid" alt="DinasSolution - Bimbel Kedinasan" style="object-fit: cover; width: 100%; height: 100%; min-height: 400px; border-radius: 10px;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, transparent 100%);"></div>
                </div>
                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" data-aos="fade-left">
                    <h3>Kenapa harus DinasSolution</h3>
                    <p>DinasSolution merupakan sarana dalam menunjang para peserta untuk masuk sekolah kedinasan yang terdiri atas <b>TRYOUT</b> dengan 3 gelombang dan <b>KELAS</b>. Dapatkan gambaran soal yang akurat dan persiapan yang matang untuk seleksi masuk Sekolah kedinasan pilihan.</p>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon"><i class="bx bx-notepad"></i></div>
                        <h4 class="title"><a href="#">Soal Dibuat Langsung OLEH MAHASISWA POLSTAT STIS</a></h4>
                        <p class="description">Soal akurat karena dibuat langsung oleh mahasiswa Polstat STIS yang berpengalaman mengerjakan soal asli SPMB Polstat STIS baik SKD maupun Matematika</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <div class="icon"><i class="bx bx-desktop"></i></div>
                        <h4 class="title"><a href="">Pengerjaan Online Dengan Sistem CAT</a></h4>
                        <p class="description">Pengerjaan dilakukan secara daring dengan menggunakan sistem CAT (Computer Assisted Test) sehingga menyerupai sistem ujian yang sebenarnya</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <div class="icon"><i class="bx bx-money-withdraw"></i></div>
                        <h4 class="title"><a href="">Harga Terjangkau</a></h4>
                        <p class="description">Dengan harga terjangkau, kamu bisa mendapatkan Try Out dan bimbingan yang berkualitas dan bermutu</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Instructions Section ======= -->
    <section id="instructions" class="instructions" style="background: linear-gradient(135deg, #fff, #f8f9ff); position: relative;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Panduan Penggunaan Website</h2>
                <p>Cara menggunakan fitur-fitur di DinasSolution</p>
            </div>

            <!-- Video Tutorial -->
            <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-8 offset-lg-2">
                    <div class="video-tutorial">
                        <div class="video-wrapper">
                            <iframe width="100%" height="400" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Panduan Penggunaan Website DinasSolution" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="video-info text-center mt-3">
                            <h5>Video Tutorial Lengkap</h5>
                            <p>Tonton video ini untuk panduan lengkap cara menggunakan website DinasSolution</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-user-plus"></i>
                        </div>
                        <h4>1. Registrasi Akun</h4>
                        <p>Daftar akun baru dengan mengisi data diri yang valid untuk dapat mengakses semua fitur website.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-shopping-bag"></i>
                        </div>
                        <h4>2. Beli Paket</h4>
                        <p>Pilih paket bimbel yang sesuai dengan kebutuhan Anda dan lakukan pembayaran melalui sistem yang tersedia.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-book"></i>
                        </div>
                        <h4>3. Akses Materi</h4>
                        <p>Masuk ke menu "Materi Saya" untuk mengakses video pembelajaran dan materi yang telah dibeli.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-test-tube"></i>
                        </div>
                        <h4>4. Ikuti Tryout</h4>
                        <p>Kerjakan tryout dengan sistem CAT untuk mengukur kemampuan dan persiapan ujian kedinasan.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-bar-chart"></i>
                        </div>
                        <h4>5. Lihat Nilai & Raport</h4>
                        <p>Periksa hasil tryout dan laporan kemajuan belajar Anda di menu Nilai dan Raport.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="instruction-card">
                        <div class="instruction-icon">
                            <i class="bx bx-support"></i>
                        </div>
                        <h4>6. Hubungi Support</h4>
                        <p>Jika ada pertanyaan atau kendala, hubungi tim support melalui WhatsApp atau email yang tersedia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Instructions Section -->

    <!-- ======= Testimonials Section ======= -->
    @php
        $testimonials = \App\Models\Testimonial::where('is_active', true)->orderBy('created_at', 'desc')->get();
    @endphp


    @if($testimonials->count() > 0)
    <section class="testimonials" style="background: url('{{ asset('img/bg_testi.png') }}') center/cover no-repeat; position: relative;">
        <div class="container">
            <div class="section-title">
                <h2>Testimoni</h2>
                <p>Apa Kata Alumni Kami</p>
            </div>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-indicators justify-content-center">
                    @for($i = 0; $i < ceil($testimonials->count() / 3); $i++)
                        <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $i }}" {{ $i == 0 ? 'class="active"' : '' }}></button>
                    @endfor
                </div>

                <div class="carousel-inner">
                    @foreach($testimonials->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $testimonial)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        @if($testimonial->image)
                                            <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=350&fit=crop" alt="{{ $testimonial->name }}">
                                        @endif

                                        <!-- Rating Badge - Top Right -->
                                        <div class="rating-badge">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-muted"></i>
                                                @endif
                                            @endfor
                                        </div>

                                        <!-- Badge Lulusan - Top Left (compact) -->
                                        @if($testimonial->graduation)
                                        <div class="testimonial-badge">
                                            <i class="bi bi-graduation-cap badge-icon"></i>
                                            <span class="badge-text-compact">{{ Str::limit($testimonial->graduation, 18) }}</span>
                                        </div>
                                        @endif

                                        <!-- Name Badge -->
                                        <div class="testimonial-name-badge">
                                            <h4>{{ strtoupper($testimonial->name) }}</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            {{ $testimonial->message }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($testimonials->count() > 3)
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- My Courses Section - For authenticated users with purchases -->
    @if(isset($purchasedPackages) && $purchasedPackages->isNotEmpty())
    <section id="my-courses" class="pricing" style="background: linear-gradient(135deg, #e8f5e8, #d4edda); position: relative;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Kursus Saya</h2>
                <p>Paket yang sudah Anda beli</p>
            </div>

            <div class="row" data-aos="fade-left">
                @foreach ($purchasedPackages as $paket)
                    <div class="col-lg-4 col-md-6 mt-4 mb-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="400" style="border: 3px solid #28a745;">
                            <span class="advanced" style="background: #28a745;">Purchased</span>
                            <h3>{{ $paket->nama }}</h3>
                            <h4><sup>Rp</sup>{{ number_format($paket->harga, 0, ',', '.') }}</h4>
                            {!! $paket->deskripsi !!}
                            <div class="btn-wrap">
                                @if($paket->whatsapp_group_link)
                                   <a href="{{ $paket->whatsapp_group_link }}" target="_blank" type="button" style="width: 10rem; border: 2px solid; border-color: #28a745" class="btn-buy mb-2">Grup WA</a>
                                @endif
                                <a href="{{ route('tryout.index', $paket->id) }}" type="button" style="width: 10rem; background-color: #28a745; border: 2px solid; border-color: #28a745" class="btn-buy">Materi Saya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing" style="background: linear-gradient(135deg, #f8f9ff, #e8e2ff); position: relative;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Daftar</h2>
                <p>{{ isset($purchasedPackages) ? 'Paket Lainnya yang Tersedia' : 'Pilihan Paket Kedinasan' }}</p>
            </div>

            <div class="row" data-aos="fade-left">
                @php
                    // For authenticated users, show only available packages (not purchased)
                    // For guest users, show all packages
                    if (auth()->check() && isset($availablePackages)) {
                        $packagesToShow = $availablePackages;
                    } else {
                        $packagesToShow = $pakets;
                    }
                @endphp
                @if ($packagesToShow->isEmpty())
                    <div class="alert alert-primary" role="alert">Paket Ujian belum tersedia</div>
                @else
                    @foreach ($packagesToShow as $paket)
                        <div class="col-lg-4 col-md-6 mt-4 mb-4 mt-lg-0">
                            <div class="box" data-aos="zoom-in" data-aos-delay="400">
                                @if ($paket->id == '03dfc817-3ee3-404c-b162-e1a4acb8ff73')
                                    <span class="advanced">Terlaris</span>
                                @endif
                                <h3>{{ $paket->nama }}</h3>
                                <h4><sup>Rp</sup>{{ number_format($paket->harga, 0, ',', '.') }}</h4>
                                {!! $paket->deskripsi !!}
                                <div class="btn-wrap">
                                    @if (Carbon\Carbon::now()->between($paket->waktu_mulai, $paket->waktu_akhir))
                                        <form method="post" action="{{ route('pembelian.store') }}">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                            <button type="submit" class="btn-buy">Beli Paket</button>
                                        </form>
                                    @else
                                        <button type="button" style="background-color: grey; border-color: black" class="btn-buy">Belum Tersedia</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Tutor Section ======= -->
    @if(isset($tutors) && $tutors->count() > 0)
    <section id="tutors" class="tutors" style="background: linear-gradient(135deg, #fef7ff, #f3e8ff); position: relative;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Tentor Kami</h2>
                <p>Tim Pengajar Berpengalaman</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                @foreach($tutors as $tutor)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="tutor-card">
                        <div class="tutor-image">
                            @if($tutor->image)
                                <img src="{{ asset('storage/' . $tutor->image) }}" alt="{{ $tutor->user->name }}">
                            @else
                                <img src="{{ asset('img/default-tutor.png') }}" alt="{{ $tutor->user->name }}">
                            @endif
                        </div>
                        <div class="tutor-info text-center">
                            <h3>{{ $tutor->user->name }}</h3>
                            <p class="tutor-title">{{ $tutor->specialization ?: 'Tutor DinasSolution' }}</p>
                            <p class="tutor-desc">{{ $tutor->bio ?: 'Pengajar berpengalaman di bidang kedinasan' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- ======= Articles Section ======= -->
    @if (isset($articles) && $articles->count() > 0)
        <section id="articles" class="articles" style="background: linear-gradient(135deg, rgba(147, 51, 234, 0.05), rgba(124, 58, 237, 0.05)), url('{{ asset('img/articles-bg.jpg') }}') center/cover no-repeat; position: relative;">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Artikel</h2>
                    <p>Tips & Strategi Belajar</p>
                </div>

                <!-- Featured Articles -->
                @if(isset($featuredArticles) && $featuredArticles->count() > 0)
                <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12">
                        <h3 class="mb-4">Artikel Unggulan</h3>
                    </div>
                    @foreach ($featuredArticles as $featured)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="tutor-card">
                                @if($featured->featured_image)
                                <div class="tutor-image">
                                    <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}">
                                </div>
                                @endif
                                <div class="tutor-info">
                                    <h3>{{ $featured->title }}</h3>
                                    <p class="tutor-title">
                                        <span class="badge" style="background-color: var(--primary-color);">{{ ucfirst($featured->category) }}</span>
                                        <small class="text-muted">{{ $featured->formatted_published_date }}</small>
                                    </p>
                                    <p class="tutor-desc">{{ \Illuminate\Support\Str::limit(strip_tags($featured->excerpt), 100) }}</p>
                                    <a href="{{ route('articles.show', $featured->slug) }}" class="btn-buy btn-article" style="display: inline-block; padding: 10px 25px; margin-top: 15px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- All Articles -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12">
                        <h3 class="mb-4">{{ isset($featuredArticles) && $featuredArticles->count() > 0 ? 'Artikel Lainnya' : 'Artikel Terbaru' }}</h3>
                    </div>
                    @foreach ($articles as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="tutor-card">
                                @if($article->featured_image)
                                <div class="tutor-image">
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                </div>
                                @endif
                                <div class="tutor-info">
                                    <h3>{{ $article->title }}</h3>
                                    <p class="tutor-title">
                                        <span class="badge" style="background-color: var(--primary-color);">{{ ucfirst($article->category) }}</span>
                                        <small class="text-muted">{{ $article->formatted_published_date }}</small>
                                    </p>
                                    <p class="tutor-desc">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt), 100) }}</p>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="btn-buy btn-article" style="display: inline-block; padding: 10px 25px; margin-top: 15px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('articles.index') }}" class="btn-buy btn-article-main" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(147, 51, 234, 0.4); text-transform: uppercase; letter-spacing: 1px;">Lihat Semua Artikel</a>
                </div>
            </div>
        </section><!-- End Articles Section -->
    @endif

    <!-- ======= F.A.Q Section ======= -->
    @if ($faqs)
        <section id="faq" class="faq section-bg" style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); position: relative;">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>F.A.Q</h2>
                    <p>Frequently Asked Questions</p>
                </div>
                <div class="faq-list">
                    <div class="row">
                        @foreach ($faqs as $index => $faq)
                            @if ($index < 4)
                                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                    <div class="faq-card">
                                        <div class="faq-header">
                                            <h5 class="faq-question">
                                                <button class="faq-toggle {{ $index > 0 ? 'collapsed' : '' }}"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#faq-list-{{ $index }}"
                                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                        aria-controls="faq-list-{{ $index }}">
                                                    <span class="faq-toggle-content">
                                                        {{ $faq->title }}
                                                    </span>
                                                    <i class="bx bx-chevron-down toggle-icon"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="faq-list-{{ $index }}" class="faq-collapse collapse {{ $index == 0 ? 'show' : '' }}">
                                            <div class="faq-answer">
                                                {!! $faq->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if ($faqs->count() > 4)
                    <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="{{ 5 * 100 }}">
                        <a href="{{ route('faq.index') }}" class="btn-faq-more">
                            <span>Lihat Semua FAQ</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </a>
                    </div>
                @endif
            </div>
        </section><!-- End F.A.Q Section -->
    @endif

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="background: linear-gradient(135deg, #fdf4ff, #f9e8ff); position: relative;">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div>

            <div class="row">
                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p><a style="color: inherit;" href="mailto:padilzaki73@gmail.com">padilzaki73@gmail.com</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 1:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6283117106878?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20Paket%20Bimbel">0883117106878 (Kak Ayu) - WhatsApp untuk Konsultasi</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 2:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6283195559334?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20tryout">083195559334 (Mizan) - WhatsApp untuk Konsultasi</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 3:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6281914952169?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20tryout">081914952169 (Dinur) - WhatsApp untuk Konsultasi</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <form action="{{ route('sendEmail') }}" method="post" role="form" class="php-email-form">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Judul" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Menunggu</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Pesanmu telah terkirim, terimakasih!</div>
                        </div>
                        <div class="text-center">
                            <button type="submit">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
</main><!-- End #main -->
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #9333ea;
            --primary-hover: #7c3aed;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Testimonial Card - Mirip Gambar */
        .testimonial-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        /* Image Container dengan Badge */
        .testimonial-image-wrapper {
            position: relative;
            width: 100%;
            height: 350px;
            overflow: hidden;
            border-radius: 20px 20px 0 0;
        }

        .testimonial-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .testimonial-card:hover .testimonial-image-wrapper img {
            transform: scale(1.05);
        }

        /* Badge di atas foto (top left) - compact & semi-transparent */
        .testimonial-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(147, 51, 234, 0.85);
            color: white;
            padding: 6px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 11px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 3;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge-icon {
            font-size: 16px;
        }

        .badge-text-compact {
            font-size: 10px;
            font-weight: 500;
            line-height: 1.2;
            opacity: 0.95;
        }

        /* Rating Badge - Top Right (compact & semi-transparent) */
        .rating-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.85);
            color: #f59e0b;
            padding: 6px 10px;
            border-radius: 15px;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 20;
            border: 1px solid rgba(245, 158, 11, 0.3);
            backdrop-filter: blur(4px);
        }

        .rating-badge i {
            font-size: 11px;
            margin: 0 1px;
            filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.1));
        }

        /* Name Badge di bawah foto */
        .testimonial-name-badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 20px 25px;
            clip-path: polygon(0 30%, 100% 0, 100% 100%, 0% 100%);
        }

        .testimonial-name-badge h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Content Area */
        .testimonial-content {
            padding: 30px;
            flex-grow: 1;
            background: white;
        }

        .testimonial-text {
            color: #4a5568;
            font-size: 15px;
            line-height: 1.8;
            margin: 0;
        }

        /* Carousel Controls */
    /* Carousel Controls */
#testimonialCarousel {
    padding-bottom: 100px; /* Beri ruang untuk controls */
    position: relative;
}

#testimonialCarousel .carousel-indicators {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    margin: 0;
    display: flex;
    justify-content: center;
    gap: 8px;
    z-index: 10;
}

#testimonialCarousel .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--primary-color);
    opacity: 0.4;
    border: none;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease;
}

#testimonialCarousel .carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.3);
    box-shadow: 0 0 8px rgba(184, 58, 94, 0.4);
}

/* Carousel Navigation Buttons */
.carousel-controls-wrapper {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 100px;
    z-index: 5;
}

#testimonialCarousel .carousel-control-prev,
#testimonialCarousel .carousel-control-next {
    position: absolute;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    border-radius: 50%;
    opacity: 0.9;
    bottom: 20px;
    top: auto;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(184, 58, 94, 0.3);
    z-index: 15;
    border: none;
    cursor: pointer;
}

#testimonialCarousel .carousel-control-prev {
    left: calc(50% - 130px);
}

#testimonialCarousel .carousel-control-next {
    right: calc(50% - 130px);
    left: auto;
}

#testimonialCarousel .carousel-control-prev:hover,
#testimonialCarousel .carousel-control-next:hover {
    opacity: 1;
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(184, 58, 94, 0.4);
}

#testimonialCarousel .carousel-control-prev-icon,
#testimonialCarousel .carousel-control-next-icon {
    width: 20px;
    height: 20px;
    filter: brightness(0) invert(1);
}

/* Responsive */
@media (max-width: 992px) {
    .testimonial-image-wrapper {
        height: 300px;
    }

    .testimonial-badge {
        padding: 10px 15px;
        font-size: 12px;
    }

    .testimonial-name-badge h4 {
        font-size: 18px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 110px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 110px);
    }
}

@media (max-width: 768px) {
    .testimonial-image-wrapper {
        height: 280px;
    }

    .testimonial-content {
        padding: 20px;
    }

    .testimonial-text {
        font-size: 14px;
    }

    #testimonialCarousel {
        padding-bottom: 90px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        width: 45px;
        height: 45px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 90px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 90px);
    }

    #testimonialCarousel .carousel-indicators {
        bottom: 25px;
    }
}

@media (max-width: 576px) {
    #testimonialCarousel {
        padding-bottom: 70px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        width: 40px;
        height: 40px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 70px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 70px);
    }

    #testimonialCarousel .carousel-indicators {
        bottom: 20px;
        gap: 6px;
    }

    #testimonialCarousel .carousel-indicators button {
        width: 10px;
        height: 10px;
    }

    #testimonialCarousel .carousel-control-prev-icon,
    #testimonialCarousel .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }
}

@media (max-width: 400px) {
    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 60px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 60px);
    }
}

/* Enhanced Article Buttons */
.btn-article {
    position: relative;
    overflow: hidden;
}

.btn-article::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-article:hover::before {
    left: 100%;
}

.btn-article:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(147, 51, 234, 0.4) !important;
}

.btn-article-main {
    position: relative;
    overflow: hidden;
}

.btn-article-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s;
}

.btn-article-main:hover::before {
    left: 100%;
}

.btn-article-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(147, 51, 234, 0.5) !important;
}

.btn-article-main:active,
.btn-article:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(147, 51, 234, 0.3) !important;
}

/* Enhanced FAQ Section */
.faq-list {
    max-width: 1200px;
    margin: 0 auto;
}

.faq-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.8);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.faq-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

.faq-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.faq-card:hover::before {
    transform: scaleX(1);
}

.faq-header {
    padding: 24px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.faq-question {
    margin: 0;
}

.faq-toggle {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    padding: 0;
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: color 0.3s ease;
    line-height: 1.4;
}

.faq-toggle-content {
    display: flex;
    align-items: center;
    flex: 1;
}

.faq-toggle:hover {
    color: var(--primary-color);
}

.faq-toggle:focus {
    outline: none;
    color: var(--primary-color);
}

.toggle-icon {
    font-size: 20px;
    color: var(--primary-color);
    transition: transform 0.3s ease;
    margin-left: 12px;
    flex-shrink: 0;
}

.faq-toggle.collapsed .toggle-icon {
    transform: rotate(0deg);
}

.faq-toggle:not(.collapsed) .toggle-icon {
    transform: rotate(180deg);
}

.faq-collapse {
    transition: all 0.3s ease;
}

.faq-answer {
    padding: 24px;
    color: #64748b;
    line-height: 1.7;
    font-size: 16px;
    background: white;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.faq-answer p {
    margin-bottom: 16px;
}

.faq-answer p:last-child {
    margin-bottom: 0;
}

.faq-answer ul, .faq-answer ol {
    margin: 16px 0;
    padding-left: 24px;
}

.faq-answer li {
    margin-bottom: 8px;
    color: #475569;
}

.faq-answer strong, .faq-answer b {
    color: #1e293b;
    font-weight: 600;
}

.faq-answer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.faq-answer a:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* FAQ More Button */
.btn-faq-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(147, 51, 234, 0.3);
    border: 2px solid transparent;
}

.btn-faq-more:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(147, 51, 234, 0.4);
    background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
}

.btn-faq-more:active {
    transform: translateY(0);
    box-shadow: 0 4px 16px rgba(147, 51, 234, 0.3);
}

.btn-faq-more i {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.btn-faq-more:hover i {
    transform: translateX(4px);
}

/* Responsive FAQ */
@media (max-width: 768px) {
    .faq-header {
        padding: 20px;
    }

    .faq-toggle {
        font-size: 16px;
        line-height: 1.3;
    }

    .faq-toggle-content {
        flex: 1;
    }

    .faq-answer {
        padding: 20px;
        font-size: 15px;
    }

    .btn-faq-more {
        padding: 12px 24px;
        font-size: 15px;
    }
}

@media (max-width: 576px) {
    .faq-card {
        margin: 0 8px;
    }

    .faq-header {
        padding: 16px;
    }

    .faq-toggle {
        font-size: 15px;
    }

    .faq-toggle-content {
        flex: 1;
    }

    .faq-answer {
        padding: 16px;
        font-size: 14px;
    }
}

    /* FAQ consistent height for dashboard */
    .faq-list .faq-card {
        margin-bottom: 15px;
    }

    .faq-card .faq-header {
        min-height: 70px;
        display: flex;
        align-items: center;
    }

    .faq-card .faq-collapse {
        background-color: #ffffff;
    }

    .faq-card .faq-answer {
        padding: 20px 24px;
    }

    /* Instructions Section */
    .instructions {
        padding: 80px 0;
    }

    .video-tutorial {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }

    .video-info h5 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .video-info p {
        color: #64748b;
        font-size: 16px;
        margin: 0;
    }

    .instruction-card {
        background: white;
        border-radius: 16px;
        padding: 30px 25px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .instruction-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .instruction-card:hover::before {
        transform: scaleX(1);
    }

    .instruction-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }

    .instruction-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 32px;
        box-shadow: 0 8px 24px rgba(147, 51, 234, 0.3);
    }

    .instruction-card h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
    }

    .instruction-card p {
        color: #64748b;
        line-height: 1.6;
        font-size: 15px;
        margin: 0;
    }

    /* Responsive Instructions */
    @media (max-width: 768px) {
        .video-tutorial {
            padding: 20px;
        }

        .video-wrapper {
            padding-bottom: 50%; /* Adjust aspect ratio for mobile */
        }

        .video-info h5 {
            font-size: 18px;
        }

        .video-info p {
            font-size: 14px;
        }

        .instruction-card {
            padding: 25px 20px;
        }

        .instruction-icon {
            width: 70px;
            height: 70px;
            font-size: 28px;
        }

        .instruction-card h4 {
            font-size: 18px;
        }

        .instruction-card p {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .instructions {
            padding: 60px 0;
        }

        .video-tutorial {
            padding: 15px;
        }

        .video-wrapper {
            padding-bottom: 45%;
        }

        .video-info h5 {
            font-size: 16px;
        }

        .video-info p {
            font-size: 13px;
        }

        .instruction-card {
            padding: 20px 15px;
        }

        .instruction-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        .instruction-card h4 {
            font-size: 16px;
        }
    }

    </style>
@endpush

@push('scripts')
<script>
    (function () {
        "use strict";

        let forms = document.querySelectorAll(".php-email-form");

        forms.forEach(function (e) {
            e.addEventListener("submit", function (event) {
                event.preventDefault();

                let thisForm = this;
                let action = thisForm.getAttribute("action");
                let recaptcha = thisForm.getAttribute("data-recaptcha-site-key");

                if (!action) {
                    displayError(thisForm, "The form action property is not set!");
                    return;
                }
                thisForm.querySelector(".loading").classList.add("d-block");
                thisForm.querySelector(".error-message").classList.remove("d-block");
                thisForm.querySelector(".sent-message").classList.remove("d-block");

                let formData = new FormData(thisForm);

                if (recaptcha) {
                    if (typeof grecaptcha !== "undefined") {
                        grecaptcha.ready(function () {
                            try {
                                grecaptcha.execute(recaptcha, {
                                    action: "php_email_form_submit"
                                }).then((token) => {
                                    formData.set("recaptcha-response", token);
                                    php_email_form_submit(thisForm, action, formData);
                                });
                            } catch (error) {
                                displayError(thisForm, error);
                            }
                        });
                    } else {
                        displayError(thisForm, "The reCaptcha javascript API url is not loaded!");
                    }
                } else {
                    php_email_form_submit(thisForm, action, formData);
                }
            });
        });

        function php_email_form_submit(thisForm, action, formData) {
            fetch(action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
            }).then((response) => {
                thisForm.querySelector(".loading").classList.remove("d-block");
                thisForm.querySelector(".sent-message").classList.add("d-block");
                thisForm.reset();
            });
        }

        function displayError(thisForm, error) {
            thisForm.querySelector(".loading").classList.remove("d-block");
            thisForm.querySelector(".error-message").innerHTML = error;
            thisForm.querySelector(".error-message").classList.add("d-block");
        }

        // FAQ Toggle Icon Handler
        const initFAQToggle = () => {
            const faqToggles = document.querySelectorAll('.faq-toggle');

            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    // Small delay to let Bootstrap handle the collapse first
                    setTimeout(() => {
                        const targetId = this.getAttribute('data-bs-target');
                        const target = document.querySelector(targetId);

                        if (target && target.classList.contains('show')) {
                            this.classList.remove('collapsed');
                        } else {
                            this.classList.add('collapsed');
                        }
                    }, 10);
                });
            });
        };

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFAQToggle);
        } else {
            initFAQToggle();
        }

        // Initialize testimonial carousel
        const initTestimonialCarousel = () => {
            const carousel = document.getElementById('testimonialCarousel');
            if (carousel && typeof bootstrap !== 'undefined') {
                const bsCarousel = new bootstrap.Carousel(carousel, {
                    interval: 4000,
                    wrap: true,
                    touch: true
                });

                // Add click handlers for controls
                const prevBtn = carousel.querySelector('.carousel-control-prev');
                const nextBtn = carousel.querySelector('.carousel-control-next');

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        bsCarousel.prev();
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        bsCarousel.next();
                    });
                }
            }
        };

        // Initialize carousel when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTestimonialCarousel);
        } else {
            initTestimonialCarousel();
        }
    })();
</script>
@endpush