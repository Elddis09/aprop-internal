@extends('Layouts.header')

@section('content')

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <!-- <img src="{{ asset('assets/images/logo.png') }}" width="48" height="48" alt="APROP"> -->
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
                        <h2>Bank Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Seluruh Data Proposal</li>
                        </ul>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="input-group m-b-0">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari No. Surat, Perihal, Cabor..." value="{{ request('search') }}">
                            <span class="input-group-addon" id="searchButton">
                                <i class="zmdi zmdi-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Daftar Seluruh Proposal</strong> Yang Telah Diajukan</h2>
                            <ul class="header-dropdown">
                                <li>
                                    <a href="{{ route('proposal.export.csv') }}" class="btn btn-success btn-sm">
                                        <i class="zmdi zmdi-download"></i> Export Csv
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div class="body project_report">
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No</th>
                                            <th style="width: 8%;">Status</th>
                                            <th style="width: 10%;">Posisi Terkini</th>
                                            <th style="width: 10%;">No surat</th>
                                            <th style="width: 20%; max-width: 200px; white-space: normal; word-wrap: break-word;">Perihal</th>
                                            <th style="width: 70%; max-width: 500px; white-space: normal; word-wrap: break-word;">Judul</th>
                                            <th style="width: 6%;">Berupa</th>
                                            <th style="width: 6%;">Nama Pengaju</th>
                                            <th style="width: 6%;">Cabor/Pemohon</th>
                                            <th style="width: 7%;">Tgl Pengajuan</th>
                                            <th style="width: 6%;">Petugas</th>
                                            <th class="text-center" style="width: 4%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proposals as $proposal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                $lowerStatus = Str::lower($proposal->status);
                                                @endphp

                                                @if($lowerStatus == 'diterima')
                                                <span class="badge badge-warning">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'pending')
                                                <span class="badge badge-warning">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'ditolak')
                                                <span class="badge badge-warning">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'cancel')
                                                <span class="badge badge-danger">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'selesai')
                                                <span class="badge badge-success">{{ $proposal->status }}</span>
                                                @else {{-- Status lain yang mungkin ada di Kotak Masuk --}}
                                                <span class="badge badge-info">{{ $proposal->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($proposal->is_finished && $proposal->currentTrack)
                                                {{-- Jika proposal sudah final, cek apakah to_position null. Jika ya, tampilkan from_position. --}}
                                                @if($proposal->currentTrack->to_position === null)
                                                <span class="text-dark"><strong>{{ ucfirst($proposal->currentTrack->from_position) }}</strong></span>
                                                @else
                                                {{-- Ini untuk kasus final tapi to_position tidak null (misal: disetujui tapi masih ada target posisi yang sebenarnya tidak relevan) --}}
                                                <span class="text-dark"><strong>{{ ucfirst($proposal->currentTrack->to_position) }}</strong></span>
                                                @endif
                                                @elseif($proposal->currentTrack)
                                                {{-- Jika belum final, tampilkan to_position seperti biasa --}}
                                                <span class="text-dark"><strong>{{ ucfirst($proposal->currentTrack->to_position) }}</strong></span>
                                                @else
                                                <span class="badge badge-danger text-dark">Belum dalam proses / Status Awal</span>
                                                @endif
                                            </td>
                                            <td>{{ $proposal->no_surat }}</td>
                                            <td style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; min-height: 2.8em; vertical-align: top;">{{ $proposal->perihal }}</td>
                                            <td class="project-title" style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; min-height: 2.8em; vertical-align: top;">
                                                <h6 style="margin-bottom: 0;">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" style="display: block; white-space: normal; word-wrap: break-word;">
                                                        {{ $proposal->judul_berkas }}
                                                    </a>
                                                </h6>
                                            </td>
                                            <td>{{$proposal->jenis_berkas}}</td>
                                            <td>{{ $proposal->pengaju }}</td>
                                            <td>
                                                @if($proposal->mitra)
                                                {{ strtoupper($proposal->mitra->nama) }}
                                                @else
                                                {{ strtoupper($proposal->nama_cabor) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}
                                            </td>
                                            <td>{{ $proposal->nama_petugas }}</td>
                                            <td class="project-actions">
                                                <div class="actions d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" class="btn btn-neutral btn-sm">
                                                        <i class="zmdi zmdi-eye col-green"></i>
                                                    </a>
                                                    <a href="{{ route('superadmin.proposal.edit', $proposal->id) }}" class="btn btn-neutral btn-sm">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="12" class="text-center">Tidak ada proposal baru di kotak masuk Anda.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

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