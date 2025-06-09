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
                        <h2>Ajukan Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Update Proposal</li>
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
                            <h2><strong>Form Update Proposal</strong> <small>Silahkan Perbaharui Data Berikut Untuk Update Proposal Ke KONI Kota Bandung.</small> </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="px-4">
                                <div class="card p-4">
                                    <h4 class="fw-bold mb-3">Informasi Pengaju</h4>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input type="text" name="pengaju" class="form-control" placeholder="Pengaju Proposal" value="Wira">
                                            </div>
                                            <div class="col">
                                                <input type="text" name="cabang_olahraga" class="form-control" placeholder="Cabang Olahraga" value="">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="">
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input type="text" name="telepon" class="form-control" placeholder="Nomor Telepon" value="">
                                            </div>
                                            <div class="col">
                                                <input type="email" name="email" class="form-control" placeholder="Email" value="">
                                            </div>
                                        </div>

                                        <h4 class="fw-bold mt-4 mb-3">Informasi Proposal</h4>

                                        <div class="mb-3">
                                            <input type="text" name="judul" class="form-control" placeholder="Judul Proposal" value="">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="tujuan" class="form-control" placeholder="Tujuan Proposal" value="">
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="ringkasan" class="form-control" placeholder="Ringkasan Proposal" rows="4"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <input type="date" name="tanggal_pengajuan" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>File Proposal</label>
                                            <input type="file" name="file_proposal" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>File Pendukung I</label>
                                            <input type="file" name="file_pendukung_1" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>File Pendukung II</label>
                                            <input type="file" name="file_pendukung_2" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>File Pendukung III</label>
                                            <input type="file" name="file_pendukung_3" class="form-control">
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn text-white" style="background-color: #0057a0; width: 150px;">Simpan Perubahan</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
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