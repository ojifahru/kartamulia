{{-- filepath: c:\Users\ojifahru\Herd\univbatam\resources\views\pages\home.blade.php --}}
@extends('layouts.app')

@section('title', 'Karta Mulia - Home')
@section('content')
    <!--====== SLIDER PART START ======-->
    <section id="slider" class="slider-element swiper_wrapper min-vh-60 min-vh-md-100" data-autoplay="7000" data-speed="650"
        data-loop="true">
        <div class="slider-inner">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper ">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide dark" style="color: white;">
                            <div class="container">
                            </div>
                            <div class="swiper-slide-bg"
                                style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="slider-arrow-left"><i class="uil uil-angle-left-b"></i></div>
                <div class="slider-arrow-right"><i class="uil uil-angle-right-b"></i></div>
                <div class="slide-number">
                    <div class="slide-number-current"></div><span>/</span>
                    <div class="slide-number-total"></div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <!--====== SLIDER PART ENDS ======-->

    <!--====== Misi =====-->
    <div class="heading-block mt-0 text-center">
        <h2 data-animate="swing">{{ __('home.mission') }}</h2>
        <span class="mx-auto"></span>
    </div>

    <div class="row align-items-center col-mb-50 mb-4">
        <div class="col-lg-4 col-md-6">

            <div class="feature-box flex-md-row-reverse text-md-end" data-animate="fadeIn">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-1-circle"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>{{ __('misi.title_1') }}</h3>
                    <p>{{ __('misi.misi_1') }}</p>
                </div>
            </div>

            <div class="feature-box flex-md-row-reverse text-md-end mt-5" data-animate="fadeIn" data-delay="200">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-2-circle"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>{{ __('misi.title_2') }}</h3>
                    <p>{{ __('misi.misi_2') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 d-md-none d-lg-block text-center">
            <img src="{{ asset('storage/misi/Misi.jpg') }}" alt="Misi Karta Mulia">
        </div>

        <div class="col-lg-4 col-md-6">

            <div class="feature-box" data-animate="fadeIn">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-3-circle"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>{{ __('misi.title_3') }}</h3>
                    <p>{{ __('misi.misi_3') }}</p>
                </div>
            </div>

            <div class="feature-box mt-5" data-animate="fadeIn" data-delay="200">
                <div class="fbox-icon">
                    <a href="#"><i class="bi-4-circle"></i></a>
                </div>
                <div class="fbox-content">
                    <h3>{{ __('misi.title_4') }}</h3>
                    <p>{{ __('misi.misi_4') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!--======END Misi ======-->
    <div class="promo parallax promo-dark bg-color promo-full mb-5">
        <img src="{{ asset('css/templateweb/images/parallax/bg-contact.png') }}" class="parallax-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg">
                    <center>
                        <font size="10" color="white" face="Monaco"><span class="text-warning">Universitas
                                Batam</span> || Let's challenge the future!</span></font>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--====== END Promo ======-->

    {{-- Berita --}}
    <div class="heading-block mt-0 text-center">
        <h2 data-animate="swing">{{ __('home.campus_news') }}</h2>
    </div>
    <div class="container">

        <div class="post-grid row col-mb-30">
            @foreach ($news as $item)
                <div class="entry col-lg-4 col-md-6">
                    <div class="grid-inner shadow-sm card rounded-5">
                        <img src="{{ asset('storage/' . $item->image) }}"
                            alt="{{ $item->getTranslation('title', app()->getLocale()) }}" class="card-img-top">
                        <div class="p-4">
                            <div class="entry-title">
                                <h5 class="fw-medium text-danger mb-3">
                                    {{ $item->category ? $item->category->getTranslation('name', app()->getLocale()) : '' }}
                                </h5>
                                <h2 class="text-transform-none ls-0 h5" style="font-size:1rem;"><a
                                        href="#">{{ $item->getTranslation('title', app()->getLocale()) }}</a>
                                </h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="uil uil-schedule"></i> {{ $item->created_at->format('d M Y') }}</li>
                                    <li><i class="uil uil-user"></i> {{ $item->user ? $item->user->name : 'Admin' }}</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <!-- Berita -->

    <div class="promo parallax promo-dark bg-color promo-full mb-5">
        <img src="{{ asset('css/templateweb/images/parallax/bg-contact.png') }}" class="parallax-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg">
                    <h3>Ayo segera menjadi bagian dari <span class="text-warning">Keluarga Besar</span> Karta Mulia!
                    </h3>
                </div>
                <div class="col-12 col-lg-auto mt-4 mt-lg-0">
                    <a href="https://pendaftaran.univbatam.ac.id/registrasi/index.php" class="btn btn-lg btn-warning m-0"
                        style="color:#fffff">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <!--====== END Promo ======-->
    {{-- Facilies --}}
    <div class="container text-center">
        <h3 class="h1 fw-bold" data-animate="swing">{{ __('home.facilities') }}</h3>
    </div>
    <div>
        <div class="container">
            <div data-animate="fadeIn" data-delay="200" id="oc-events"
                class="owl-carousel events-carousel carousel-widget" data-margin="0" data-pagi="false" data-items="1"
                data-items-lg="2" data-items-xl="2" data-loop="true" data-autoplay="5000" data-speed="700">
                @foreach ($facilities as $item)
                    <div class="oc-item">
                        <article class="entry event p-3">
                            <div
                                class="grid-inner bg-contrast-0 row g-0 p-3 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
                                <div class="col-12 mb-md-0">
                                    <a href="#" class="entry-image">
                                        <img src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->getTranslation('name', app()->getLocale()) }}"
                                            class="rounded-2">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content justify-content-start align-items-start">
                                                <div class="badge bg-light text-dark rounded-pill">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 p-4 pt-0">
                                    <div class="entry-title nott">
                                        <h3><a
                                                href="{{ route('facility.detail', ['slug' => $item->slug]) }}">{{ $item->getTranslation('name', app()->getLocale()) }}</a>
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
