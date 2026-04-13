<!-- Header -->
<header id="header">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row justify-content-lg-between">

                <div id="logo" class="order-lg-2 col-auto px-0 me-lg-0">
                    <!-- Logo -->
                    @php
                        $logoPath = !empty($logo->logo)
                            ? (str_starts_with($logo->logo, 'images/')
                                ? asset($logo->logo)
                                : asset('storage/' . $logo->logo))
                            : asset('images/logo.png');
                    @endphp
                    <a href="{{ route('home') }}" class="logo text-decoration-none">
                        <img class="logo-default" height="73" src="{{ $logoPath }}" alt="Logo Karta Mulia">
                    </a>
                </div>
                <!-- #logo end -->

                <div class="header-misc d-flex d-lg-none">



                </div>

                <div class="primary-menu-trigger">
                    <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                        <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                    </button>
                </div>

                {{-- Primary Navigation --}}
                @include('layouts.navbar')

            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header>
<!-- #header end -->
