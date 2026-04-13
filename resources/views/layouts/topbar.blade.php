<!-- Top Bar -->
<div id="top-bar" class="full-header transparent-header semi-transparent dark">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-auto">

                <!-- Top Links -->
                <div class="top-links on-click">
                    <ul class="top-links-container">
                        <li class="top-links-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                        <li class="top-links-item"><a href="#">{{ __('menu.registration') }}</a>
                            <ul class="top-links-sub-menu">
                                <li class="top-links-item"><a
                                        href="{{ route('registration.information') }}">{{ __('menu.information_registration') }}</a>
                                </li>
                                <li class="top-links-item"><a
                                        href="{{ route('registration.procedure') }}">{{ __('menu.registration_procedure') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="top-links-item"><a href="faqs.html">Lembaga</a>
                            <ul class="top-links-sub-menu">
                                <li class="top-links-item"><a href="https://lppm.univbatam.ac.id/"
                                        target="_blank">LPPM</a></li>
                                <li class="top-links-item"><a href="https://lpm.univbatam.ac.id/"
                                        target="_blank">LPM</a></li>
                                <!-- <li class="top-links-item"><a href="https://univbatam.ac.id/badanuik" >Badan UiK</a></li> -->
                            </ul>
                        </li>
                        <li class="top-links-item"><a href="index.html">Login</a>
                            <ul class="top-links-sub-menu">
                                <li class="top-links-item"><a href="https://akademik2.univbatam.ac.id/"
                                        target="_blank">Portal Pegawai</a></li>
                                <li class="top-links-item"><a href="https://dosen2.univbatam.ac.id/"
                                        target="_blank">Portal Dosen</a></li>
                                <li class="top-links-item"><a href="https://mahasiswa2.univbatam.ac.id/"
                                        target="_blank">Portal Mahasiswa</a></li>
                                <li class="top-links-item"><a href="https://kepk.univbatam.ac.id/"
                                        target="_blank">Portal KEPK</a></li>
                                <li class="top-links-item"><a href="https://repository.univbatam.ac.id/"
                                        target="_blank">Portal Repositori</a></li>
                                <li class="top-links-item"><a href="https://ejurnal.univbatam.ac.id/"
                                        target="_blank">Portal E-Jurnal</a></li>
                                <!-- <li class="top-links-item"><a href="http://ejurnal.univbatam.ac.id/index.php/pendekar" target="_blank">Portal JPN</a></li> -->
                                <li class="top-links-item"><a href="https://elearning.univbatam.ac.id/"
                                        target="_blank">Portal Spada</a></li>
                                <!-- <li class="top-links-item"><a href="http://103.124.196.69/estationery/" target="_blank">eStationary</a></li> -->
                                <li class="top-links-item"><a href="https://mhsbaru.univbatam.ac.id/"
                                        target="_blank">TPA Calon MaBa</a></li>
                            </ul>
                        </li>
                        {{-- Language switcher --}}
                        <li class="top-links-item">
                            <a href="#" class="language-switcher">{{ __('home.lang') }}</a>
                            <ul class="top-links-sub-menu">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li class="top-links-item">
                                        {{-- Use LaravelLocalization::getLocalizedURL to generate the localized URL --}}
                                        <a rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </div><!-- .top-links end -->

            </div>

            <div class="col-12 col-md-auto">

                <!-- Top Social -->
                <ul id="top-social">
                    <li><a href="#" class="h-bg-facebook"><span class="ts-icon"><i
                                    class="fa-brands fa-facebook-f"></i></span><span
                                class="ts-text">universitasbatamofficial</span></a></li>
                    <!-- <li><a href="#" class="h-bg-twitter"><span class="ts-icon"><i class="fa-brands fa-twitter"></i></span><span class="ts-text">Twitter</span></a></li> -->
                    <li><a href="#" class="h-bg-instagram"><span class="ts-icon"><i
                                    class="fa-brands fa-instagram"></i></span><span
                                class="ts-text">universitasbatam.Karta Mulia</span></a></li>
                    <li><a href="tel:+627787485055" class="h-bg-call"><span class="ts-icon"><i
                                    class="fa-solid fa-phone"></i></span><span class="ts-text">0778
                                7485055</span></a></li>
                    <li><a href="mailto:info@univbatam.ac.id" class="h-bg-email3"><span class="ts-icon"><i
                                    class="fa-solid fa-envelope"></i></span><span
                                class="ts-text">info@univbatam.ac.id</span></a></li>
                </ul><!-- #top-social end -->

            </div>
            <!-- <div id="google_translate_element"></div> -->

        </div>

    </div>
</div>
<!-- #top-bar end -->
