@extends('Layouts.header')

@section('content')

@php
    use App\Models\Mitra;
@endphp

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif


<div class="d-flex">

    <!-- Sidebar -->
    @include('Layouts.sidebar')

    <!-- Main Content -->
    <main class="content flex-grow-1 p-3">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Profile Pengaju</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Profile</li>
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
                        <div class="body bg-dark profile-header">
                            <div class="row">
                                <div class="col-lg-10 col-md-12">
                                    <img src="{{ asset('assets/images/ava.png') }}" class="user_pic rounded img-raised" alt="User">
                                    <div class="detail">
                                        <div class="u_name">
                                            <h4>
                                                <strong>Cabang Olahraga </strong>
                                                @php
                                                $currentCaborName = 'Belum Diketahui'; // Default jika tidak ditemukan

                                                if (isset($user) && $user->cabor_id) { // Pastikan user ada dan punya cabor_id
                                                if (strpos($user->cabor_id, 'mitra-') === 0) {
                                                // Jika cabor_id dimulai dengan 'mitra-', cari nama mitra
                                                $mitraId = substr($user->cabor_id, 6); // Mengambil ID mitra tanpa 'mitra-'
                                                $mitra = Mitra::find($mitraId);
                                                $currentCaborName = $mitra ? $mitra->nama : 'Mitra tidak ditemukan';
                                                } else {
                                                // Jika tidak mitra, cari nama cabang olahraga dari API
                                                foreach ($allPengaju as $cabor) {
                                                if ($cabor['id_cabor'] == $user->cabor_id) {
                                                $currentCaborName = $cabor['nama_cabor'];
                                                break;
                                                }
                                                }
                                                }
                                                }
                                                @endphp

                                                {{ $currentCaborName }}
                                            </h4>
                                            <span>{{ auth()->user()->name }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <ul class="nav nav-tabs profile_tab">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#overview">Ringkasan</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usersettings">Pengaturan</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="overview">

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2><strong>Info</strong></h2>
                                        </div>
                                        <div class="body">
                                            <small>Email: </small>
                                            <p>{{ auth()->user()->email }}</p>
                                            <hr>
                                            <small class="text-muted">No Telepon: </small>
                                            <p>{{ auth()->user()->no_telepon ?? 'No telepon tidak tersedia' }}</p>
                                            <hr>
                                            <small class="text-muted">Jabatan: </small>
                                            <p>{{ auth()->user()->jabatan ?? 'Tidak ada jabatan' }}</p>
                                            <hr>
                                            <small class="text-muted">Alamat: </small>
                                            <p>{{ auth()->user()->alamat ?? 'Alamat tidak tersedia' }}</p>
                                            <hr>
                                            <small class="text-muted">Kota: </small>
                                            <p>{{ auth()->user()->kota ?? 'kota tidak tersedia' }}</p>
                                            <!-- <div>
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1923731.7533500232!2d-120.39098936853455!3d37.63767091877441!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan+Francisco%2C+CA%2C+USA!5e0!3m2!1sen!2sin!4v1522391841133" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div> -->
                                            <hr>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <form id="profile-form" method="POST" action="{{ route('klien.profil-cabor.update', ['id' => auth()->user()->id]) }}">
                            @csrf
                            @method('PUT') <!-- Method PUT untuk update -->

                            <div role="tabpanel" class="tab-pane" id="usersettings">
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Pengaturan</strong> Profil</h2>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <!-- Dropdown Cabor -->
                                            <div class="form-group">
                                                <select name="cabang_olahraga" id="cabang_olahraga" class="form-control">
                                                    <option value="" disabled selected>Pilih Cabang Olahraga / Mitra</option>
                                                    @foreach($allPengaju as $pengaju)
                                                    <option value="{{ ($pengaju['tipe'] ?? 'api') === 'mitra' ? 'mitra-' . $pengaju['id_cabor'] : $pengaju['id_cabor'] }}"
                                                        {{ ($user->cabor_type === ($pengaju['tipe'] ?? 'api') && $user->cabor_id == $pengaju['id_cabor']) ? 'selected' : '' }}>
                                                        {{ $pengaju['nama_cabor'] }}
                                                        @if(($pengaju['tipe'] ?? 'api') === 'mitra')
                                                        (Mitra)
                                                        @endif
                                                    </option>
                                                    @endforeach

                                                    <option value="lainnya">Lainnya (Tambah Mitra Baru)</option>
                                                </select>

                                            </div>
                                            <!-- Input box muncul kalau 'lainnya' dipilih -->
                                            <div class="form-group" id="mitra-baru-box" style="display: none;">
                                                <label for="nama_mitra_baru">Nama Mitra Baru</label>
                                                <input type="text" name="nama_mitra_baru" class="form-control" placeholder="Isi Nama Mitra Baru">
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <input name="name" type="text" class="form-control" placeholder="Nama Lengkap" value="{{ auth()->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="kota" class="form-control" placeholder="Kota" value="{{ auth()->user()->kota }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="email" placeholder="E-mail" value="{{ auth()->user()->email }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="no_telepon" class="form-control" placeholder="No Telepon" value="{{ auth()->user()->no_telepon }}">

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="{{ auth()->user()->jabatan }}">

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea rows="4" class="form-control no-resize" name="alamat" placeholder="Alamat">{{ auth()->user()->alamat }}"</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary btn-round">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Pengaturan</strong> Akun</h2>
                                    </div>
                                    <div class="body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Kata Sandi Saat Ini">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Kata Sandi Baru">
                                        </div>
                                        <button class="btn btn-info btn-round">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>
</div>

<!-- Footer -->


<!-- Jquery Core Js -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('cabang_olahraga');
        const mitraBox = document.getElementById('mitra-baru-box');

        function toggleMitraBox() {
            if (dropdown.value === 'lainnya') {
                mitraBox.style.display = 'block';
            } else {
                mitraBox.style.display = 'none';
            }
        }

        // Panggil saat load pertama (kalau data lama user udah pilih "lainnya")
        toggleMitraBox();

        // Tambahkan listener saat dropdown berubah
        dropdown.addEventListener('change', toggleMitraBox);
    });
</script>



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