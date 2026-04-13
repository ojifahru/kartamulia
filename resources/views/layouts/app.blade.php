<!DOCTYPE html>

<html dir="ltr" lang="en-US">

<head>

    <title>@yield('title')</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="robots" content="index, follow">

    <meta name="description" content="{{ $identity->meta_description ?? 'Website resmi Karta Mulia.' }}">

    <meta name="keywords" content="{{ $identity->meta_keywords ?? 'karta mulia, universitas, pendidikan' }}">

    <meta name="author" content="Karta Mulia">

    <meta name="robots" content="all,index,follow">

    <meta http-equiv="Content-Language" content="id-ID">

    <meta NAME="Distribution" CONTENT="Global">

    <meta NAME="Rating" CONTENT="General">


    @php
        $faviconPath = !empty($logo->favicon)
            ? (str_starts_with($logo->favicon, 'images/')
                ? asset($logo->favicon)
                : asset('storage/' . $logo->favicon))
            : asset('images/favicon.png');
    @endphp
    <link rel="shortcut icon" href="{{ $faviconPath }}" />



    <!-- Font Imports -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=PT+Serif:ital@0;1&display=swap"
        rel="stylesheet">



    <!--====== Favicon Icon ======-->



    <!-- Core Style -->

    <link rel="stylesheet" href="{{ asset('css/templateweb/css/style.css') }}">



    <!-- Font Icons -->

    <link rel="stylesheet" href="{{ asset('css/templateweb/css/font-icons.css') }}">



    <!-- Plugins/Components CSS -->

    <link rel="stylesheet" href="{{ asset('css/templateweb/css/swiper.css') }}">



    <style>
        .block-card-9 .grid-inner .btn-hover {

            opacity: 0;

            display: block;

            transition: opacity .3s ease, transform .3s .1s ease;

            margin-top: 15px;

            position: absolute;

            transform: translateY(0);

        }

        .block-card-9 .grid-inner:hover .btn-hover {

            opacity: 1;

            transform: translateY(-5px);

        }



        .block-card-9 .grid-inner .grid-image {

            position: absolute;

            left: 0;

            top: 0;

            width: 100%;

            height: 100%;

            background-size: cover;

            background-position: center center;

        }



        .block-card-9 .grid-inner:hover .grid-image {

            -webkit-animation: kenburns 20s ease-out both;

            animation: kenburns 20s ease-out both;

        }



        .block-card-9 .grid-inner .grid-icon,

        .block-card-9 .grid-inner .grid-content {

            transition: transform .3s ease;

        }



        .block-card-9 .grid-inner:hover .grid-content {
            transform: translateY(-45px);
        }

        .block-card-9 .grid-inner:hover .grid-icon {
            transform: translateY(-5px);
        }



        @-webkit-keyframes kenburns {

            0% {

                -webkit-transform: scale(1) translate(0, 0);

                transform: scale(1) translate(0, 0);

                -webkit-transform-origin: 84% 84%;

                transform-origin: 84% 84%;

            }

            100% {

                -webkit-transform: scale(1.25) translate(20px, 15px);

                transform: scale(1.25) translate(20px, 15px);

                -webkit-transform-origin: right bottom;

                transform-origin: right bottom;

            }

        }

        @keyframes kenburns {

            0% {

                -webkit-transform: scale(1) translate(0, 0);

                transform: scale(1) translate(0, 0);

                -webkit-transform-origin: 84% 84%;

                transform-origin: 84% 84%;

            }

            100% {

                -webkit-transform: scale(1.25) translate(20px, 15px);

                transform: scale(1.25) translate(20px, 15px);

                -webkit-transform-origin: right bottom;

                transform-origin: right bottom;

            }

        }


        .widget-whatsapp {
            position: fixed;
            bottom: 16px;
            right: 60px;
            /*left:10px;*/
            background: #01C501;
            font-size: 40px;
            -webkit-border-radius: 999px;
            -moz-border-radius: 999px;
            border-radius: 999px;
            width: 60px;
            height: 60px;
            text-align: center;
            z-index: 99;
        }
    </style>

</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1YT6QB5Q7B"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-1YT6QB5Q7B');
</script>

<body class="stretched">



    <!-- Document Wrapper

 ============================================= -->

    <div id="wrapper">
        @include('layouts.topbar')
        @include('layouts.header')


        @yield('content')



        <!-- Footer-->

        <footer id="footer" class="dark">

            @include('layouts.footer')

        </footer><!-- #footer end -->



    </div><!-- #wrapper end -->





    <!-- Go To Top

 ============================================= -->

    <div id="gotoTop" class="uil uil-angle-up"></div>



    <!-- JavaScripts

 ============================================= -->



    <script src="{{ asset('css/templateweb/js/jquery.js') }}"></script>
    <script src="{{ asset('css/templateweb/js/functions.js') }}"></script>
    <script src="{{ asset('css/templateweb/js/plugins.jpaginate.js') }}"></script>


    <script>
        jQuery(document).ready(function($) {

            jQuery('.posts-container').pajinate({

                items_per_page: 6,

                item_container_id: '#posts',

                nav_panel_id: '.pagination-container ul',

                show_first_last: false

            });



            jQuery('.pagination a').click(function() {

                var t = setTimeout(function() {
                    jQuery('.flexslider .slide').resize();
                }, 1000);

            });

        });
    </script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id', // bahasa default websitemu
                includedLanguages: 'id,en', // bahasa yang kamu izinkan
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>






</body>

</html>
