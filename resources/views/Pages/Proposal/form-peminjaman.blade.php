@extends('Layouts.header')

@section('content')
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
        </div>
        <p>Please wait...</p>
    </div>
</div>

<div class="container my-4 outer-wrapper">
    <div class="d-flex justify-content-end mb-3">
        <div class="print-button-container">
            <button class="btn btn-primary" onclick="window.print()">
                Cetak
            </button>
        </div>
    </div>

    <div class="form-wrapper">

        <table class="form-table">
            <thead>
                <tr>
                    <td colspan="2" class="header-cell header-left">
                        <img
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL3i6VHFbddiBnbZrqHoPptmuLaSezDgSFag&s"
                            alt="Logo Kota Bandung"
                            class="img-fluid logo-bandung" />
                    </td>
                    <td colspan="4" class="header-cell header-center">
                        <div class="fw-bold fs-2 mb-0">
                            FORMAT CEKLIS
                        </div>
                        <div class=" fs-5">
                            PEMINJAMAN TEMPAT / BARANG
                        </div>
                    </td>
                    <td
                        colspan="1"
                        rowspan="2"
                        class="header-top-right ">
                        <span>Catatan :</span>
                    </td>
                    <td
                        colspan="1"
                        class="header-cell header-top-right header-paraf-cell">
                        <span>Tanggal Masuk:</span> <textarea
                            class="header-input-box fw-bold"
                            rows="1">{{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d/m/y') }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="data-row-with-content"> {{-- Ganti class menjadi data-row-with-content untuk penyesuaian CSS spesifik --}}
                        <span class="fw-bold">DARI / PENGIRIM :</span> {{-- Pastikan titik dua ada di sini --}}
                        <span>
                            @if($proposal->mitra)
                            {{ strtoupper($proposal->mitra->nama) }}
                            @else
                            CABOR {{ strtoupper($proposal->nama_cabor) }}
                            @endif
                        </span>
                    </td>
                    <td
                        colspan="1"
                        class="header-cell header-top-right header-paraf-cell">
                        <span>Paraf :</span> <textarea
                            class="header-input-box"
                            rows="2"
                            readonly></textarea> {{-- Tambahkan readonly --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="data-row-with-content">
                        <span class="fw-bold">PERIHAL :</span>
                        <span>{{$proposal->perihal}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="data-row-with-content checkbox-row">
                        <span class="fw-bold me-3 ">JENIS PEMINJAMAN :</span>
                        <div class="d-inline-block">
                            <label class="checkbox-label"><input type="checkbox" />
                                BARANG</label>
                            <label class="checkbox-label"><input type="checkbox" /> TEMPAT</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="section-heading-cell">
                        <div class="section-heading">
                            PERSYARATAN DOKUMEN DAN INFORMASI
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                1. PEMINJAMAN BARANG
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan Peminjaman</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Jenis Barang yang Dipinjam</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Kuantitas Barang dan Spesifikasi</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Durasi Peminjaman</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Nomor Telepon yang Dapat Dihubungi</label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                2. PEMINJAMAN TEMPAT
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan Peminjaman</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Jadwal Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Ruangan / Tempat yang Dipinjam</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Jumlah Peserta</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Nomor Telepon yang Dapat Dihubungi</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/index.js') }}"></script>

@endsection