@extends('Layouts.header')

@section('content')

<style>
    body {
        background-color: #ffffff;
        font-family: 'Segoe UI', sans-serif;
    }

    .btn-daftar {
        background-color: #003c91;
        height: 40px;
        color: #fff;
        border-radius: 50px;
        border-color: #fff;
    }

    .btn-daftar:hover {
        background-color: #ffff;
        color: #003c91;
        border-color: #003c91;
    }

    .register-box {
        border: 1px solid #003c91;
        padding: 40px;
        border-radius: 5px;
        background-color: #fff;
    }

    .form-control {
        border-radius: 10px;
    }
</style>


<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center">
        <!-- Form -->
        <div class="col-lg-6">
            <div class="register-box shadow">
                <h3 class="text-center mb-4">DAFTAR</h3>
                <form method="POST" action="{{ url('register') }}">
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
                    <!-- <div class="input-group">
                        <input type="text" class="form-control" placeholder="Konfirmasi Kata Sandi" name="password_confirmation">
                        <span class="input-group-addon"><i class="zmdi zmdi-lock-outline"></i></span>
                    </div> -->
                    <div class="d-grid">
                        <button type="submit" class="btn-daftar">DAFTAR</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Image -->
        <div class="col-lg-6 text-center d-none d-lg-block">
            <img src="{{ asset('assets/images/daftar.png') }}" alt="Ilustrasi" class="img-fluid" style="max-height: 400px;">
        </div>
    </div>
</div>

<!-- Footer -->

@include('Layouts.footer')
@endsection