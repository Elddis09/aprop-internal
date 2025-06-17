@extends('layouts.header')
@section('title', 'Beranda | APROP')

<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
        </div>
        <p>Please wait...</p>
    </div>
</div>

<section class="hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                <div class="hero-content">
                    <h1 class="display-5 fw-bold mb-3">Lacak Status Proposal Anda dengan Mudah</h1>
                    <p class="lead mb-4">Dapatkan Informasi Terikni Mengenai Proposal Yang Telah Anda Ajukan Melalui Front Office KONI Kota Bandung.</p>
                    <a href="{{ url('/faqs') }}" class="btn btn-start btn-lg">Lacak Proposal Anda</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 text-center">
                <div class="hero-image">
                    <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features py-5" id="about">
    <div class="container">
        <h2 class="display-6 fw-bold mb-4">Lacak Setiap Proposal Anda dengan Mudah melalui Aprop!</h2>
        <p class="lead mb-5">Aprop adalah platform yang dirancang untuk mempermudah pemohon dalam melacak status proposal mereka yang diajukan ke KONI Kota Bandung. Kami menawarkan solusi efisien agar anda dapat memantau setiap tahapan proposal secara online, memastikan informasi terkini selalu tersedia dengan mudah.</p>

        <div class="row align-items-center mt-4">
            <div class="col-lg-6 col-md-12 text-center mb-4 mb-lg-0">
                <img src="{{ asset('assets/images/about.png') }}" class="img-fluid" alt="Proposal Image" style="max-width: 80%;">
            </div>
            <div class="col-lg-6 col-md-12">
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3"><i class="bi bi-check-circle me-2"></i> Cek Status Proposal</li>
                    <li class="d-flex align-items-center mb-3"><i class="bi bi-check-circle me-2"></i> Pembaruan Status Proposal Secara Berkala</li>
                    <li class="d-flex align-items-center mb-3"><i class="bi bi-check-circle me-2"></i> Riwayat Status Proposal Lengkap</li>
                    <li class="d-flex align-items-center mb-3"><i class="bi bi-check-circle me-2"></i> Informasi Perkembangan Proses</li>
                </ul>
                <div class="text-start mt-4">
                    <a href="#faq" class="btn btn-primary btn-lg">Pelajari lebih lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="steps py-5">
    <div class="container text-center">
        <h1 class="mb-5 fw-bold">Bagaimana Proposal Anda Diproses?</h1>
        <p class="lead mb-5">Berikut adalah alur proses proposal anda sejak diajukan di front office hingga anda dapat melacak statusnya.</p>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5 class="mb-2 fw-bold">Pengajuan Proposal di Front Office</h5>
                        <p class="text-muted">Ajukan proposal anda secara langsung ke front office KONI Kota Bandung dan dapatkan tanda terima yang berisi link atau barcode pelacakan.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5 class="mb-2 fw-bold">Input Data oleh Front Office</h5>
                        <p class="text-muted">Tim front office akan menginput data proposal anda ke sistem Aprop.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5 class="mb-2 fw-bold">Proses Peninjauan Internal</h5>
                        <p class="text-muted">Proposal anda akan melalui tahapan peninjauan oleh tim internal KONI Kota Bandung.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5 class="mb-2 fw-bold">Lacak Status Proposal Anda</h5>
                        <p class="text-muted">Gunakan link atau barcode pada tanda terima anda untuk memantau status terkini proposal anda di Aprop.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="faq-section py-5" id="faq">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="{{ asset('assets/images/faq.png') }}" alt="FAQ" class="img-fluid" style="width: 70%;">
            </div>
            <div class="col-md-6">
                <h4 class="fw-bold mb-4">Pertanyaan yang sering diajukan</h4>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Bagaimana cara mengajukan proposal ke KONI Kota Bandung?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat mengajukan proposal secara langsung ke Front Office KONI Kota Bandung. Setelah pengajuan, anda akan menerima tanda terima yang dilengkapi dengan link atau barcode untuk pelacakan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Bagaimana cara melacak status proposal saya di Aprop?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Cukup gunakan link unik atau scan barcode yang tertera pada tanda terima yang anda dapatkan dari front office. Anda akan langsung diarahkan ke halaman status proposal anda tanpa perlu login.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Apakah saya perlu memiliki akun untuk melacak proposal?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tidak, Anda tidak perlu memiliki akun. Cukup gunakan link atau barcode dari tanda terima anda untuk memantau status proposal.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section py-5" id="kontak">
    <div class="container">
        <div class="contact-container p-4 p-md-5">
            <div class="text-center text-md-start mb-3 mb-md-0">
                <h5 class="fw-bold mb-2">Butuh Informasi lebih lanjut?</h5>
                <p class="mb-0">Tanyakan kepada kami, kami siap membantu.</p>
            </div>
            <a href="mailto:contact@koni-kotabandung.or.id" class="btn btn-light btn-lg">Hubungi Kami</a>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@include('layouts.footer')