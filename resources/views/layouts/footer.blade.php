<div class="container">
    <!-- Footer Widgets
    ============================================= -->
    <div class="footer-widgets-wrap">
        <div class="row col-mb-50">
            <div class="col-lg-8">
                <div class="row col-mb-50">
                    <div class="col-md-0">
                        <div class="widget">
                            @php
                                $footerLogoPath = !empty($logo->footer_logo)
                                    ? (str_starts_with($logo->footer_logo, 'images/')
                                        ? asset($logo->footer_logo)
                                        : asset('storage/' . $logo->footer_logo))
                                    : asset('images/logo.png');
                            @endphp
                            <div
                                style="background: url('{{ asset('css/templateweb/images/world-map.png') }}') no-repeat center center; background-size: 100%;">
                                <img src="{{ $footerLogoPath }}" alt="Footer Logo" class="footer-logo"
                                    height="150px">
                                <address>
                                    <strong>{{ $identity->name ?? 'Karta Mulia University' }}</strong><br>
                                    {{ $identity->address ?? '-' }} || <i class="fa fa-phone"
                                        style="color: #FFCC00"></i>
                                    {{ $identity->phone ?? '-' }}<br>
                                    <i class="fa fa-envelope" style="color: #FFCC00"></i>
                                    {{ $identity->email ?? '-' }}<br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <strong>Peta Lokasi</strong>
                <div class="google-maps">
                    <iframe src="{{ $identity->maps ?? 'https://maps.google.com' }}" width="600" height="450"
                        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copyrights
============================================= -->
<div id="copyrights">
    <div class="container">
        <div class="w-100 text-center">
            Copyrights &copy; {{ date('Y') }} All Rights Reserved by Karta Mulia.
        </div>
    </div>
</div><!-- #copyrights end -->

@php
    $message_wa = '&text=' . urlencode('Halo, Karta Mulia');
    $phone = $identity->whatsapp ?? '';
    $link_wa =
        $phone && request()->userAgent() && preg_match('/(android|iphone|mobile|tablet)/i', request()->userAgent())
            ? "https://api.whatsapp.com/send?phone={$phone}{$message_wa}"
            : ($phone
                ? "https://web.whatsapp.com/send?phone={$phone}{$message_wa}"
                : '#');
@endphp

<div class="widget-whatsapp" id="chatmobile">
    <a target="_blank" class="text-white" href="{{ $link_wa }}"
        @if (!$phone) aria-disabled="true" @endif>
        <i class="fa-brands fa-whatsapp" aria-hidden="true" style="font-size:40px;"></i>
    </a>
</div>
