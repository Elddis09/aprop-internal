@extends('Layouts.header')

@section('content')

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

<div class="d-flex">
    <!-- Sidebar -->
    @include('Layouts.sidebar')

    <!-- Main Content -->
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
                            <li class="breadcrumb-item active">Proposal Terbaru</li>
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

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Daftar</strong> Proposal Menunggu</h2>
                        </div>
                        <div class="body project_report">
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Judul Proposal</th>
                                            <th>Pengaju</th>
                                            <th>Cabang Olahraga</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proposals as $proposal)
                                        <tr>
                                            <td>
                                                <span class="badge badge-warning">Menunggu</span>
                                            </td>
                                            <td class="project-title">
                                                <h6>
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}">
                                                        {{ $proposal->judul }}
                                                    </a>
                                                </h6>
                                            </td>
                                            <td>{{ $proposal->user->name ?? '-' }}</td>
                                            <td>{{ $proposal->cabang_olahraga?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <div class="actions">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" class="btn btn-sm btn-warning mb-2">
                                                        Tindak Sekarang
                                                    </a>
                                                    <!-- <a href="#" class="btn btn-sm btn-secondary mb-2">
                                                        Kirim Surat Balasan
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-warning mb-2">
                                                        Disposisi Sekarang
                                                    </a> -->
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada proposal yang perlu ditindak.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/index.js') }}"></script>

@endsection