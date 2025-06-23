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

            {{-- Baris Pertama Statistik Global (4 Card) --}}
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
            </div> {{-- Tutup row pertama Statistik Global --}}

            {{-- Baris Kedua Statistik Global (2 Card) --}}
            <div class="row clearfix mt-4">
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
            </div> {{-- Tutup row kedua Statistik Global --}}
            @endif

            <h6 class="mb-3 mt-4 text-black">Statistik Spesifik Front Office</h6>

            {{-- Baris Pertama Statistik Spesifik FO (4 Card) --}}
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('superadmin.proposal-terbaru') }}"
                        class="card text-center"
                        style="display: block; text-decoration: none; color: inherit;">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-notifications-active zmdi-hc-3x col-info"></i></p>
                            <span>Kotak Masuk (Di Posisi Saya)</span>
                            <h3 class="m-b-10">{{ $kotakMasukFo }}</h3>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-mail-send zmdi-hc-3x col-teal"></i></p>
                            <span>Diproses (Oleh Saya)</span>
                            <h3 class="m-b-10">{{ $dalamProsesOlehFO }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-check-all zmdi-hc-3x col-deep-purple"></i></p>
                            <span>Selesai (Diajukan Oleh Saya)</span>
                            <h3 class="m-b-10">{{ $proposalSelesaiDiajukanFO }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-triangle zmdi-hc-3x col-red"></i></p>
                            <span>Canceled (Oleh Saya)</span>
                            <h3 class="m-b-10">{{ $proposalCancelFO }}</h3>
                        </div>
                    </div>
                </div>
            </div> {{-- Tutup row pertama Statistik Spesifik FO --}}

            {{-- Karena Anda hanya memiliki 4 card di statistik FO, maka hanya ada satu baris untuk 4 card tersebut.
                 Jika Anda ingin baris kedua dengan 2 card (seperti di global), Anda harus memiliki total 6 card juga di FO,
                 atau menyesuaikan $col-lg-X di baris kedua.
                 Dengan 4 card, ini sudah pas 1 baris 4. --}}

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
@endsection