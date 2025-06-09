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
                    <h2>Update Status Proposal</h2>
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
                <div class="card mb-0">
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
                            <h7 class="fw-bold mb-0">Status Proposal</h7>
                        </div>
                    </div>
                    <div class="body ">
                        <form action="{{ route('superadmin.proposal.ubah-status', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="statusProposal">Posisi Saat Ini</label>
                                <select class="form-control show-tick" id="statusProposal" name="statusProposal">
                                    <option value="" disabled selected>-- Pilih Posisi --</option>
                                    <option value="diterima">Proposal Diterima</option>
                                    <option value="diproses">Sedang Diproses</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="revisi">Butuh Revisi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statusProposal">Keterangan Saat Ini</label>
                                <input type="text" class="form-control text-muted" placeholder="Keterangan Saat Ini" value="Proposal Sedanga Dalam Peninjauan Kembali">
                            </div>
                            <div class="form-group">
                                <label for="statusProposal">Status Proposal Saat Ini</label>
                                <select class="form-control show-tick" id="statusProposal" name="statusProposal">
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="diterima">Proposal Diterima</option>
                                    <option value="diproses">Sedang Diproses</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="revisi">Butuh Revisi</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="row align-items-center p-3">
                            <div class="col">
                                <h7 class="fw-bold mb-0">Update Status Proposal</h7>
                            </div>
                        </div>
                        <div class="body">
                            <form action="#" method="POST">
                                <div class="form-group">
                                    <label for="statusProposal">Ubah Status Proposal</label>
                                    <select class="form-control show-tick" id="statusProposal" name="statusProposal">
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="diterima">Proposal Diterima</option>
                                        <option value="diproses">Sedang Diproses</option>
                                        <option value="disetujui">Disetujui</option>
                                        <option value="ditolak">Ditolak</option>
                                        <option value="revisi">Butuh Revisi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="statusProposal">Ubah Posisi Proposal</label>
                                    <select class="form-control" id="statusProposal" name="statusProposal">
                                        <option value="" disabled selected>-- Pilih Posisi --</option>
                                        <option value="frontoffice">Front Office</option>
                                        <option value="backoffice">Back Office</option>
                                        <option value="stafpimpinan">Staf Pimpinan</option>
                                        <option value="sekretarisumum">Sekretaris Umum</option>
                                        <option value="stafbinpres">Staf Binpres</option>
                                        <option value="binpres">Binpres</option>
                                        <option value="sekretarisII">Sekretaris II</option>
                                        <option value="ketuaII">Ketua II</option>
                                        <option value="ketuaumum">Ketua Umum</option>
                                        <option value="keuangan">Keuangan</option>
                                        <option value="bai">BAI</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Update Keterangan</label><input type="text" class="form-control" id="keterangan" name="keterangan"></label>
                                </div>
                                <div class="mb-3">
                                    <label>Kirim Surat Balasan</label>
                                    <input type="file" name="file_pendukung_2" class="form-control" value="Surat Balasan Cabor Futsal.pdf">
                                </div>
                                <div>
                                    <label>File Disposisi</label>
                                    <input type="file" name="file_pendukung_2" class="form-control">
                                </div>

                                <div class="col text-right mt-3">
                                    <button class="btn btn-primary" onclick="simpanPerubahan()">Simpan Perubahan</button>
                                </div>
                        </div>
                        </form>
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