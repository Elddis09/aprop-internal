@extends('Layouts.header')

@section('content')
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
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
                    <h2>Registrasi Akun Baru</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pembuatan Akun Baru</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="row align-items-center p-3">

                        <p class="text-secondary">Silahkan isi data data informasi berikut untuk membuat akun baru.</p>
                    </div>
                    <div class="body ">

                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="input-group">
                                <input type="text" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Lengkap" name="name">
                                <span class="input-group-addon"><i class="zmdi zmdi-face"></i></span>
                            </div>
                            @error('name')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required>
                                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('username')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            </div>
                            @error('email')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" name="password" required>
                                <span class="input-group-addon"><i class="zmdi zmdi-lock-outline"></i></span>
                            </div>
                            @error('password')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <select class="form-control" id="statusProposal" name="role">
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="frontoffice">Front Office</option>
                                    <option value="backoffice">Back Office</option>
                                    <option value="stafpimpinan">Staf Pimpinan</option>
                                    <option value="sekretarisumum">Sekretaris Umum</option>
                                    <option value="stafbinpres">Staf Binpres</option>
                                    <option value="binpres">Binpres</option>
                                    <option value="sekretarisdua">Sekretaris II</option>
                                    <option value="ketuadua">Ketua II</option>
                                    <option value="ketuaumum">Ketua Umum</option>
                                    <option value="keuangan">Keuangan</option>
                                    <option value="bai">BAI</option>
                                    <option value="stafumum">Staf Umum</option>
                                    <option value="bidangumum">Bidang Umum</option>
                                    <option value="sekretaristiga">Sekretaris III</option>
                                    <option value="ketuatiga">Ketua III</option>
                                </select>
                            </div>

                            <div class="mb-3">

                                <div class="col text-right mt-3">
                                    <button class="btn btn-primary" type="submit">Daftar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

</body>

</html>