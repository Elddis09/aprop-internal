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
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
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

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-folder-star-alt zmdi-hc-3x col-amber"></i></p>
                            <span>Total Pengajuan Proposal</span>
                            <h3 class="m-b-10">{{$total}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-refresh-sync zmdi-hc-3x col-blue"></i></p>
                            <span>Dalam Proses</span>
                            <h3 class="m-b-10">{{$diterima}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-check-circle zmdi-hc-3x col-green"></i></p>
                            <span>Disetujui</span>
                            <h3 class="m-b-10">{{$disetujui}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-block zmdi-hc-3x col-red"></i></p>
                            <span>Ditolak</span>
                            <h3 class="m-b-10">{{$ditolak}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-alert-circle zmdi-hc-3x col-orange"></i></p>
                            <span>Perlu Tindakan</span>
                            <h3 class="m-b-10">{{$perluTindakan}}</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

 <!-- Footer -->


 <!-- Jquery Core Js -->
 <script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
 <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->

 <script src="assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
 <script src="assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
 <script src="assets/bundles/morrisscripts.bundle.js"></script> <!-- Morris Plugin Js -->
 <script src="assets/bundles/sparkline.bundle.js"></script> <!-- sparkline Plugin Js -->
 <script src="assets/bundles/doughnut.bundle.js"></script>

 <script src="assets/bundles/mainscripts.bundle.js"></script>
 <script src="assets/js/pages/index.js"></script>
 </body>

 </html>

@endsection
