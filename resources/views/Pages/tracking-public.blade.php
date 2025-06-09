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

<section> {{-- Tambahkan class "content" agar styling dari layout utama berfungsi --}}
    <div class="container-fluid"> {{-- Ganti "container" dengan "container-fluid" agar responsif --}}
        <div class="row clearfix"> {{-- Tambahkan row clearfix untuk struktur grid yang benar --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold mt-4 mb-3">Informasi Pengaju</h5>
                                <p><strong>ID Proposal:</strong> {{ $proposal->id }}</p>
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
                        <p><strong>Judul Proposal:</strong> {{ $proposal->judul_berkas }}</p> {{-- Menggunakan judul_berkas sesuai struktur yang ada --}}
                        <p><strong>Tanggal Proposal:</strong> {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}</p>
                        <p><strong>Tujuan Proposal:</strong> {{ $proposal->tujuan_berkas }}</p> {{-- Menggunakan tujuan_berkas --}}
                        <p><strong>Status Proposal:</strong> {{ $proposal->status }}</p>
                        <p><strong>No Surat:</strong> {{ $proposal->no_surat }}</p> {{-- Menambahkan No Surat yang sebelumnya hilang --}}
                        <p><strong>Ringkasan Proposal:</strong> {{ $proposal->ringkasan_berkas }}</p> {{-- Menggunakan ringkasan_berkas --}}
                        <p><strong>Jenis Berkas:</strong> {{ $proposal->jenis_berkas }}</p> {{-- Menambahkan Jenis Berkas --}}

                        <h5 class="fw-bold mt-4 mb-3">Lampiran Utama</h5>
                        <p><strong>File Utama:</strong>
                            @if ($proposal->file_utama)
                            <a href="{{ Storage::url($proposal->file_utama) }}" target="_blank">{{ basename($proposal->file_utama) }}</a>
                            @else
                            Tidak ada
                            @endif
                        </p>
                        {{-- Bagian file pendukung dihilangkan --}}
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="row align-items-center p-3">
                        <div class="col">
                            <h5 class="fw-bold mb-0">Status Proposal</h5>
                        </div>
                    </div>

                    <div class="body">
                        <ul class="cbp_tmtimeline">

                            <li>
                                <time class="cbp_tmtime">
                                    <span class="hidden">{{ $proposal->created_at->format('d/m/Y') }}</span>
                                    <span class="large">{{ $proposal->created_at->format('H:i') }}</span>
                                </time>
                                <div class="cbp_tmicon">
                                    <i class="zmdi zmdi-upload"></i>
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>Proposal berhasil dikirim</span>
                                </div>
                            </li>

                            @forelse ($proposal->tracks as $track)
                            <li>
                                <time class="cbp_tmtime" datetime="{{ $track->created_at->format('Y-m-d\TH:i:s') }}">
                                    <span>{{ $track->created_at->format('H:i') }}</span>
                                    <span>{{ $track->created_at->format('d/m/Y') }}</span>
                                </time>
                                <div class="cbp_tmicon
                                    @if(Str::contains($track->status_label, 'Diterima')) bg-success
                                    @elseif(Str::contains($track->status_label, ['diproses','tinjau','analisa'])) bg-info
                                    @elseif(Str::contains($track->status_label, 'Revisi')) bg-warning
                                    @elseif(Str::contains($track->status_label, ['disetujui','dicairkan','Selesai'])) bg-success
                                    @elseif(Str::contains($track->status_label, 'Ditolak')) bg-danger
                                    @else bg-primary
                                    @endif">
                                    @if (Str::contains($track->status_label, 'Diterima'))
                                    <i class="zmdi zmdi-inbox"></i>
                                    @elseif (Str::contains($track->status_label, ['diproses','tinjau','analisa']))
                                    <i class="zmdi zmdi-hourglass-outline"></i>
                                    @elseif (Str::contains($track->status_label, 'disetujui'))
                                    <i class="zmdi zmdi-check-circle"></i>
                                    @elseif (Str::contains($track->status_label, 'Revisi'))
                                    <i class="zmdi zmdi-edit"></i>
                                    @elseif (Str::contains($track->status_label, 'dicairkan'))
                                    <i class="zmdi zmdi-money-box"></i>
                                    @elseif (Str::contains($track->status_label, 'Diajukan'))
                                    <i class="zmdi zmdi-file-text"></i>
                                    @elseif (Str::contains($track->status_label, 'Ditolak'))
                                    <i class="zmdi zmdi-close-circle"></i>
                                    @else
                                    <i class="zmdi zmdi-label"></i>
                                    @endif
                                </div>
                                <div class="cbp_tmlabel">
                                    <span>{{ $track->status_label }}</span>
                                    @if ($track->actor) oleh <a href="javascript:void(0);">{{ $track->actor }}</a> @endif
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
        </div> {{-- Penutup row clearfix --}}
    </div> {{-- Penutup container-fluid --}}
</section>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

@endsection