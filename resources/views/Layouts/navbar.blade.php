<nav class="navbar fixed-top navbar-expand-lg bg-white px-4" style="border-bottom: 1px solid #727D73; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1001;">
    <div class="container-fluid">
        <button class="navbar-toggler d-block d-lg-none me-2" type="button" id="leftSidebarToggle" aria-label="Toggle Left Sidebar">
            <i class="zmdi zmdi-menu"></i> 
        </button>

        <!-- Logo di kiri -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" height="50">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarRight"
            aria-controls="navbarRight" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu dan tombol di kanan -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarRight">
            <ul class="navbar-nav mb-2 mb-lg-0 me-3">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/faqs') }}">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>

            <div>
                @if(auth()->check())
                    @php
                        $role = auth()->user()->role ?? null;
                        $dashboardUrl = '#';
                        if ($role === 'frontoffice') {
                            $dashboardUrl = url('/dashboard-fo');
                        } elseif ($role === 'superadmin') {
                            $dashboardUrl = url('/dashboard-admin');
                        } elseif (in_array($role, ['backoffice', 'stafpimpinan', 'sekretarisumum', 'stafbinpres', 'binpres', 'sekretarisdua', 'ketuadua', 'ketuaumum', 'keuangan', 'bai'])) {
                            $dashboardUrl = url('/dashboard-admin');
                        } else {
                            $dashboardUrl = url('/dashboard');
                        }
                    @endphp

                    <a class="btn btn-outline-success me-2" href="{{ $dashboardUrl }}">Dashboard</a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger" type="submit">Logout</button>
                    </form>
                @else
                    <a class="btn" style="background-color: #003c91;" href="{{ url('/login') }}">Masuk</a>
                @endif
            </div>
        </div>
    </div>
</nav>
