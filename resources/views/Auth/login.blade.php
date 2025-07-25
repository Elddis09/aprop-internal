@extends('Layouts.header')

@section('content')

<div id="app-content-wrapper">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
            </div>
            <p>Please wait...</p>
        </div>
    </div>

    <div class="container  my-5">
        <div class="row align-items-center">
            {{-- Pop-up Sukses (sudah ada) --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Pop-up Error (TAMBAHKAN INI) --}}
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            <!-- Form -->
            <div class="col-lg-6">
                <div class="register-box shadow">
                    <h3 class="text-center mb-4">MASUK</h3>
                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required autofocus>
                            <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                        </div>
                        @error('username')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" required>
                            <span class="input-group-addon"><i class="zmdi zmdi-lock-outline"></i></span>
                        </div>
                        @error('password')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <div class="d-grid">
                            <button type="submit" class="btn-daftar">MASUK</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Image -->
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="{{ asset('assets/images/login.png') }}" alt="Ilustrasi" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('Layouts.footer')
@stack('scripts')
@endsection