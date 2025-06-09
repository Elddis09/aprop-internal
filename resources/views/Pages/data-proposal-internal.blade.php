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

<div class="d-flex">
    @include('Layouts.sidebar')

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
                            <li class="breadcrumb-item active">Data Proposal</li>
                        </ul>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="input-group m-b-0">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search by No. Surat, Perihal, Cabor..." value="{{ request('search') }}">
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
                            <h2><strong>Proposal</strong> list</h2>

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
                                            <th style="width: 10%;">No surat</th> {{-- Sedikit dikurangi --}}
                                            {{-- Header Perihal: Lebarkan width dan max-width --}}
                                            <th style="width: 20%; max-width: 200px; white-space: normal; word-wrap: break-word;">Perihal</th>
                                            {{-- Header Judul: Lebarkan width dan max-width --}}
                                            <th style="width: 70%; max-width: 500px; white-space: normal; word-wrap: break-word;">Judul</th>
                                            <th style="width: 6%;">Berupa</th> {{-- Sedikit dikurangi --}}
                                            <th style="width: 6%;">Pengaju</th> {{-- Sedikit dikurangi --}}
                                            <th style="width: 6%;">Cabor/Mitra</th> {{-- Sedikit dikurangi --}}
                                            <th style="width: 7%;">Tanggal Pengajuan</th> {{-- Sedikit dikurangi --}}
                                            <th style="width: 6%;">Petugas</th> {{-- Sedikit dikurangi --}}
                                            <th class="text-center" style="width: 4%;">Aksi</th> {{-- Sedikit dikurangi --}}
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
                                                <span class="badge badge-success">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'diproses')
                                                <span class="badge badge-info">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'revisi')
                                                <span class="badge badge-warning">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'disetujui' || $lowerStatus == 'selesai')
                                                <span class="badge badge-success">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'ditolak')
                                                <span class="badge badge-danger">{{ $proposal->status }}</span>
                                                @else
                                                <span class="badge badge-secondary">{{ $proposal->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $proposal->no_surat }}</td>
                                            {{-- Sel Perihal: Min-height untuk 2 baris, lebar disesuaikan --}}
                                            <td style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; min-height: 2.8em; vertical-align: top;">{{ $proposal->perihal }}</td>
                                            {{-- Sel Judul: Min-height untuk 2 baris, lebar disesuaikan --}}
                                            <td class="project-title" style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; min-height: 2.8em; vertical-align: top;">
                                                <h6 style="margin-bottom: 0;">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" style="display: block; white-space: normal; word-wrap: break-word;">
                                                        {{ $proposal->judul_berkas }}
                                                    </a>
                                                </h6>
                                            </td>
                                            <td>{{$proposal->jenis_berkas}}</td>
                                            <td>{{ $proposal->pengaju }}</td>
                                            <td>{{ $proposal->nama_cabor }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}
                                            </td>
                                            <td>{{ $proposal->nama_petugas }}</td>
                                            <td class="project-actions">
                                                <div class="actions">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" class="btn btn-neutral btn-sm mb-2">
                                                        Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data proposal</td>
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