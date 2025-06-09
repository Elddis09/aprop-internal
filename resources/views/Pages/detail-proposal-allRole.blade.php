@extends('Layouts.header')

@section('content')
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

@include('Layouts.sidebar')

<section class="content">
    <div class="container-fluid">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Detail Proposal</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                        {{-- Menggunakan judul_berkas sesuai kolom di DB --}}
                        <li class="breadcrumb-item">{{ $proposal->judul_berkas }}</li>
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
                            <div class="col-md-12 text-right">
                                <a href="{{ route('superadmin.proposal.tanda-terima', $proposal->id) }}" class="btn btn-primary">Tanda Terima</a>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#qrCodeModal">Share</button>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold mt-4 mb-3">Informasi Pengaju</h5>
                                <p><strong>ID Proposal:</strong> {{ $proposal->id }}</p>
                                {{-- Menggunakan cabang_olahraga sesuai kolom di DB --}}
                                <p><strong>Cabang Olahraga:</strong> {{ $proposal->nama_cabor }}</p>
                                <p><strong>Nama Pengaju:</strong> {{ $proposal->pengaju }}</p>
                            </div>
                            <div class="col-md-6 mt-5">
                                <p><strong>Alamat:</strong> {{ $proposal->alamat }}</p>
                                <p><strong>Email:</strong> {{ $proposal->email }}</p>
                                <p><strong>No Telepon:</strong> {{ $proposal->no_telepon }}</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="fw-bold mt-4 mb-3">Informasi Proposal</h5>
                        {{-- Menggunakan judul_berkas sesuai kolom di DB --}}
                        <p><strong>Judul:</strong> {{ $proposal->judul_berkas }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</p>
                        {{-- Menggunakan tujuan_berkas sesuai kolom di DB --}}
                        <p><strong>Tujuan:</strong> {{ $proposal->tujuan_berkas }}</p>
                        <p><strong>Status:</strong> {{ $proposal->status }}</p>
                        <p><strong>No Surat:</strong> {{ $proposal->no_surat }}</p>
                        {{-- Menggunakan ringkasan_berkas sesuai kolom di DB --}}
                        <p><strong>Ringkasan:</strong> {{ $proposal->ringkasan_berkas }}</p>
                        {{-- Jenis Berkas: Jika disimpan sebagai string koma-separated --}}
                        <p><strong>Jenis Berkas:</strong> {{ $proposal->jenis_berkas }}</p>

                        <h5 class="fw-bold mt-4 mb-3">Lampiran Utama</h5>
                        <p><strong>File Utama:</strong>
                            @if ($proposal->file_utama)
                            {{-- Pastikan rute 'proposal.file' atau apapun yang benar --}}
                            <a href="{{ Storage::url($proposal->file_utama) }}" target="_blank">{{ basename($proposal->file_utama) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="row align-items-center p-3">
                        <div class="col">
                            <h5 class="fw-bold mb-0">Status Proposal</h5>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateStatusModal">Ubah Status</button>
                        </div>
                    </div>

                    <div class="body">
                        <ul class="cbp_tmtimeline">
                            <li>
                                <time class="cbp_tmtime"><span class="hidden">{{ $proposal->created_at->format('d/m/Y') }}</span><span class="large">{{ $proposal->created_at->format('H:i') }}</span></time>
                                <div class="cbp_tmicon"><i class="zmdi zmdi-upload"></i></div>
                                <div class="cbp_tmlabel"><span>Proposal berhasil dikirim</span></div>
                            </li>

                            @forelse ($proposal->tracks as $track)
                            <li>
                                <time class="cbp_tmtime">
                                    <span>{{ $track->created_at->format('H:i') }}</span> {{-- Changed to H:i for consistency --}}
                                    <span>{{ $track->created_at->format('d/m/Y') }}</span>
                                </time>
                                <div class="cbp_tmicon
                                        @if(Str::contains($track->status_label, 'Diterima')) bg-success
                                        @elseif(Str::contains($track->status_label, ['diproses','tinjau','analisa'])) bg-info
                                        @elseif(Str::contains($track->status_label, 'Revisi')) bg-warning
                                        @elseif(Str::contains($track->status_label, ['disetujui','dicairkan','Selesai'])) bg-success
                                        @elseif(Str::contains($track->status_label, 'Ditolak')) bg-danger {{-- Tambahkan ini untuk status Ditolak --}}
                                        @else bg-primary
                                        @endif">
                                    <i class="zmdi zmdi-label"></i>
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>{{ $track->status_label }}</span>
                                    @if ($track->actor) oleh <a href="javascript:void(0);">{{ $track->actor }}</a> @endif
                                    @if ($track->file_attachment)
                                    <div>
                                        <a href="{{ route('proposal.track.download', basename($track->file_attachment)) }}" target="_blank">
                                            <i class="zmdi zmdi-attachment"></i> {{ basename($track->file_attachment) }}
                                        </a>
                                    </div>
                                    @endif
                                    @if ($track->keterangan)<p>{{ $track->keterangan }}</p>@endif
                                </div>
                            </li>
                            @empty
                            <li>
                                <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-info-outline"></i></div>
                                <div class="cbp_tmlabel">
                                    <h2>Belum ada riwayat update status.</h2>
                                    <p>Silakan tunggu update dari pihak KONI.</p>
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
                        <h5 class="fw-bold mt-4 mb-3">Catatan :</h5>
                        <p><strong>Status:</strong> {{ ucfirst($proposal->status) }}</p>
                        <p>
                            <strong>Revisi:</strong>
                            @if($proposal->status == 'revisi' && $proposal->tracks->last())
                            {{ $proposal->tracks->last()->keterangan }}
                            @else
                            -
                            @endif
                        </p>
                        <p>
                            <strong>Tindakan Lanjut:</strong>
                            @if($proposal->tracks->last())

                            {{ $proposal->tracks->last()->keterangan ?? '-' }}


                            {{-- @php
                        $lastTrack = $proposal->tracks->last();
                    @endphp
                    @if($lastTrack && in_array(Str::lower($lastTrack->status_value), ['disetujui', 'ditolak', 'revisi', 'selesai']))
                        {{ $lastTrack->keterangan ?? '-' }}
                            @else
                            -
                            @endif --}}
                            @else
                            -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bagikan Proposal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <p>Scan QR Code atau salin link berikut:</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(route('proposal.tracking.public', $proposal->id)) }}&size=200x200" alt="QR Code">
                <div class="mt-3">
                    <input type="text" class="form-control text-center" value="{{ route('proposal.tracking.public', $proposal->id) }}" readonly onclick="this.select()">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- Tambahkan input hidden untuk 'finalize_action' --}}
            <form action="{{ route('superadmin.proposal.ubah-status', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    @php $currentTrack = $proposal->tracks->last(); @endphp

                    <div class="form-group mb-3">
                        <label>Posisi Saat Ini</label>
                        {{-- Menggunakan position dari track terakhir jika ada --}}
                        <div><span class="badge bg-primary">{{ ucfirst($currentTrack->position ?? 'Belum Ditentukan') }}</span></div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status Proposal Saat Ini</label>
                        <div>
                            <span class="badge
                                @if($proposal->status == 'disetujui') bg-success
                                @elseif($proposal->status == 'ditolak') bg-danger
                                @elseif($proposal->status == 'revisi') bg-warning text-dark
                                @elseif($proposal->status == 'diproses') bg-info text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($proposal->status ?? '-') }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="posisiProposal">Update Posisi</label>
                        <select class="form-control" id="posisiProposal" name="posisiProposal">
                            <option disabled selected>-- Pilih Posisi --</option>
                            @foreach (['frontoffice','backoffice','stafpimpinan','sekretarisumum','stafbinpres','binpres','sekretarisdua','ketuadua','ketuaumum','keuangan','bai'] as $posisi) {{-- Perbaiki 'sekretarisII' menjadi 'sekretarisdua' --}}
                            <option value="{{ $posisi }}" {{ ($currentTrack && $currentTrack->position == $posisi) ? 'selected' : '' }}>{{ ucfirst($posisi) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="statusProposal">Update Status</label>
                        <select class="form-control" id="statusProposal" name="statusProposal">
                            <option disabled selected>-- Pilih Status --</option>
                            <option value="diterima" {{ $proposal->status == 'diterima' ? 'selected' : '' }}>Proposal Diterima</option>
                            <option value="diproses" {{ $proposal->status == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="disetujui" {{ $proposal->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ $proposal->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="revisi" {{ $proposal->status == 'revisi' ? 'selected' : '' }}>Butuh Revisi</option>
                            <option value="selesai" {{ $proposal->status == 'selesai' ? 'selected' : '' }}>Selesai</option> {{-- Tambahkan status 'selesai' jika ingin digunakan --}}
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Contoh: Proposal sedang ditinjau ulang">
                    </div>

                    {{-- Tambahkan input untuk file attachment di update status modal jika diperlukan --}}
                    {{-- <div class="form-group mb-3">
                        <label for="file_attachment">Lampiran Tambahan (opsional)</label>
                        <input type="file" class="form-control" id="file_attachment" name="file_attachment">
                    </div> --}}

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        {{-- Tombol "Proposal Selesai" akan mengirim input hidden 'finalize_action' --}}
                        <button type="submit" class="btn btn-success" name="finalize_action" value="1">Proposal Selesai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@endsection