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
                    <h2>Update Akun</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Update Akun</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-lg-12">
                <div class="card">
                    <div class="row align-items-center p-3">

                        <p class="text-secondary">Silahkan ubah data data informasi berikut untuk mengupdate akun.</p>
                    </div>
                    <div class="body ">


                        <form action="{{ route('superadmin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('username')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" name="role" disabled>
                                    <option value="{{ $user->role }}" selected>
                                        {{ ucfirst($user->role) }}
                                    </option>
                                </select>
                                <input type="hidden" name="role" value="{{ $user->role }}"> {{-- agar tetap dikirim ke controller --}}
                            </div>


                            <!-- Password Baru -->
                            <div class="form-group">
                                <label for="password">Password Baru (opsional)</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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