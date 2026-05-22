<div>
    <!-- =========== Hero Section End =========== -->
    <div class="relative bg-gradient-to-b from-yellow-50/80 pt-36 pb-80 sm:pb-96">
        <div class="container">
            <div class="mx-auto text-center lg:w-11/12">
                <div>
                    <h1 class="mb-5 text-3xl/tight font-semibold sm:text-4xl/tight lg:text-5xl/tight">
                        Aplikasi
                        <span
                            class="relative z-0 after:absolute after:end-0 after:bottom-0 after:-z-10 after:h-4 after:w-full after:bg-green-500/50 md:after:h-6"
                        >
                            RENO
                        </span>
                        Dinas Sosial
                    </h1>
                    <p class="text-gray-500 sm:text-lg">
                        Sistem Informasi Rumah Data Terpadu Dinas Sosial Kabupaten Soppeng. Dibuat untuk mempermudah
                    </p>

                    <div>
                        <!-- Redesigned Landing (Tailwind 4) -->
                        <header class="bg-linear-to-b from-yellow-50/60 to-white/60 py-20">
                            <div class="container mx-auto px-4 text-center">
                                <h1 class="text-4xl font-extrabold text-slate-900 sm:text-5xl">
                                    RENO — Sistem Informasi Dinas Sosial
                                </h1>
                                <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">
                                    Rumah Data Terpadu untuk mempermudah monitoring dan penyaluran bantuan sosial di
                                    Kabupaten Soppeng.
                                </p>

                                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                                    @if (Route::has('login'))
                                        <a
                                            href="{{ route('login') }}"
                                            class="bg-primary inline-flex items-center gap-2 rounded-md px-6 py-3 text-white shadow"
                                        >
                                            Masuk
                                        </a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="border-primary text-primary inline-flex items-center gap-2 rounded-md border px-6 py-3"
                                        >
                                            Daftar
                                        </a>
                                    @endif

                                    @if (Route::has('pdf.download'))
                                        <a
                                            href="{{ route('pdf.download') }}"
                                            class="text-primary inline-flex items-center gap-2 rounded-md bg-white px-6 py-3 shadow"
                                        >
                                            Unduh Dokumen
                                        </a>
                                    @endif
                                </div>

                                <div class="mt-10 flex items-center justify-center gap-8">
                                    <img
                                        src="{{ asset('images/logos/logo-soppeng-new.png') }}"
                                        alt="logo-soppeng"
                                        class="h-12"
                                    />
                                    <img
                                        src="{{ asset('images/logos/logo-dinsos-crop.png') }}"
                                        alt="logo-dinsos"
                                        class="h-14"
                                    />
                                </div>
                            </div>
                        </header>

                        <main class="py-16">
                            <div class="container mx-auto px-4">
                                <!-- Features -->
                                <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                    <div class="rounded-lg border bg-white p-6 text-center shadow">
                                        <h3 class="text-lg font-semibold">Akses Multi-User</h3>
                                        <p class="mt-2 text-sm text-slate-600">
                                            Role instansi, kelurahan, dan admin untuk pengelolaan data.
                                        </p>
                                    </div>
                                    <div class="rounded-lg border bg-white p-6 text-center shadow">
                                        <h3 class="text-lg font-semibold">Lima Program Bantuan</h3>
                                        <p class="mt-2 text-sm text-slate-600">
                                            BPJS, RASTRA, BPNT, PKH, PPKS serta indikator kemiskinan.
                                        </p>
                                    </div>
                                    <div class="rounded-lg border bg-white p-6 text-center shadow">
                                        <h3 class="text-lg font-semibold">Laporan & Berita Acara</h3>
                                        <p class="mt-2 text-sm text-slate-600">
                                            Cetak laporan dan berita acara penyaluran secara cepat.
                                        </p>
                                    </div>
                                </section>

                                <!-- Chart / Statistics -->
                                <section class="mt-12 grid grid-cols-1 items-center gap-8 lg:grid-cols-2">
                                    <div class="rounded-lg border bg-white p-6 shadow">
                                        <h4 class="text-md font-semibold">Statistik Program</h4>
                                        <div class="mt-4">
                                            <div wire:poll.keep-alive>
                                                {{ $chart->container() }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-lg border bg-white p-6 shadow">
                                        <h4 class="text-md font-semibold">Ringkasan Cepat</h4>
                                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                                            <li>
                                                Jumlah KPM:
                                                <strong>{{ number_format($kpmCount ?? 0) }}</strong>
                                            </li>
                                            <li>
                                                Transaksi Terakhir:
                                                <strong>{{ $lastDistributionAt ?? '-' }}</strong>
                                            </li>
                                            <li>
                                                Data Kelurahan:
                                                <strong>{{ $kelurahanCount ?? 0 }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </section>

                                <!-- CTA -->
                                <section class="mt-12 text-center">
                                    <p class="text-slate-600">
                                        Butuh bantuan atau ingin melihat demo? Hubungi tim pengembang.
                                    </p>
                                    <div class="mt-4">
                                        <a
                                            href="mailto:it@dinsos.soppeng.go.id"
                                            class="bg-primary inline-block rounded-md px-6 py-3 text-white"
                                        >
                                            Hubungi Kami
                                        </a>
                                    </div>
                                </section>
                            </div>
                        </main>

                        <footer class="border-t bg-white py-6">
                            <div class="container mx-auto px-4 text-center text-sm text-slate-500">
                                © {{ date('Y') }} DINAS SOSIAL KAB. SOPPENG
                            </div>
                        </footer>
                    </div>
                    class="swiper w-5/6 rounded-md border-[10px] border-white bg-white shadow-lg"
                </div>
            </div>
        </div>
    </div>
</div>
