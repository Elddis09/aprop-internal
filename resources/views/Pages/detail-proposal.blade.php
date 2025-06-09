@extends('Layouts.header')

@section('content')
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino"></div>
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
                    <h2>Detail Proposal</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Proposal {{$proposal->judul}}</a></li>
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
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold mt-4 mb-3">Informasi Pengaju</h5>
                                <p><strong>ID Proposal:</strong>{{ $proposal->id }}</p>
                                <p><strong>Cabang Olahraga:</strong> {{ $proposal->cabang_olahraga }}</p>
                                <p><strong>Nama Pengaju:</strong> {{ $proposal->pengaju }}</p>
                                <p><strong>Jabatan:</strong> Sekretaris</p>
                            </div>
                            <div class="col-md-6 mt-5">
                                <p><strong>Alamat:</strong> {{$proposal->alamat}}</p>
                                <p><strong>Email:</strong> {{$proposal->email}}</p>
                                <p><strong>No Telepon:</strong> {{$proposal->no_telepon}}</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="fw-bold mt-4 mb-3">Informasi Proposal</h5>
                        <p><strong>Judul Proposal:</strong> {{$proposal->judul}}</p>
                        <p><strong>Tanggal Proposal:</strong> {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</p>
                        <p><strong>Tujuan Proposal:</strong> {{ $proposal->tujuan }}</p>
                        <p><strong>Status Proposal:</strong> {{ $proposal->status }}</p>
                        <p><strong>Ringkasan Proposal:</strong> {{ $proposal->ringkasan_proposal }}</p>
                        <p><strong>Lampiran Proposal:</strong>
                            @if($proposal->file_proposal)
                            <a href="{{ route('proposal.file', basename($proposal->file_proposal)) }}" target="_blank">{{ basename($proposal->file_proposal) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>
                        <p><strong>File Pendukung I:</strong>
                            @if($proposal->file_pendukung_1)
                            <a href="{{ route('proposal.file', basename($proposal->file_pendukung_1)) }}" target="_blank">{{ basename($proposal->file_pendukung_1) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>


                        <p><strong>File Pendukung II:</strong>
                            @if($proposal->file_pendukung_2)
                            <a href="{{ route('proposal.file', basename($proposal->file_pendukung_2)) }}" target="_blank">{{ basename($proposal->file_pendukung_2) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>

                        <p><strong>File Pendukung III:</strong>
                            @if($proposal->file_pendukung_3)
                            <a href="{{ route('proposal.file', basename($proposal->file_pendukung_3)) }}" target="_blank">{{ basename($proposal->file_pendukung_3) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>
                    </div>
                </div>
            </div>




            <div class="col-lg-12">
                <div class="card">
                    <h5 class="fw-bold mt-4 mb-3">Status Proposal</h5>
                    <div class="body">
                        <ul class="cbp_tmtimeline">
                            {{-- STEP 1: Tampilkan status pengajuan awal (file proposal utama) --}}
                            @if ($proposal->file_proposal)
                            <li>
                                <time class="cbp_tmtime" datetime="{{ $proposal->created_at->format('Y-m-d\TH:i:s') }}">
                                    <span>{{ $proposal->created_at->format('h:i A') }}</span>
                                    <span>{{ $proposal->created_at->format('d/m/Y') }}</span>
                                    {{-- BARIS DEBUGGING UNTUK PROPOSAL UTAMA --}}
                                    <span style="font-size: 10px; color: red;">DEBUG: {{ $proposal->created_at }}</span>
                                </time>
                                {{-- Tambahkan margin-right atau padding di ikon jika diperlukan via CSS eksternal --}}
                                <div class="cbp_tmicon"><i class="zmdi zmdi-file-text"></i></div>
                                <div class="cbp_tmlabel empty">
                                    <span>Proposal Awal Diajukan</span>
                                    <div>
                                        <span><i class="zmdi zmdi-file"></i> {{ basename($proposal->file_proposal) }}</span>
                                    </div>
                                </div>
                            </li>
                            @endif

                            {{-- STEP 2: Loop melalui setiap riwayat status dari database --}}
                            @forelse ($proposal->tracks as $track)
                            <li>
                                <time class="cbp_tmtime" datetime="{{ $track->created_at->format('Y-m-d\TH:i:s') }}">
                                    <span>{{ $track->created_at->format('h:i A') }}</span>
                                    <span>{{ $track->created_at->format('d/m/Y') }}</span>
                                    {{-- BARIS DEBUGGING UNTUK SETIAP TRACK --}}
                                    <span style="font-size: 10px; color: red;">DEBUG: {{ $track->created_at }}</span>
                                </time>

                                {{-- Tambahkan margin-right atau padding di ikon jika diperlukan via CSS eksternal --}}
                                <div class="cbp_tmicon
                            @if (Str::contains($track->status_label, 'Diterima')) bg-success
                            @elseif (Str::contains($track->status_label, 'diproses') || Str::contains($track->status_label, 'ditinjau') || Str::contains($track->status_label, 'analisa') || Str::contains($track->status_label, 'tinjauan')) bg-info
                            @elseif (Str::contains($track->status_label, 'Revisi')) bg-warning
                            @elseif (Str::contains($track->status_label, 'disetujui') || Str::contains($track->status_label, 'dicairkan') || Str::contains($track->status_label, 'Selesai')) bg-green
                            @else bg-primary
                            @endif">
                                    @if (Str::contains($track->status_label, 'Diterima'))
                                    <i class="zmdi zmdi-inbox"></i>
                                    @elseif (Str::contains($track->status_label, 'diproses'))
                                    <i class="zmdi zmdi-hourglass-outline"></i>
                                    @elseif (Str::contains($track->status_label, 'disetujui'))
                                    <i class="zmdi zmdi-check-circle"></i>
                                    @elseif (Str::contains($track->status_label, 'Revisi'))
                                    <i class="zmdi zmdi-edit"></i>
                                    @elseif (Str::contains($track->status_label, 'dicairkan'))
                                    <i class="zmdi zmdi-money-box"></i>
                                    @elseif (Str::contains($track->status_label, 'Diajukan'))
                                    <i class="zmdi zmdi-file-text"></i>
                                    @else
                                    <i class="zmdi zmdi-label"></i>
                                    @endif
                                </div>

                                <div class="cbp_tmlabel @if(Str::contains($track->status_label, 'Diterima') && $track->file_attachment) empty @endif">
                                    <span>{{ $track->status_label }}</span>
                                    @if ($track->actor)
                                    oleh <a href="javascript:void(0);">{{ $track->actor }}</a>
                                    @endif
                                    @if ($track->file_attachment)
                                    <div>
                                        <a href="{{ route('proposal.track.download', basename($track->file_attachment)) }}" target="_blank">
                                            <span><i class="zmdi zmdi-attachment"></i> {{ basename($track->file_attachment) }}</span>
                                        </a>
                                    </div>
                                    @endif
                                    @if ($track->keterangan)
                                    <p>{{ $track->keterangan }}</p>
                                    @endif
                                </div>
                            </li>
                            @empty
                            <li>
                                <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-info-outline"></i></div>
                                <div class="cbp_tmlabel">
                                    <h2>Belum ada riwayat update status untuk proposal ini.</h2>
                                    <p>Silakan tunggu update dari pihak KONI Kota Bandung.</p>
                                </div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="fw-bold mt-4 mb-3">Catatan :</h5>
                                <p><strong>Status Proposal Telah Selesai Ditinjau</strong></p>
                                <p><strong>Revisi :</strong> -</p>
                                <p><strong>Tindakan Lanjut :</strong> Konfirmasi Kepada Staf Untuk Kunjungan Ke KONI Kota Bandung</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>```
</body>

</html>