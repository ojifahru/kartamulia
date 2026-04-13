@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <section class="page-title page-title-mini">
        <div class="container">
            <div class="page-title-row">
                <div class="page-title-content">
                    <h1>{{ $pageTitle }}</h1>
                </div>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('facilities.home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section id="content">
        <div class="content-wrap">
            <div class="container">

                <div class="row gx-5 col-mb-80">
                    <!-- Postcontent -->

                    <main class="postcontent col-lg-9">

                        <iframe src="{{ $identity->maps }}" width="600" height="450" style="border:0;"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </main><!-- .postcontent end -->
                    <!-- Sidebar -->
                    <aside class="sidebar col-lg-3">

                        <address>
                            <strong>Karta Mulia</strong><br>
                            {{ $identity->address }}<br>
                        </address>
                        <abbr title="Phone Number"><strong>Phone:</strong></abbr> {{ $identity->phone }}<br>
                        <abbr title="Email Address"><strong>Email:</strong></abbr> {{ $identity->email }}
                    </aside><!-- .sidebar end -->
                </div>

            </div>
        </div>
    </section><!-- #content end -->
@endsection
