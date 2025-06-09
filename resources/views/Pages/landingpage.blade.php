@extends('layouts.header')
<!-- <link rel="stylesheet" href="{{ asset('assets/css/landingpage.css') }}"> -->
@section('title', 'Beranda | APROP')

@include('layouts.navbar')

<style>
    .hero {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        padding: 60px;
        /* margin-top: 10px; */
    }

    .hero-content {
        max-width: 50%;
        padding-left: 30px;
    }

    .hero-content h1 {
        font-size: 36px;
        font-weight: bold;
        color: #333;
    }

    .hero-content p {
        font-size: 18px;
        color: #555;
    }

    .btn-start {
        background-color: #003c91;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }

    .hero-image img {
        max-width: 100%;
        /* Increased width */
        height: auto;
        border-radius: 8px;
    }

    .img-fluid {
        width: 100%;
    }

    .features {
        background-color: #f9f9f9;
        text-align: center;
        padding: 40px;
    }

    .features h2 {
        font-size: 30px;
        color: #333;
    }

    .features p {
        font-size: 16px;
        color: #555;
    }

    .features .row {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .features .col-md-3 {
        flex: 0 0 50%;
        /* Set image size to 50% */
        display: flex;
        justify-content: center;
    }

    .features .col-md-9 {
        flex: 0 0 50%;
        /* Set text size to 50% */
        display: flex;
        align-items: center;
        justify-content: flex-start;
        text-align: left;
    }

    .features ul {
        list-style-type: none;
        padding-left: 0;
    }

    .features ul li {
        font-size: 18px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    /* Blue circle with white checkmark */
    .features ul li i {
        margin-right: 10px;
        color: #0d6efd;
        /* White icon */
        font-size: 15px;
        /* Icon size */
        border-radius: 50%;
        /* Circle shape */
        padding: 10px;
        /* Padding for the circle */
    }

    .btn-learn-more {
        display: inline-block;
        background-color: #003c91;
        color: white;
        padding: 12px 25px;
        margin-top: 20px;
        text-decoration: none;
        border-radius: 5px;
    }

    .steps {
        padding: 50px;
        background-color: #fff;
        text-align: center;
    }

    .steps h2 {
        font-size: 28px;
        color: #333;
    }

    .steps ul {
        list-style-type: none;
        padding: 0;
    }

    .steps ul li {
        font-size: 18px;
        margin: 10px 0;
        color: #555;
    }

    .step {
        position: relative;
        margin-bottom: 25px;
    }

    .step::before {
        content: "";
        position: absolute;
        top: 0;
        left: 14px;
        height: calc(100% + 20px);
        /* Menyesuaikan panjang garis vertikal */
        width: 2px;
        background-color: #dbdbdb;
        z-index: -1;
    }

    .step:last-child::before {
        display: none;
        /* Menghilangkan garis pada langkah terakhir */
    }

    .step-number {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #003c91;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
    }

    .step-content {
        margin-left: 40px;
        color: #333;
    }

    .step-content h5 {
        font-size: 18px;
        font-weight: 550;
    }

    .active .step-number {
        background-color: #003c91;
    }

    .completed .step-number {
        background-color: #003c91;
    }

    .faq-section {
        padding: 60px 0;
        background-color: #f9f9f9;
    }

    .contact-section {
        display: flex;
        justify-content: center;
        padding: 40px 20px;
        background-color: #ffff;
    }

    .contact-container {
        background-color: #0057a0;
        color: white;
        border-radius: 8px;
        padding: 24px 32px;
        max-width: 900px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .btn-link {
        background-color: #ffff !important;
        color: #003c91 !important;
        padding: 10px 16px;
        border-radius: 4px;
        text-decoration: none !important;
        font-weight: 700 !important;
    }

    .btn-link:hover {
        background-color: #003c91 !important;
        color: #ffff !important;
        padding: 10px 16px;
        border-radius: 4px;
        text-decoration: none !important;
        font-weight: 700 !important;
        border-color: #ffff !important;
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Proposal Anda, Kami Atur dengan Cermat</h1>
        <p>Ayo, ajukan sekarang!</p>
        <a href="{{ route('login') }}" class="btn-start">Mulai</a>
    </div>
    <div class="hero-image">
        <img src="{{ asset('assets/images/hero.png') }}" alt="Hero Image" />
    </div>
</section>

<!-- Features Section -->
<section class="features" id="about">
    <h2>Lacak Setiap Proposal Anda dengan Mudah melalui Aprop!</h2>
    <p>Aprop adalah platform yang dirancang untuk mempermudah proses pengelolaan proposal antara klien dan admin. Kami menawarkan solusi yang efisien dan terorganisir untuk mengajukan, mengelola, dan memantau proposal secara online. Dengan Aprop, Anda dapat melacak status proposal dengan mudah dan memastikan proses pengelolaan berjalan lancar tanpa kesulitan.</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <img src="{{ asset('assets/images/about.png') }}" class="img-fluid" alt="Proposal Image">
        </div>
        <div class="col-md-9">
            <ul>
                <li><i class="bi bi-check-circle"></i> Pengajuan Proposal</li>
                <li><i class="bi bi-check-circle"></i> Pemantauan Status Proposal</li>
                <li><i class="bi bi-check-circle"></i> Pembaruan Status Proposal Secara Berkala</li>
                <li><i class="bi bi-check-circle"></i> Riwayat Status Proposal</li>
                <li>
                    <div class="text-center mt-4">
                        <a href="#faq" class="btn" style="background-color: #003c91; color:#fff">Pelajari lebih lanjut</a>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</section>

<!-- Steps Section -->
<div class="container my-5">
    <h1 class="text-center mb-4">Tahapan Pengajuan Proposal</h1>
    <p class="text-center mb-5 text-muted">Berikut adalah tahapan - tahapan pengajuan proposal</p>

    <div class="step completed">
        <div class="step-number">1</div>
        <div class="step-content">
            <h5 class="mb-1">Registrasi dan Login</h5>
            <p class="mb-0 text-muted">Registrasi akun dan login untuk menambah data usulan proposal.</p>
        </div>
    </div>

    <div class="step active">
        <div class="step-number">2</div>
        <div class="step-content">
            <h5 class="mb-1">Lengkapi Data</h5>
            <p class="mb-0 text-muted">Isi dan lengkapi data pengusul proposal.</p>
        </div>
    </div>

    <div class="step">
        <div class="step-number">3</div>
        <div class="step-content">
            <h5 class="mb-1">Lengkapi Berkas</h5>
            <p class="mb-0 text-muted">Isi dan lengkapi kelengkapan untuk pengajuan proposal.</p>
        </div>
    </div>

    <div class="step">
        <div class="step-number">4</div>
        <div class="step-content">
            <h5 class="mb-1">Kirim Data</h5>
            <p class="mb-0 text-muted">Pastikan data diisi dengan baik dan benar, kemudian kirim data untuk mengirimkan pengajuan proposal.</p>
        </div>
    </div>
</div>


<!-- FAQ Section -->
<section class="faq-section " id="faq">
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
                                Bagaimana Cara Mengajukan Proposal?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kamu bisa mengajukan proposal dengan membaca ketentuan dan langkah-langkah yang telah diinfokan pada halaman tentang kami. Jika ada pertanyaan yang ingin ditanyakan lebih lanjut...
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Berapa Lama Proses Pengajuan?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Proses pengajuan biasanya memakan waktu sekitar 3-5 hari kerja tergantung kelengkapan dokumen.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana Melihat Status Proposal?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kamu bisa melihat status proposal melalui dashboard akun kamu atau melalui halaman tracking proposal.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="contact-container">
        <div class="text">
            <h5>Butuh Informasi lebih lanjut?</h5>
            <p>Tanyakan kepada kami, kami siap membantu.</p>
        </div>
        <a href="#kontak" class="btn-link">Hubungi Kami</a>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@include('layouts.footer')