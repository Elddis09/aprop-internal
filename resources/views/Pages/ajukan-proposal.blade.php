@extends('Layouts.header')

@section('content')

@php
use App\Models\Mitra;
@endphp

<style>
    /* Premium Checkbox Styles */
    .form-check-input:checked {
        background-color: #0057a0;
        /* Customize checked background color */
        border-color: #0057a0;
        /* Customize border color */
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 87, 160, 0.25);
        /* Focus effect */
    }

    .form-check-label {
        font-weight: 600;
        /* Making the label more prominent */
        color: #333;
        /* Darker text for better contrast */
        font-size: 16px;
        /* Slightly bigger font size for a more premium look */
    }

    .form-check-inline {
        padding-right: 30px;
        /* Adds spacing between each checkbox for a clean design */
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
                            <li class="breadcrumb-item active">Ajukan Proposal</li>
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
                            <h2><strong>Form Pengajuan</strong> <small>Silahkan Isi Data Data Berikut Untuk Mengajukan Proposal Ke KONI Kota Bandung.</small> </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="px-4">
                                <div class="card p-4">
                                    <h4 class="fw-bold mb-3">Informasi Pengaju</h4>

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif


                                    <form action="{{ route('klien.proposal.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-12 text-muted">
                                                <label for="pengaju">Nama Pengaju</label>
                                                <input type="text" name="pengaju" class="form-control" placeholder="Pengaju Berkas">
                                            </div>
                                            <div class="col row-12 mt-3 text-muted">
                                                <div class="form-group">
                                                    <label for="cabang_olahraga">Cabang Olahraga / Mitra</label>
                                                    <select name="cabang_olahraga" id="cabang_olahraga" class="form-control">
                                                        <option value="" disabled selected>Pilih Cabang Olahraga / Mitra</option>
                                                        @foreach($caborData as $pengaju)

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
                                            </div>
                                            <div class="mb-3 text-muted">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-muted">
                                                    <label for="no_telepon">Nomor Telepon</label>
                                                    <input type="text" name="no_telepon" class="form-control" placeholder="Nomor Telepon">
                                                </div>
                                                <div class="col text-muted">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                                </div>
                                            </div>

                                            <h4 class="fw-bold mt-4 mb-3">Informasi Berkas</h4>

                                            <div class="mb-3">
                                                <input type="text" name="no_surat" class="form-control" placeholder="No Surat">
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="perihal" class="form-control" placeholder="Perihal">
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_berkas" class="form-label">Jenis Berkas</label><br>
                                                <div class="d-flex gap-4">
                                                    <!-- Checkbox 1 -->
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="surat" id="jenis_berkas1" {{ in_array('surat', old('jenis_berkas', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas1">Surat</label>
                                                    </div>
                                                    <!-- Checkbox 2 -->
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="proposal" id="jenis_berkas2" {{ in_array('proposal', old('jenis_berkas', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas2">Proposal</label>
                                                    </div>
                                                    <!-- Checkbox 3 -->
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="barang" id="jenis_berkas3" {{ in_array('barang', old('jenis_berkas', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas3">Barang</label>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="mb-3">
                                                <input type="text" name="judul_berkas" class="form-control" placeholder="Judul Berkas">
                                            </div>

                                            <div class="mb-3">
                                                <input type="text" name="tujuan_berkas" class="form-control" placeholder="Tujuan Berkas">
                                            </div>
                                            <div class="mb-3">
                                                <textarea name="ringkasan_berkas" class="form-control" placeholder="Ringkasan Berkas" rows="4"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan</label>
                                                <input type="date" name="tgl_pengajuan" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>File Utama</label>
                                                <input type="file" name="file_utama" class="form-control">
                                            </div>
                                            <h4 class="fw-bold mt-4 mb-3">Penerima Berkas</h4>
                                            <div class="mb-3">
                                                <input type="text" name="nama_petugas" class="form-control" placeholder="Nama Petugas">
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" name="no_telepon_petugas" class="form-control" placeholder="No Telepon">
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn text-white" style="background-color: #0057a0; width: 150px;">Kirim</button>
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