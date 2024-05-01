<div>
    <!-- =========== Hero Section End =========== -->
    <div class="relative bg-gradient-to-t from-slate-500/10 pb-80 pt-36 sm:pb-96">
        <div class="container">
            <div class="mx-auto text-center lg:w-11/12">
                <div>
                    <h1 class="mb-5 text-3xl/tight font-semibold sm:text-4xl/tight lg:text-5xl/tight">
                        Aplikasi
                        <span
                            class="relative z-0 after:absolute after:bottom-0 after:end-0 after:-z-10 after:h-4 after:w-full after:bg-green-500/50 md:after:h-6"
                        >
                            RENO
                        </span>
                        Dinas Sosial
                    </h1>
                    <p class="text-gray-500 sm:text-lg">
                        Sistem Informasi Rumah Data Terpadu Dinas Sosial Kabupaten Soppeng
                    </p>
                    <div class="mt-12 flex flex-wrap items-center justify-center gap-2">
                        <div class="flex items-center">
                            <img
                                src="{{ asset('images/logos/logo-soppeng-new.png') }}"
                                alt="logo-soppeng"
                                class="rounded-md px-4 py-2"
                                width="100"
                            />
                            {{-- <input type="text" id="email-input" name="email-input" placeholder="Your Name" --}}
                            {{-- class="w-full rounded border-gray-300 focus:border-gray-400 focus:ring-0 bg-white py-2 px-4"> --}}
                        </div>
                        <div class="flex items-center">
                            <img
                                src="{{ asset('images/logos/logo-dinsos-crop.png') }}"
                                alt="logo-dinsos"
                                class="rounded-md px-4 py-2"
                                width="200"
                            />
                        </div>
                    </div>

                    {{-- <div class="flex flex-wrap justify-center items-center gap-5 mt-5"> --}}
                    {{-- <div class="flex items-center gap-2"> --}}
                    {{-- <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" --}}
                    {{-- fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" --}}
                    {{-- stroke-linejoin="round"> --}}
                    {{-- <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path> --}}
                    {{-- <polyline points="22 4 12 14.01 9 11.01"></polyline> --}}
                    {{-- </svg> --}}
                    {{-- <p class="text-sm text-gray-700">Free 14-day Demo</p> --}}
                    {{-- </div> --}}
                    {{-- <div class="flex items-center gap-2"> --}}
                    {{-- <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" --}}
                    {{-- fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" --}}
                    {{-- stroke-linejoin="round"> --}}
                    {{-- <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path> --}}
                    {{-- <polyline points="22 4 12 14.01 9 11.01"></polyline> --}}
                    {{-- </svg> --}}
                    {{-- <p class="text-sm text-gray-700">No credit card needed</p> --}}
                    {{-- </div> --}}
                    {{-- <div class="flex items-center gap-2"> --}}
                    {{-- <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" --}}
                    {{-- fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" --}}
                    {{-- stroke-linejoin="round"> --}}
                    {{-- <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path> --}}
                    {{-- <polyline points="22 4 12 14.01 9 11.01"></polyline> --}}
                    {{-- </svg> --}}
                    {{-- <p class="text-sm text-gray-700">Free 14-day Demo</p> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="relative -mt-64 sm:-mt-80">
            <div class="hidden sm:block">
                <div
                    class="after:absolute after:-top-10 after:end-10 after:h-24 after:w-24 after:bg-[url('../images/pattern/dot5.svg')]"
                ></div>
                <div
                    class="before:absolute before:-bottom-10 before:start-10 before:h-24 before:w-24 before:bg-[url('../images/pattern/dot2.svg')]"
                ></div>
            </div>

            <div
                id="swiper_one"
                class="swiper w-5/6 rounded-md border-[10px] border-white bg-white shadow-lg"
                data-aos="fade-up"
                data-aos-duration="2000"
            >
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img
                            src="{{ asset('frontend/images/hero/dashboard-dark1.png') }}"
                            alt="dashboard-dark"
                            class="rounded-md"
                        />
                    </div>

                    <div class="swiper-slide">
                        <img
                            src="{{ asset('frontend/images/hero/dashboard.png') }}"
                            alt="dashboard"
                            class="rounded-md"
                        />
                    </div>

                    <div class="swiper-slide">
                        <img
                            src="{{ asset('frontend/images/hero/reno-penyaluran-rastra.png') }}"
                            alt="penyaluran-rastra"
                            class="rounded-md"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== Hero Section End =========== -->

    <!-- =========== feature Section Start =========== -->
    <section class="overflow-hidden">
        <div class="py-16 xl:py-24">
            <div class="container">
                <div class="text-center">
                    <span class="text-primary bg-primary/10 rounded-full px-3 py-1 text-sm font-medium">
                        Grafik Program Bantuan
                    </span>
                    <h1 class="mb-4 mt-3 text-3xl/tight font-medium">Lihat Data KPM Secara Cepat</h1>
                    <p class="text-gray-500">
                        Menampilkan data grafik Program Bantuan
                        <span class="text-primary">BPJS, RASTRA, BPNT, PKH, dan PPKS</span>
                    </p>
                </div>
                <div class="py-16 xl:pb-28 xl:pt-16">
                    <div class="grid-cols-1n grid items-center gap-6 lg:grid-cols-2">
                        <div class="order-2 lg:order-1 2xl:w-9/12" data-aos="fade-up" data-aos-duration="500">
                            <div class="bg-primary/10 flex h-12 w-12 items-center justify-center rounded-lg">
                                <svg
                                    class="text-primary h-7 w-7"
                                    viewBox="0 0 24 24"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M10.8226874,8.36941377 L12.7324324,9.82298668 C13.4112512,8.93113547 14.4592942,8.4 15.6,8.4 C17.5882251,8.4 19.2,10.0117749 19.2,12 C19.2,13.9882251 17.5882251,15.6 15.6,15.6 C14.5814697,15.6 13.6363389,15.1780547 12.9574041,14.4447676 L11.1963369,16.075302 C12.2923051,17.2590082 13.8596186,18 15.6,18 C18.9137085,18 21.6,15.3137085 21.6,12 C21.6,8.6862915 18.9137085,6 15.6,6 C13.6507856,6 11.9186648,6.9294879 10.8226874,8.36941377 Z"
                                            id="Combined-Shape"
                                            fill="currentColor"
                                            opacity="0.3"
                                        ></path>
                                        <path
                                            d="M8.4,18 C5.0862915,18 2.4,15.3137085 2.4,12 C2.4,8.6862915 5.0862915,6 8.4,6 C11.7137085,6 14.4,8.6862915 14.4,12 C14.4,15.3137085 11.7137085,18 8.4,18 Z"
                                            id="Oval-14-Copy"
                                            fill="currentColor"
                                        ></path>
                                    </g>
                                </svg>
                            </div>

                            <h1 class="mb-4 mt-6 text-3xl/tight font-medium">Real Time Data Update</h1>
                            <p class="text-gray-500">
                                Saat ini ada 5 Program Bantuan Sosial yang di tangani oleh Dinas Sosial Kabupaten
                                Soppeng. Yaitu Program BPJS, RASTRA, BPNT, PKH, dan PPKS
                            </p>
                        </div>

                        <div class="relative order-1 lg:order-2">
                            <div class="hidden sm:block">
                                <div
                                    class="after:absolute after:-end-8 after:-top-8 after:h-20 after:w-20 after:bg-[url('../images/pattern/dot2.svg')] 2xl:after:-end-8"
                                ></div>
                                <div
                                    class="before:absolute before:-bottom-8 before:-start-8 before:h-20 before:w-20 before:bg-[url('../images/pattern/dot5.svg')]"
                                ></div>
                            </div>
                            <div wire:poll.keep-alive>
                                {{ $chart->container() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =========== Stats Section Start =========== -->
        <section class="py-5 xl:py-10">
            <div class="container" data-aos="fade-up" data-aos-duration="600">
                <div class="text-center">
                    <span class="text-primary bg-primary/10 rounded-full px-3 py-1 text-sm font-medium">
                        Jumlah KPM Program Bantuan
                    </span>
                    <h2 class="my-5 text-xl font-semibold md:text-3xl">Data Statistik Program Bantuan Sosial</h2>
                    {{-- <p class="text-slate-500">Saat ini program bantuan pada Dinas Sosial berjumlah 5 Program.</p> --}}
                </div>

                <div class="mt-14 grid grid-cols-2 gap-6 py-16 md:grid-cols-3" data-aos="fade-up" wire:poll.keep-alive>
                    <div class="text-center">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['bpjs'], 0, locale: 'id') }} KPM</h4>
                        <p class="text-slate-600">Program BPJS</p>
                    </div>
                    <div class="text-center">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['rastra'], 0, locale: 'id') }} KPM</h4>
                        <p class="text-slate-600">Program RASTRA</p>
                    </div>
                    <div class="text-center">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['pkh'], 0, locale: 'id') }} KPM</h4>
                        <p class="text-slate-600">Program PKH</p>
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['bpnt'], 0, locale: 'id') }} KPM</h4>
                        <p class="text-slate-600">Program BPNT</p>
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['ppks'], 0, locale: 'id') }} KPM</h4>
                        <p class="text-slate-600">Program PPKS</p>
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="mb-3 text-5xl">{{ Number::format($bantuan['angka_kemiskinan'], 0, locale: 'id')
                        }} KPM</h4>
                        <p class="text-slate-600">Angka Kemiskinan</p>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- =========== feature Section end =========== -->
    @push('js')
        {!! $chart->script() !!}
    @endpush
</div>
