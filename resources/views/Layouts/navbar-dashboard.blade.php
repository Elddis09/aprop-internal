<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg bg-white px-4" style="border-bottom: 1px solid #727D73; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1001;">
    <div class="container-fluid">
        <!-- Logo di kiri -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets') }}/images/logo.png" alt="Logo" height="50">
        </a>

        <!-- Toggle untuk mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarRight"
            aria-controls="navbarRight" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu dan tombol di kanan -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarRight">
            <ul class="navbar-nav mb-2 mb-lg-0 me-3">
                <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>
            <div class="d-flex">

                <a class="btn btn-primary ms-2" style="background-color: #003c91;" href="{{ url('/register') }}">Dashboard</a>

            </div>
        </div>
    </div>
</nav>