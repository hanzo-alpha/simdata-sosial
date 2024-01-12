<div>
    <section class="bg-gradient-to-t from-yellow-50/80 relative">
        <section class="relative py-16 sm:py-24 md:py-44">
            <div class="container">
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-16 items-center">
                    <div class="relative 2xl:w-[128%]">
                        <h1 class="text-3xl/tight sm:text-4xl/tight lg:text-5xl/tight font-semibold mb-7">Aplikasi
                            Rumah Data
                            <span
                                class="relative z-0 after:bg-yellow-200 after:-z-10 after:absolute after:h-6 after:w-full
                             after:bottom-0 after:end-0">Terpadu Dinas Sosial</span>
                            Kabupaten Soppeng
                        </h1>
                        <p class="text-gray-500">
                            Sistem informasi managemen bantuan sosial pada Dinas Sosial Kabupaten Soppeng
                        </p>
                        <div class="absolute bottom-10 inset-x-9 hidden sm:block">
                            <img src="{{ asset('images/logos/logo-soppeng2.png') }}" alt="logo-soppeng"
                                 class="w-16 h-16" data-aos="fade-left" data-aos-duration="600">
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div class="relative 2xl:w-[128%]">
                            <div
                                class="before:w-28 before:h-28 sm:before:absolute before:-z-10 before:-bottom-8 before:-start-8 before:bg-[url('../images/pattern/dot3.svg')] hidden sm:block"></div>

                            <img src="{{ asset('frontend/images/hero/dashboard1.png') }}" alt="desktop-img"
                                 class="w-full h-full bg-white p-2 rounded-lg shadow-lg shadow-black/5"
                                 data-aos="fade-left"
                                 data-aos-duration="600">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="absolute bottom-0 inset-x-0 hidden sm:block">
            <img src="{{ asset('frontend/images/shapes/white-wave.svg') }}" alt="svg"
                 class="w-full -scale-x-100 -scale-y-100">
        </div>
    </section>
    <!-- =========== Hero Section End =========== -->

    <section class="py-16">
        <div class="container">
            <div class="text-center">
                <span class="text-sm font-medium py-1 px-3 rounded-full text-primary bg-primary/10">Diagram
                    Program Bantuan</span>
                <h2 class="md:text-3xl text-xl font-semibold my-5">Diagram Statistik Program Bantuan</h2>
                <p class="text-slate-500">Saat ini program bantuan pada Dinas Sosial berjumlah 5 Program.</p>
            </div>
            <div class="grid xl:grid-cols-1 grid-cols-1 items-center" data-aos="fade-up">
                <div class="pt-12">
                    {{ $chart->container() }}
                </div>
            </div>
        </div>
    </section>

    <!-- =========== about Section Start =========== -->
    <section class="py-20">
        <div class="container">
            <div class="text-center">
                <span class="text-sm font-medium py-1 px-3 rounded-full text-primary bg-primary/10">Jumlah KPM
                    Program Bantuan</span>
                <h2 class="md:text-3xl text-xl font-semibold my-5">Jumlah Keluarga Penerima Manfaat (KPM)</h2>
                <p class="text-slate-500">Saat ini program bantuan pada Dinas Sosial berjumlah 5 Program.</p>
            </div>

            <div class="grid md:grid-cols-5 grid-cols-2 mt-14 gap-5" data-aos="fade-up" wire:poll="10s">
                {{--                @foreach($jenisBantuan as $bantuan)--}}
                {{--                        <div class="text-center" wire:poll="20s">--}}
                {{--                            <h4 class="text-5xl mb-3 ">{{ rand(200,1000) }}</h4>--}}
                {{--                            <p class="text-slate-600">Program {{ $bantuan->alias }}</p>--}}
                {{--                        </div>--}}
                {{--                @endforeach--}}

                <div class="text-center">
                    <h4 class="text-5xl mb-3 ">{{ $bantuan['bpjs'] }}</h4>
                    <p class="text-slate-600">Program BPJS</p>
                </div>
                <div class="text-center">
                    <h4 class="text-5xl mb-3 ">{{ $bantuan['rastra'] }}</h4>
                    <p class="text-slate-600">Program RASTRA</p>
                </div>
                <div class="text-center">
                    <h4 class="text-5xl mb-3 ">{{ $bantuan['pkh'] }}</h4>
                    <p class="text-slate-600">Program PKH</p>
                </div>
                <div class="text-center">
                    <h4 class="text-5xl mb-3 ">{{ $bantuan['bpnt'] }}</h4>
                    <p class="text-slate-600">Program BPNT</p>
                </div>
                <div class="text-center">
                    <h4 class="text-5xl mb-3 ">{{ $bantuan['ppks'] }}</h4>
                    <p class="text-slate-600">Program PPKS</p>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        {!! $chart->script() !!}
    @endpush
</div>
