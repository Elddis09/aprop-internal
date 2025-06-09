@extends('layouts.header')

@section('title', 'Beranda | APROP')

@section('content')

@include('layouts.navbar')

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

<!-- FAQ Section -->
<section>
    <div class="pt-0 px-5 pb-5">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4 class="fw-bold">FAQ – Pengajuan Proposal di Website Aprop KONI Kota Bandung</h4>
                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Apa itu Aprop KONI Kota Bandung?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aprop (Ajuan Proposal) KONI Kota Bandung adalah platform digital resmi yang digunakan untuk mengelola pengajuan proposal dari cabang olahraga, klub, atau individu yang ingin mendapatkan dukungan dari KONI Kota Bandung.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Siapa saja yang bisa mengajukan proposal melalui Aprop?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Semua cabang olahraga, klub resmi, dan individu yang telah terdaftar dan diakui oleh KONI Kota Bandung dapat mengajukan proposal melalui platform ini.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana cara mengajukan proposal di website Aprop?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Berikut langkah-langkahnya:<br>
                                1. Buka website aprop.konikotabandung.or.id<br>
                                2. Login menggunakan akun yang sudah terdaftar<br>
                                3. Klik menu “Ajukan Proposal”<br>
                                4. Isi formulir yang tersedia dan unggah dokumen proposal (PDF)<br>
                                5. Klik “Kirim”<br>
                                6. Anda akan menerima notifikasi email sebagai tanda konfirmasi
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Apakah ada format khusus untuk proposal?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, Anda harus mengikuti format proposal yang telah ditentukan oleh KONI Kota Bandung. Format tersebut bisa diunduh di halaman utama Aprop atau di bagian panduan pengajuan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Bagaimana jika saya belum memiliki akun?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda bisa mendaftar terlebih dahulu melalui menu “Daftar Akun” di halaman utama Aprop. Pastikan data yang dimasukkan sesuai dan valid.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Apakah bisa mengedit proposal setelah dikirim?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tidak. Setelah proposal dikirim, Anda tidak bisa mengeditnya. Pastikan semua data benar sebelum menekan tombol “Kirim”.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Berapa lama waktu proses peninjauan proposal?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Waktu peninjauan proposal biasanya memakan waktu 7–14 hari kerja. Anda dapat memantau status proposal melalui dashboard akun Anda.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Kepada siapa saya bisa menghubungi jika mengalami kendala teknis?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda bisa menghubungi tim teknis melalui email: support@aprop.konikotabandung.or.id atau melalui kontak WhatsApp yang tertera di halaman kontak website.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNine">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                Apakah proposal bisa diajukan lebih dari satu kali dalam setahun?
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bisa, sesuai dengan kebijakan dan periode pengajuan yang ditentukan oleh KONI Kota Bandung. Silakan cek kalender kegiatan di website.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                Apakah ada biaya untuk mengajukan proposal?
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tidak. Pengajuan proposal melalui Aprop KONI Kota Bandung gratis dan tidak dipungut biaya apapun.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@include('layouts.footer')

@endsection
