@extends('Layouts.header')

@section('content')

<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            </div>
        <p>Please wait...</p>
    </div>
</div>

<div class="d-flex">
    @include('Layouts.sidebar')
    <main class="content flex-grow-1 p-3">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Rekapitulasi Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="input-group m-b-0">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @php
            $rolesWithoutGlobalStats = ['stafpimpinan', 'stafbinpres', 'sekretarisdua', 'ketuadua', 'keuangan', 'bai'];
            $currentUserRole = strtolower(Auth::user()->role);
            @endphp

            @if(!in_array($currentUserRole, $rolesWithoutGlobalStats))
            <h6 class="mb-3 text-black">Statistik Global Sistem</h6>

            {{-- Baris Pertama (4 Card) --}}
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-collection-bookmark zmdi-hc-3x col-purple"></i></p>
                            <span>Total Proposal Sistem</span>
                            <h3 class="m-b-10">{{ $totalProposalSistem }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-refresh-sync zmdi-hc-3x col-blue"></i></p>
                            <span>Dalam Proses (Global)</span>
                            <h3 class="m-b-10">{{ $dalamProsesSistem }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-circle zmdi-hc-3x col-orange"></i></p>
                            <span>Pending (Global)</span>
                            <h3 class="m-b-10">{{ $pendingSistem }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-triangle zmdi-hc-3x col-red"></i></p>
                            <span>Canceled (Global)</span>
                            <h3 class="m-b-10">{{ $cancelSistem }}</h3>
                        </div>
                    </div>
                </div>
            </div> {{-- Tutup row pertama --}}

            {{-- Baris Kedua (2 Card) --}}
            <div class="row clearfix mt-4"> {{-- mt-4 untuk sedikit jarak antar baris --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-check-circle zmdi-hc-3x col-green"></i></p>
                            <span>Disetujui (Final)</span>
                            <h3 class="m-b-10">{{ $disetujuiSistem }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-block zmdi-hc-3x col-red"></i></p>
                            <span>Ditolak (Final)</span>
                            <h3 class="m-b-10">{{ $ditolakSistem }}</h3>
                        </div>
                    </div>
                </div>
            </div> {{-- Tutup row kedua --}}
            @endif

            <h6 class="mb-3 mt-4 text-black">Statistik Spesifik {{ Auth::user()->name }}</h6>

            {{-- Baris Pertama (4 Card) untuk Statistik Spesifik --}}
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-notifications-active zmdi-hc-3x col-info"></i></p>
                            <span>Kotak Masuk (Di Posisi Anda)</span>
                            <h3 class="m-b-10">{{ $kotakMasukRoleSaatIni }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-refresh-sync zmdi-hc-3x col-blue"></i></p>
                            <span>Dalam Proses (Oleh Anda)</span>
                            <h3 class="m-b-10">{{ $dalamProsesOlehRoleIni }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-circle zmdi-hc-3x col-orange"></i></p>
                            <span>Pending (Oleh Anda)</span>
                            <h3 class="m-b-10">{{ $pendingOlehRoleIni }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-triangle zmdi-hc-3x col-red"></i></p>
                            <span>Canceled (Oleh Anda)</span>
                            <h3 class="m-b-10">{{ $dicancelOlehRoleIni }}</h3>
                        </div>
                    </div>
                </div>
            </div> {{-- Tutup row pertama statistik spesifik --}}

            {{-- Baris Kedua (2 Card) untuk Statistik Spesifik --}}
            <div class="row clearfix mt-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-check-all zmdi-hc-3x col-deep-purple"></i></p>
                            <span>Disetujui Oleh Anda</span>
                            <h3 class="m-b-10">{{ $disetujuiOlehRoleIni }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-block zmdi-hc-3x col-red"></i></p>
                            <span>Ditolak Oleh Anda</span>
                            <h3 class="m-b-10">{{ $ditolakOlehRoleIni }}</h3>
                        </div>
                    </div>
                </div>
            </div> {{-- Tutup row kedua statistik spesifik --}}

        </div>
    </main>
</div>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script>

<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/index.js') }}"></script>
</body>

</html>
@endsection