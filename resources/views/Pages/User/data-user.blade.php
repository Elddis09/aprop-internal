@extends('Layouts.header')

@section('content')

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
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
                        <div class="alert alert-success alert-dismissible fade show shadow rounded w-100" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif



                        <h2>Rekapitulasi Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Data User</li>
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
                            <h2><strong>List User</strong> <small>Berikut adalah seluruh data user yang telah terdaftar.</small> </h2>
                        </div>
                        <div class="mb-3 text-right">
                            <a href="{{ route('superadmin.user.create') }}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> Tambah User
                            </a>
                        </div>
                        <div class="body table-responsive">


                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>Id User</th> -->
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Role</th>

                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <!-- <td>{{ $user->id }}</td> -->
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td><span class="badge bg-success">{{ $user->role }}</span></td>

                                        <td>
                                            <a href="{{ route('superadmin.user.edit', $user->id) }}" class="btn btn-sm btn-info text-white">Edit</a></a>

                                            <form action="{{ route('superadmin.user.delete', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">Belum ada user yang terdaftar.</td>
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

<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 20);
        }
    }, 2000);
</script>


<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

<script src="{{ asset('assets/js/pages/index.js') }}"></script>
</body>

</html>

@endsection