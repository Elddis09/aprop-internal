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

<div class="d-flex">
    @include('Layouts.sidebar')

    <main class="content flex-grow-1 p-3">
        <div class="container-fluid">

            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Detail Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                            <li class="breadcrumb-item active">{{ $proposal->judul_berkas }}</li>
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
                                    <p><strong>Cabor/Pemohon:</strong>
                                        @if($proposal->mitra)
                                        {{ strtoupper($proposal->mitra->nama) }}
                                        @else
                                        {{ strtoupper($proposal->nama_cabor) }}
                                        @endif
                                    </p>
                                    <p><strong>Nama Pengaju:</strong> {{ $proposal->pengaju }}</p>
                                    <p><strong>Jabatan:</strong> {{ $proposal->jabatan }}</p>
                                </div>
                                <div class="col-md-6 mt-5">
                                    <p><strong>Alamat:</strong> {{ $proposal->alamat }}</p>
                                    <p><strong>Email:</strong> {{ $proposal->email }}</p>
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
                            <p><strong>Status:</strong> {{ $proposal->status }}</p>
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
                            <div class="col text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateStatusModal" {{ !$canUpdateStatus ? 'disabled' : '' }}>Ubah Status</button>
                            </div>
                        </div>

                        <div class="body">
                            <ul class="cbp_tmtimeline">
                                <li>
                                    <time class="cbp_tmtime">
                                        <span class="hidden">{{ $proposal->created_at->format('d/m/Y') }}</span>
                                        <span class="large">{{ $proposal->created_at->format('H:i') }}</span>
                                    </time>
                                    <div class="cbp_tmicon bg-primary"><i class="zmdi zmdi-arrow-right"></i></div>
                                    <div class="cbp_tmlabel"><span>Proposal berhasil diajukan</span></div>
                                </li>

                                @forelse ($proposal->tracks as $track)
                                <li class="{{ $track->is_current ? 'active-track' : '' }}">
                                    <time class="cbp_tmtime">
                                        <span>{{ $track->created_at->format('H:i') }}</span>
                                        <span>{{ $track->created_at->format('d M Y') }}</span>
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
                                        @if ($track->status_label === 'Proposal diajukan dan diterima' && $track->actorUser)
                                        <span>Proposal diajukan dan diterima oleh {{ $track->actorUser->name }}</span>
                                        @else
                                        <span>{{ $track->status_label }}</span>
                                        @if ($track->actorUser)
                                        oleh <a href="javascript:void(0);">{{ $track->actorUser->name }}</a>
                                        @else
                                        oleh Sistem
                                        @endif
                                        @endif

                                        @if ($track->keterangan)
                                        <p>Keterangan: {{ $track->keterangan }}</p>
                                        @endif
                                        @if ($track->from_position && $track->to_position && !($track->status_label === 'Proposal diajukan dan diterima' && $track->actorUser))
                                        <p>Dari: {{ ucfirst($track->from_position) }} -> Ke: {{ ucfirst($track->to_position) }}</p>
                                        @elseif ($track->to_position && !($track->status_label === 'Proposal diajukan dan diterima' && $track->actorUser))
                                        <p>Posisi: {{ ucfirst($track->to_position) }}</p>
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
    </main>
</div>

<!-- Modal QR Code -->
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

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('superadmin.proposal.ubah-status', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    @if ($currentPosition)
                    <div class="form-group mb-3">
                        <label>Posisi Terakhir (Proposal Berada)</label>
                        <div><span class="badge bg-primary">{{ ucfirst($currentPosition) }}</span></div>
                    </div>
                    @endif

                    <div class="form-group mb-3">
                        <label>Status Berkas Saat Ini</label>
                        <div>
                            <span class="badge
                                @if($proposal->status == 'disetujui' || $proposal->status == 'selesai') bg-success
                                @elseif($proposal->status == 'ditolak') bg-danger
                                @elseif($proposal->status == 'pending') bg-warning text-dark
                                @elseif($proposal->status == 'diproses' || $proposal->status == 'diterima') bg-info text-dark
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($proposal->status ?? '-') }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="statusProposal">Update Status</label>
                        <select class="form-control" id="statusProposal" name="statusProposal">
                            <option disabled selected>-- Pilih Status --</option>
                            <option value="diproses" {{ $proposal->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="disetujui" {{ $proposal->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ $proposal->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pending" {{ $proposal->status == 'pending' ? 'selected' : '' }}>Pending / Dikembalikan untuk Revisi</option>
                        </select>
                    </div>

                    <!-- Dynamic 'Diteruskan Kepada' dropdown -->
                    <div class="form-group mb-3" id="forwardToSection">
                        <label for="posisiProposal">Diteruskan Kepada :</label>
                        <select name="posisiProposal" class="form-control">
                            <option value="" selected>-- Tidak Diteruskan / Pilih Posisi --</option>
                            @foreach ($availableUsersForPositions as $user)
                            <option value="{{ $user->role }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih posisi ini jika ingin meneruskan proposal ke role lain.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Contoh: Proposal sedang ditinjau ulang">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="submit" class="btn btn-success" name="is_finished_action" value="1">Tandai Selesai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');

        if (searchInput && searchButton) {
            function performSearch() {
                const searchValue = searchInput.value;
                const currentUrl = new URL(window.location.href);

                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }

                window.location.href = currentUrl.toString();
            }

            searchButton.addEventListener('click', performSearch);

            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    performSearch();
                }
            });
        }

        const statusProposalDropdown = document.getElementById('statusProposal');
        const forwardToSection = document.getElementById('forwardToSection');
        const posisiProposalDropdown = forwardToSection ? forwardToSection.querySelector('select[name="posisiProposal"]') : null;

        if (statusProposalDropdown && forwardToSection && posisiProposalDropdown) {
            function toggleForwardToVisibility() {
                const selectedStatus = statusProposalDropdown.value;
                if (selectedStatus === 'disetujui') {
                    forwardToSection.style.display = 'block';
                    posisiProposalDropdown.removeAttribute('disabled');
                } else {
                    forwardToSection.style.display = 'none';
                    posisiProposalDropdown.value = '';
                    posisiProposalDropdown.setAttribute('disabled', 'true');
                }
            }

            toggleForwardToVisibility();

            statusProposalDropdown.addEventListener('change', toggleForwardToVisibility);

            const updateStatusModal = document.getElementById('updateStatusModal');
            if (updateStatusModal) {
                updateStatusModal.addEventListener('shown.bs.modal', function() {
                    toggleForwardToVisibility();
                });
            }
        }
    });
</script>
</body>

</html>