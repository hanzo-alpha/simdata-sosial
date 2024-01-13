<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>{{ $title ?? 'Home' }} | {{ config('custom.app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        content="A fully responsive Tailwind CSS Multipurpose agency, application, business, clean, creative, cryptocurrency, it solutions, startup, career, blog, modern, creative, multipurpose, portfolio, saas, software, tailwind css, etc."
        name="description"/>
    <meta content="coderthemes" name="author"/>

    <!-- Theme favicon -->
    <link rel="shortcut icon" href="{{ asset('logo-white.png') }}">
    {{--    <link rel="shortcut icon" href="{{ asset('favicon-white.png') }}">--}}

    <!--Swiper slider css-->
    <link href="{{ asset('frontend/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Animation on Scroll css -->
    <link href="{{ asset('frontend/libs/aos/aos.css') }}" rel="stylesheet" type="text/css">

    <!-- Style css -->
    <link href="{{ asset('frontend/css/style.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{ asset('frontend/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    @livewireStyles
</head>
<body class="text-gray-700">

<!-- =========== Navbar Start =========== -->
<header id="navbar"
        class="light fixed top-0 inset-x-0 flex items-center z-40 w-full lg:bg-transparent bg-white transition-all py-5">
    <div class="container">
        <nav class="flex items-center">
            <!-- Navbar Brand Logo -->
            <a href="{{ route('frontend') }}">
                <img src="{{ asset('images/logos/logo-color.png') }}"
                     class="h-10 logo-dark" alt="Logo Dark">
                <img src="{{ asset('images/logos/logo-color.png') }}"
                     class="h-10 logo-light"
                     alt="Logo Light">
            </a>

            <!-- Nevigation Menu -->
            <div class="hidden lg:block ms-auto"></div>

            <!-- Download Button -->
            @if (Route::has('filament.admin.auth.login'))
                <div class="hidden lg:flex items-center ms-3">
                    @auth
                        <a href="{{ route('filament.admin.pages.dashboard') }}"
                           class="bg-primary text-white px-4 py-2 rounded inline-flex items-center
                           text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}"
                           class="bg-primary text-white px-4 py-2 rounded inline-flex items-center text-sm">Masuk</a>

                        @if (Route::has('filament.admin.auth.register'))
                            <a href="{{ route('filament.admin.auth.register') }}"
                               class="bg-primary text-white px-4 py-2 rounded inline-flex items-center
                               text-sm">Daftar</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Moblie Menu Toggle Button (Offcanvas Button) -->
            <div class="lg:hidden flex items-center ms-auto px-2.5">
                <button type="button" data-fc-target="mobileMenu" data-fc-type="offcanvas">
                    <i class="fa-solid fa-bars text-2xl text-gray-500"></i>
                </button>
            </div>
        </nav>
    </div>
</header>
<!-- =========== Navbar End =========== -->

<!-- =========== Mobile Menu Start (Offcanvas) =========== -->
<div id="mobileMenu"
     class="fc-offcanvas-open:translate-x-0 translate-x-full fixed top-0 end-0 transition-all duration-200 transform h-full w-full max-w-md z-50 bg-white border-s hidden">
    <div class="flex flex-col h-full divide-y-2 divide-gray-200">
        <!-- Mobile Menu Topbar Logo (Header) -->
        <div class="p-6 flex items-center justify-between">
            <a href="{{ route('frontend') }}">
                <img src="{{ asset('images/logos/logo-color.png') }}" class="h-8"
                     alt="Logo">
            </a>

            <button data-fc-dismiss class="flex items-center px-2">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Download Button (Footer) -->
        @if (Route::has('filament.admin.auth.login'))
            <div class="p-6 flex items-center justify-center">
                @auth
                    <a href="{{ url('/app') }}"
                       class="bg-primary w-full text-white p-3 rounded flex items-center
                        justify-center text-sm">
                        App
                    </a>
                @else
                    <a href="{{ route('filament.admin.auth.login') }}"
                       class="bg-primary w-full text-white p-3 rounded flex items-center justify-center text-sm">Masuk</a>

                    @if (Route::has('filament.admin.auth.register'))
                        <a href="{{ route('filament.admin.auth.register') }}"
                           class="bg-primary w-full text-white p-3 rounded flex items-center justify-center text-sm">Daftar</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
<!-- =========== Mobile Menu End =========== -->

<!-- =========== Hero Section Start =========== -->
{{ $slot }}

<!-- =========== about Section End =========== -->

<!-- =========== footer Section Start =========== -->
<footer class="pt-10 pb-6">
    <div class="border-b"></div>

    <div class="container">
        <div class="text-center mt-10">
            <p class="text-gray-600 mb-7">
                <script>document.write(new Date().getFullYear())</script>
                © RENO. All rights reserved. Dibuat Oleh
                <a href="https://github.com/hanzo-alpha"
                   target="_blank"
                   class="text-gray-800 hover:text-primary transition-all">
                    Tim IT DINSOS
                </a>
            </p>

            <ul class="flex flex-wrap items-center justify-center gap-10 mb-8">
                <li>
                    <a href="https://github.com/hanzo-alpha/simdata-sosial/compare/v0.1.35...v0.1.36">Changelog</a>
                </li>
                <li>
                    <a href="#">FAQ</a>
                </li>
                <li>
                    <a href="#">Kontak Kami</a>
                </li>
            </ul>
            <a href="{{ route('frontend') }}">
                <img src="{{ asset('images/logos/logo-color.png') }}" class="h-8
                mx-auto" alt="logo brand">
            </a>
        </div>
    </div>

</footer>
<!-- =========== footer Section end =========== -->

<!-- =========== Back To Top Start =========== -->
<button data-toggle="back-to-top"
        class="fixed text-sm rounded-full z-10 bottom-5 end-5 h-9 w-9 text-center bg-primary/20 text-primary flex justify-center items-center">
    <i class="fa-solid fa-arrow-up text-base"></i>
</button>
<!-- =========== Back To Top End =========== -->
@livewireScripts
<!-- Frost Plugin Js -->
<script src="{{ asset('frontend/libs/@frostui/tailwindcss/frostui.js') }}" type="text/javascript"></script>

<!-- Swiper Plugin Js -->
<script src="{{ asset('frontend/libs/swiper/swiper-bundle.min.js') }}" type="text/javascript"></script>

<!-- Animation on Scroll Plugin Js -->
<script src="{{ asset('frontend/libs/aos/aos.js') }}" type="text/javascript"></script>

<!-- Theme Js -->
<script src="{{ asset('frontend/js/theme.min.js') }}" type="text/javascript"></script>

@apexchartsScripts
@stack('js')
</body>
</html>
