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
    <!-- sidebar -->
    @include('Layouts.sidebar')

    <!-- Main Content -->
    <main class="content flex-grow-1 p-3">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h2>Rekapitulasi Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Data Proposal</li>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>List Proposal</strong> <small>Berikut adalah seluruh data proposal yang telah diajukan.</small> </h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Proposal</th>
                                        <th>Pengaju</th>
                                        <th>Cabang Olahraga</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status Proposal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposals as $proposal)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $proposal->judul }}</td>
                                        <td>{{ $proposal->pengaju }}</td>
                                        <td>{{ $proposal->cabang_olahraga }}</td>
                                        <td>{{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</td>
                                        <td><span class="badge bg-success">{{ $proposal->status }}</span></td>
                                        <td>
                                            <a href="{{ route('klien.proposal.show', $proposal->id) }} ">Detail</a>
                                            @if($proposal->surat_balasan)
                                            <a href="{{ Storage::url($proposal->surat_balasan) }}" target="_blank" >Surat Balasan</a>
                                            @else
                                            <a>Surat Balasan</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada proposal yang diajukan.</td>
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

<!-- Footer -->


<!-- Jquery Core Js -->
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