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
    <div class="d-flex justify-content-end mb-3"> <div class="print-button-container">
            <button class="btn btn-primary" onclick="window.print()">
                Cetak Form Ceklis
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
                        <div class="fw-bold fs-5 mb-0">
                            FORMAT CEKLIS
                        </div>
                        <div class="fw-bold fs-5">
                            PERMOHONAN BANTUAN DANA
                        </div>
                    </td>
                    <td
                        colspan="1"
                        rowspan="2"
                        class="header-cell header-top-right header-catatan-input">
                        <span>Catatan :</span> 
                    </td>
                    <td
                        colspan="1"
                        class="header-cell header-top-right header-tanggal">
                        <span>Tanggal Masuk:</span> <textarea
                            class="header-input-box"
                            rows="1">{{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d/m/y') }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="data-row">
                        <span class="fw-bold">DARI / PENGIRIM :</span>
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
                            rows="2"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="data-row">
                        <span class="fw-bold">PERIHAL :</span>
                        <span>{{$proposal->perihal}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="data-row checkbox-row">
                        <span class="fw-bold me-3">KODE PROPOSAL :</span>
                        <div class="d-inline-block">
                            <label class="checkbox-label"><input type="checkbox" checked />
                                DOP</label>
                            <label class="checkbox-label"><input type="checkbox" /> BKO</label>
                            <label class="checkbox-label"><input type="checkbox" /> MK</label>
                            <label class="checkbox-label"><input type="checkbox" /> PK</label>
                            <label class="checkbox-label"><input type="checkbox" /> MIKP</label>
                            <label class="checkbox-label"><input type="checkbox" /> BP</label>
                            <label class="checkbox-label"><input type="checkbox" /> TC</label>
                            <label class="checkbox-label"><input type="checkbox" /> BPTPK</label>
                            <label class="checkbox-label"><input type="checkbox" /> BKK</label>
                            <label class="checkbox-label"><input type="checkbox" /> KIM</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="section-heading-cell">
                        <div class="section-heading">
                            PERSYARATAN DOKUMEN PENGAJUAN
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                1. DANA OPERASIONAL PEMBINAAN (DOP)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Kalender
                                Pembinaan Prestasi</label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                6. BANTUAN PERLENGKAPAN/PERALATAN (BP)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Daftar dan
                                Spesifikasi Barang/Peralatan</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                2. BANTUAN KEORGANISASIAN (BKO)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> SK
                                Panitia</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Undangan Kegiatan</label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                7. SENTRALISASI / AKLIMATISASI /
                                TRAINING CAMP (TC)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Tempat dan
                                Tanggal Pelaksanaan</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                3. MENGIKUTI KEJUARAAN - KEJUARAAN (MK)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" checked /> Surat
                                Mengikuti Permohonan
                                Pengcab/Pengkot</label>
                            <label class="checkbox-list-item"><input type="checkbox" checked />
                                Proposal Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" checked />
                                Rencana Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" checked /> Nama
                                Atlet dan Nomor Pertandingan yang
                                Diikuti</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Undangan / Brosur Kejuaraan</label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                8. BIAYA PENDIDIKAN, TUNJANGAN PRESTASI
                                & KESEJAHTERAAN (BPTPK)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Biodata
                                Pemohon</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Bukti
                                Pembayaran / Rencana Anggaran Biaya
                                (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Portofolio
                                Prestasi Pemohon</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                4. MELAKSANAKAN KEJUARAAN - KEJUARAAN
                                (PK)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Nomor - Nomor
                                yang Dipertandingkan</label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                9. BANTUAN KADEUDEUH & KESEJAHTERAAN
                                (BKK)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Bukti
                                Pembayaran / Rencana Anggaran Biaya
                                (RAB)</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                5. MENGIKUTI DAN MELAKSANAKAN PELATIHAN
                                / PENATARAN (MIKP)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item">
                                <input type="checkbox" /> Jadwal Kegiatan
                            </label>
                            <label class="checkbox-list-item">
                                <input type="checkbox" /> Daftar Peserta
                            </label>
                        </div>
                    </td>
                    <td colspan="4" class="content-cell">
                        <div class="section-box">
                            <div class="section-title fw-bold">
                                10. KLUB, INSTANSI DAN MASYARAKAT (KIM)
                            </div>
                            <label class="checkbox-list-item"><input type="checkbox" /> Surat
                                Pengantar Permohonan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Proposal
                                Kegiatan</label>
                            <label class="checkbox-list-item"><input type="checkbox" /> Rencana
                                Anggaran Biaya (RAB)</label>
                            <label class="checkbox-list-item">
                                <input type="checkbox" /> Surat
                                Rekomendasi Cabang Olahraga yang
                                Bersangkutan
                            </label>
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