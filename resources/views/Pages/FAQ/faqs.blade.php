@extends('layouts.header')

@section('title', 'Beranda | APROP')

@section('content')

@include('layouts.navbar')

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
        </div>
        <p>Please wait...</p>
    </div>
</div>

<!-- FAQ Section -->
<section>
    <div class="pt-0 px-5 pb-5">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4 class="fw-bold">FAQ – Pelacakan Proposal di Website Aprop KONI Kota Bandung</h4>
                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Apa itu Aprop KONI Kota Bandung?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aprop (Ajuan Proposal) KONI Kota Bandung adalah platform digital resmi yang digunakan untuk mengelola pengajuan proposal dari cabang olahraga, klub, atau individu yang ingin mendapatkan dukungan dari KONI Kota Bandung. Sebagai pengguna, Anda dapat memantau status proposal yang telah diajukan melalui sistem ini.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Siapa saja yang bisa melacak proposal melalui Aprop?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Semua cabang olahraga, klub resmi, dan individu yang telah mengajukan proposal melalui front office KONI Kota Bandung akan diberikan tanda terima yang berisi link atau barcode untuk melacak status proposal mereka.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana cara melacak status proposal di website Aprop?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat melacak status proposal Anda dengan salah satu cara berikut: <br>

                                1. Melalui link: Klik link yang tertera pada tanda terima pengajuan proposal Anda. Anda akan langsung diarahkan ke halaman status proposal Anda tanpa perlu login. <br>
                                2. Melalui barcode: Scan barcode yang ada pada tanda terima menggunakan aplikasi pemindai barcode di smartphone Anda. Anda akan langsung diarahkan ke halaman status proposal Anda
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Apakah saya perlu memiliki akun untuk melacak proposal?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tidak, Anda tidak perlu memiliki akun untuk melacak status proposal Anda. Cukup gunakan link atau barcode yang Anda dapatkan pada tanda terima dari front office.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Berapa lama waktu proses peninjauan proposal?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Waktu peninjauan proposal biasanya memakan waktu 7–14 hari kerja. Anda dapat memantau status proposal Anda secara langsung melalui link atau barcode yang Anda miliki.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Mengapa status proposal saya belum berubah?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Perubahan status proposal bergantung pada tahapan peninjauan internal KONI Kota Bandung. Jika status proposal Anda belum berubah setelah waktu yang wajar (misalnya, lebih dari 14 hari kerja), Anda dapat menghubungi front office KONI Kota Bandung untuk menanyakan perkembangannya.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Kepada siapa saya bisa menghubungi jika mengalami kendala teknis saat melacak proposal?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda bisa menghubungi tim teknis melalui email: contact@koni-kotabandung.or.id atau melalui kontak WhatsApp yang tertera di halaman kontak website.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Apakah saya bisa mendapatkan detail lebih lanjut mengenai keputusan proposal yang sudah selesai ditinjau?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Untuk detail lebih lanjut mengenai keputusan proposal (diterima, ditolak, atau memerlukan revisi), silakan hubungi front office KONI Kota Bandung atau pihak yang terkait dengan peninjauan proposal Anda. Informasi tersebut akan diberikan secara langsung kepada Anda.
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