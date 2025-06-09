@extends('Layouts.header')

@section('content')
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="assets/images/logo.svg" width="48" height="48" alt="Alpino"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Sidebar -->
@include('Layouts.sidebar')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Detail Proposal</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Proposal Pengajuan Dana Kejuaran PORDA</a></li>
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

            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold mt-4 mb-3">Informasi Pengaju</h5>
                                <p><strong>ID Proposal:</strong> 2025 - 10972</p>
                                <p><strong>Cabang Olahraga:</strong> Futsal</p>
                                <p><strong>Nama Pengaju:</strong> Wira</p>
                                <p><strong>Jabatan:</strong> Sekretaris</p>
                            </div>
                            <div class="col-md-6 mt-5">
                                <p><strong>Alamat:</strong> Jl. Kacapiring no 59</p>
                                <p><strong>Email:</strong> wirawanw@gmail.com</p>
                                <p><strong>No Telepon:</strong> 09123456789</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="fw-bold mt-4 mb-3">Informasi Proposal</h5>
                        <p><strong>Judul Proposal:</strong> Pengajuan Beasiswa Bela Negara</p>
                        <p><strong>Tanggal Proposal:</strong> 3 September 2025</p>
                        <p><strong>Tujuan Proposal:</strong> Pendanaan beasiswa</p>
                        <p><strong>Status Proposal:</strong> Proposal telah selesai ditinjau</p>
                        <p><strong>Ringkasan Proposal:</strong> TrackIt adalah platform untuk mempermudah proses pengelolaan proposal antara klien dan admin...</p>
                        <p><strong>Lampiran Proposal:</strong> Pengajuan Beasiswa Bela Negara.pdf</p>
                        <p><strong>File Pendukung I:</strong> Surat Rekomendasi.pdf</p>
                        <p><strong>File Pendukung II:</strong> -</p>
                        <p><strong>File Pendukung III:</strong> -</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="row align-items-center p-3">
                        <div class="col">
                            <h5 class="fw-bold mb-0">Status Proposal</h5>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary" onclick="prosesProposal()">Proses Proposal</button>
                        </div>
                    </div>
                    <div class="body ">
                        <ul class="cbp_tmtimeline ">
                            <li>
                                <time class="cbp_tmtime" datetime="2017-11-04T18:30"><span class="hidden">25/12/2017</span> <span class="large">Now</span></time>
                                <div class="cbp_tmicon"><i class="zmdi zmdi-account"></i></div>
                                <div class="cbp_tmlabel empty"> <span>Proposal Telah Diterima Oleh Front Office KONI Kota Bandung</span>
                                    <div>
                                        <a href="#"> <span>Surat Balasan Pengajuan Proposal.jpg</span></a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="fw-bold mt-4 mb-3">Catatan :</h5>
                                <p><strong>Status:</strong>-</p>
                                <p><strong>Revisi :</strong> -</p>
                                <p><strong>Tindakan Lanjut :</strong> -</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Jquery Core Js -->
<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
</body>

</html>