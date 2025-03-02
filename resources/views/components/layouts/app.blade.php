<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>{{ $title ?? 'Utama' }} | {{ config('custom.app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Sistem Aplikasi Rumah Terpadu Dinas Sosial Kabupaten Soppeng" name="description" />
        <meta content="reno" name="dinsos" />
        @livewireStyles
        <!-- Theme favicon -->
        <link rel="shortcut icon" href="{{ asset('images/reno/reno-dinsos-favicon-color.png') }}" />

        <!--Swiper slider css-->
        <link href="{{ asset('frontend/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Animation on Scroll css -->
        <link href="{{ asset('frontend/libs/aos/aos.css') }}" rel="stylesheet" type="text/css" />

        <!-- Style css -->
        <link href="{{ asset('frontend/css/style.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Icons css -->
        <link href="{{ asset('frontend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body class="text-gray-700">
        <!-- =========== Navbar Start =========== -->
        <header
            id="navbar"
            class="light fixed inset-x-0 top-0 z-40 flex w-full items-center bg-white py-5 transition-all lg:bg-transparent"
        >
            <div class="container">
                <nav class="flex items-center">
                    <!-- Navbar Brand Logo -->
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('images/reno/svg/logo-no-background.svg') }}" class="logo-dark h-10" alt="Logo Dark" />
                        <img
                            src="{{ asset('images/reno/svg/logo-no-background.svg') }}"
                            class="logo-light h-10"
                            alt="Logo Light"
                        />
                    </a>

                    <!-- Nevigation Menu -->
                    <div class="ms-auto hidden lg:block"></div>

                    <!-- Download Button -->
                    @if (Route::has('filament.admin.auth.login'))
                        <div class="ms-3 hidden items-center lg:flex">
                            @auth
                                <a
                                    href="{{ route('filament.admin.pages.dashboard') }}"
                                    class="bg-primary inline-flex items-center rounded px-4 py-2 text-sm text-white"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('filament.admin.auth.login') }}"
                                    class="bg-primary inline-flex items-center rounded px-4 py-2 text-sm text-white"
                                >
                                    Masuk
                                </a>

                                @if (Route::has('filament.admin.auth.register'))
                                    <a
                                        href="{{ route('filament.admin.auth.register') }}"
                                        class="bg-primary inline-flex items-center rounded px-4 py-2 text-sm text-white"
                                    >
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <!-- Moblie Menu Toggle Button (Offcanvas Button) -->
                    <div class="ms-auto flex items-center px-2.5 lg:hidden">
                        <button type="button" data-fc-target="mobileMenu" data-fc-type="offcanvas">
                            <i class="fa-solid fa-bars text-2xl text-gray-500"></i>
                        </button>
                    </div>
                </nav>
            </div>
        </header>
        <!-- =========== Navbar End =========== -->

        <!-- =========== Mobile Menu Start (Offcanvas) =========== -->
        <div
            id="mobileMenu"
            class="fc-offcanvas-open:translate-x-0 fixed end-0 top-0 z-50 hidden h-full w-full max-w-md translate-x-full transform border-s bg-white transition-all duration-200"
        >
            <div class="flex h-full flex-col divide-y-2 divide-gray-200">
                <!-- Mobile Menu Topbar Logo (Header) -->
                <div class="flex items-center justify-between p-6">
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('images/reno/svg/logo-no-background.svg') }}" class="h-8" alt="Logo" />
                    </a>

                    <button data-fc-dismiss class="flex items-center px-2">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Menu Download Button (Footer) -->
                @if (Route::has('filament.admin.auth.login'))
                    <div class="flex items-center justify-center p-6">
                        @auth
                            <a
                                href="{{ route('filament.admin.pages.dashboard') }}"
                                class="bg-primary flex w-full items-center justify-center rounded p-3 text-sm text-white"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('filament.admin.auth.login') }}"
                                class="bg-primary flex w-full items-center justify-center rounded p-3 text-sm text-white"
                            >
                                Masuk
                            </a>

                            @if (Route::has('filament.admin.auth.register'))
                                <a
                                    href="{{ route('filament.admin.auth.register') }}"
                                    class="bg-primary flex w-full items-center justify-center rounded p-3 text-sm text-white"
                                >
                                    Daftar
                                </a>
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
        <footer class="pb-6 pt-10">
            <div class="border-b"></div>

            <div class="container">
                <div class="mt-10 text-center">
                    <p class="mb-7 text-gray-600">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        © RENO DINSOS. All rights reserved. Dibuat Oleh
                        <a
                            href="https://github.com/hanzo-alpha"
                            target="_blank"
                            class="hover:text-primary text-gray-800 transition-all"
                        >
                            Tim IT DINSOS
                        </a>
                    </p>

                    <ul class="mb-8 flex flex-wrap items-center justify-center gap-10">
                        <li>
                            <a href="https://github.com/hanzo-alpha/simdata-sosial/compare/v0.1.35...v0.1.36">
                                Changelog
                            </a>
                        </li>
                        <li>
                            <a href="#">FAQ</a>
                        </li>
                        <li>
                            <a href="#">Kontak Kami</a>
                        </li>
                    </ul>
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('images/reno/svg/logo-no-background.svg') }}" class="mx-auto h-8" alt="logo brand" />
                    </a>
                </div>
            </div>
        </footer>
        <!-- =========== footer Section end =========== -->

        <!-- =========== Back To Top Start =========== -->
        <button
            data-toggle="back-to-top"
            class="bg-primary/20 text-primary fixed bottom-5 end-5 z-10 flex h-9 w-9 items-center justify-center rounded-full text-center text-sm"
        >
            <i class="fa-solid fa-arrow-up text-base"></i>
        </button>
        <!-- =========== Back To Top End =========== -->
        @livewireScriptConfig
        <!-- Frost Plugin Js -->
        <script src="{{ asset('frontend/libs/@frostui/tailwindcss/frostui.js') }}" type="text/javascript"></script>

        <!-- Swiper Plugin Js -->
        <script src="{{ asset('frontend/libs/swiper/swiper-bundle.min.js') }}" type="text/javascript"></script>

        <!-- Animation on Scroll Plugin Js -->
        <script src="{{ asset('frontend/libs/aos/aos.js') }}" type="text/javascript"></script>

        <!-- Theme Js -->
        <script src="{{ asset('frontend/js/theme.min.js') }}" type="text/javascript"></script>

        @production
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            @else
                @apexchartsScripts
                @endproduction

        @stack('js')
    </body>
</html>
