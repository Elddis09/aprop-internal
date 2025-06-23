@extends('Layouts.header')

@section('content')

<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
        </div>
        <p>Please wait...</p>
    </div>
</div>

<section>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold mt-4 mb-3">Informasi Pengaju</h5>
                                <p><strong>ID Proposal:</strong> {{ $proposal->id }}</p>
                                  <p><strong> {{ strtoupper($proposal->pengcab) }}</strong>
                                <p><strong>Cabor/Pemohon:</strong> @if($proposal->mitra)
                                    {{ strtoupper($proposal->mitra->nama) }}
                                    @else
                                    {{ strtoupper($proposal->nama_cabor) }}
                                    @endif
                                </p>
                                <p><strong>Nama Pengaju:</strong> {{ $proposal->pengaju }}</p>
                                <p><strong>Jabatan/Sebagai:</strong> {{ $proposal->jabatan }}</p>
                            </div>
                            <div class="col-md-6 mt-5">
                                <p><strong>Alamat:</strong> {{ $proposal->alamat }}</p>
                                 <p><strong>Alamat:</strong> {{ $proposal->alamat }}</p>
                                    <strong>Email:</strong>
                                    @if ($proposal->email)
                                    {{ $proposal->email }}
                                    @else
                                    -
                                    @endif
                                    </p>
                                <p><strong>No Telepon:</strong> {{ $proposal->no_telepon }}</p>
                            </div>
                        </div>

                        <hr>

                        <h5 class="fw-bold mt-4 mb-3">Informasi Berkas</h5>
                        
                        <p><strong>No Surat:</strong> {{ $proposal->no_surat }}</p>
                        <p><strong>Judul Berkas:</strong> {{ $proposal->judul_berkas }}</p>
                        
                        <p><strong>Perihal:</strong> {{ $proposal->perihal }}</p> 
                        
                        <p><strong>Jenis Berkas:</strong> {{ $proposal->jenis_berkas }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</p>
                        <!-- <p><strong>Tujuan Berkas:</strong> {{ $proposal->tujuan_berkas }}</p> -->
                        <p><strong>Status :</strong> {{ $proposal->status }}</p>
                        <!-- <p><strong>Ringkasan Berkas:</strong> {{ $proposal->ringkasan_berkas }}</p> -->

                        <h5 class="fw-bold mt-4 mb-3">Lampiran Utama</h5>
                        <p><strong>File Utama:</strong>
                            @if ($proposal->file_utama)
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
                            <h5 class="fw-bold mb-0">Status Berkas</h5>
                        </div>
                    </div>

                    <div class="body">
                        <ul class="cbp_tmtimeline">

                            <!-- Item pertama: Proposal berhasil dikirim -->
                            <li>
                                <time class="cbp_tmtime">
                                    <span class="hidden">{{ $proposal->created_at->format('d/m/Y') }}</span>
                                    <span class="large">{{ $proposal->created_at->format('H:i') }}</span>
                                </time>
                                <div class="cbp_tmicon bg-primary">
                                    <i class="zmdi zmdi-long-arrow-right"></i>
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>Proposal berhasil diajukan</span>
                                </div>
                            </li>
                            <!-- Looping untuk track proposal -->
                            @forelse ($proposal->tracks as $track)
                            <li>
                                <time class="cbp_tmtime" datetime="{{ $track->created_at->format('Y-m-d\TH:i:s') }}">
                                    <span>{{ $track->created_at->format('H:i') }}</span>
                                    <span>{{ $track->created_at->format('d/m/Y') }}</span>
                                </time>
                                <div class="cbp_tmicon
                                    @if(Str::contains($track->status_label, ['Diterima', 'Diajukan'])) bg-secondary
                                    @elseif(Str::contains($track->status_label, ['Diproses','Tinjau','Analisa'])) bg-info
                                    @elseif(Str::contains($track->status_label, ['Pending','Revisi','Dikembalikan'])) bg-warning
                                    @elseif(Str::contains($track->status_label, ['Disetujui','Dicairkan','Selesai'])) bg-success
                                    @elseif(Str::contains($track->status_label, 'Ditolak')) bg-danger
                                    @else bg-secondary
                                    @endif">
                                    <i class="zmdi zmdi-label"></i>
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>{{ $track->status_label }}</span>
                                    @if ($track->actorUser)
                                    oleh <a href="javascript:void(0);">{{ $track->actorUser->name }}</a>
                                    @else
                                    oleh Sistem
                                    @endif
                                    @if ($track->keterangan)
                                    <p>Keterangan: {{ $track->keterangan }}</p>
                                    @endif
                                    @if ($track->from_position && $track->to_position)
                                    <!-- <p>Dari: {{ ucfirst($track->from_position) }} -> Ke: {{ ucfirst($track->to_position) }}</p> -->
                                    @elseif ($track->to_position)
                                    <!-- <p>Posisi: {{ ucfirst($track->to_position) }}</p> -->
                                    @endif
                                </div>
                            </li>
                            @empty
                            <!-- {{-- Jika tidak ada track sama sekali --}} -->
                            <li>
                                <time class="cbp_tmtime">
                                    <span class="hidden">{{ $proposal->created_at->format('d/m/Y') }}</span>
                                    <span class="large">{{ $proposal->created_at->format('H:i') }}</span>
                                </time>
                                <div class="cbp_tmicon bg-primary">
                                    <i class="zmdi zmdi-long-arrow-right"></i>
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>Proposal berhasil dikirim (belum ada proses lanjutan)</span>
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
                        @if ($proposal->currentTrack)
                        <div class="form-group mb-3">
                            <p><strong>Posisi Terakhir :</strong> {{ ucfirst($proposal->currentTrack->to_position) }}</p>
                        </div>
                        @else
                        <div class="form-group mb-3">
                            <p><strong>Posisi Terakhir :</strong> Belum dalam proses</p>
                        </div>
                        @endif
                        <p>
                            <strong>Catatan Revisi/Tindakan Lanjut:</strong>
                            @if($proposal->currentTrack)
                            {{ $proposal->currentTrack->keterangan ?? '-' }}
                            @else
                            -
                            @endif
                        </p>
                         @if ($proposal->data_updated_at) {{-- <<< GUNAKAN KOLOM BARU INI --}}
                            <p class="text-muted text-sm mt-3">
                                <i class="zmdi zmdi-info-outline"></i>
                                Data terakhir diperbarui pada tanggal
                                <strong>{{ \Carbon\Carbon::parse($proposal->data_updated_at)->translatedFormat('d F Y') }}</strong>
                                di jam
                                <strong>{{ \Carbon\Carbon::parse($proposal->data_updated_at)->translatedFormat('H:i') }}</strong>
                                @if ($proposal->dataUpdatedByUser) {{-- <<< GUNAKAN RELASI BARU INI --}}
                                oleh <strong>{{ $proposal->dataUpdatedByUser->name }}</strong>.
                                @else
                                .
                                @endif
                            </p>
                            @endif
                        <!-- {{-- Tambahan keterangan jika proposal sudah selesai --}} -->
                        @if ($proposal->is_finished || in_array($proposal->status, ['disetujui', 'selesai']))
                        <p class="text-info mt-3">
                            *Proses proposal telah selesai. Anda akan dihubungi pihak KONI untuk langkah selanjutnya.
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

@endsection