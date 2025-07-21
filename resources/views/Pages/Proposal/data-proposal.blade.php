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
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow rounded w-100" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif
                        <h2>Data Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Data Proposal Yang Dikelola</li>
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
                            <h2><strong>Daftar Proposal</strong> Yang Anda Kelola</h2>

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
                                            <th style="width: 3%; text-align: center;">No</th>
                                            <th style="width: 8%; text-align: center;">Status</th>
                                            <th style="width: 10%; text-align: center;">Posisi Terkini</th>
                                            <th style="width: 7%; max-width: 80px; text-align: center; white-space: normal; word-wrap: break-word;">No Surat</th> {{-- Reduced width for No Surat --}}
                                            <th style="width: 4%; text-align: center;">Kategori</th>
                                            <th style="width: 18%; max-width: 220px; white-space: normal; word-wrap: break-word; text-align: center;">Perihal</th> {{-- Increased width for Perihal --}}
                                            <th style="width: 22%; max-width: 280px; white-space: normal; word-wrap: break-word; text-align: center;">Judul</th> {{-- Adjusted width for Judul --}}
                                            <th style="width: 6%; text-align: center;">Berupa</th>
                                            <th style="width: 6%; text-align: center;">Nama Pengaju</th>
                                            <th style="width: 6%; text-align: center;">Cabor/Pemohon</th>
                                            <th style="width: 7%; text-align: center;">Tgl Pengajuan</th>
                                            <th style="width: 6%; text-align: center;">Petugas</th>
                                            <th class="text-center" style="width: 4%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($proposals as $proposal)
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center;">{{ $loop->iteration + ($proposals->currentPage() - 1) * $proposals->perPage() }}</td>

                                            <td style="vertical-align: middle; text-align: center;">
                                                @php
                                                $lowerStatus = Str::lower($proposal->status);
                                                @endphp

                                                @if($lowerStatus == 'diterima')
                                                <span class="badge badge-success">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'pending')
                                                <span class="badge badge-warning">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'ditolak')
                                                <span class="badge badge-danger">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'cancel' || $lowerStatus == 'dibatalkan')
                                                <span class="badge badge-danger">{{ $proposal->status }}</span>
                                                @elseif($lowerStatus == 'selesai')
                                                <span class="badge badge-success">{{ $proposal->status }}</span>
                                                @else
                                                <span class="badge badge-info">{{ $proposal->status }}</span>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                @if($proposal->is_finished && $proposal->currentTrack)
                                                @if($proposal->currentTrack->to_position === null)
                                                {{-- Menggunakan accessor formatted_from_position --}}
                                                <span class="text-dark"><strong>{{ $proposal->currentTrack->formatted_from_position }}</strong></span>
                                                @else
                                                {{-- Menggunakan accessor formatted_to_position --}}
                                                <span class="text-dark"><strong>{{ $proposal->currentTrack->formatted_to_position }}</strong></span>
                                                @endif
                                                @elseif($proposal->currentTrack)
                                                {{-- Menggunakan accessor formatted_to_position --}}
                                                <span class="text-dark"><strong>{{ $proposal->currentTrack->formatted_to_position }}</strong></span>
                                                @else
                                                <span class="badge badge-secondary text-dark">Belum Diproses</span>
                                                @endif
                                            </td>
                                            {{-- MODIFIED: Reduced width, added white-space and word-wrap for "No Surat" --}}
                                            <td style="vertical-align: middle; text-align: center; white-space: normal; word-wrap: break-word;">{{ $proposal->no_surat }}</td>

                                            <td style="vertical-align: middle; text-align: center;">
                                                @php
                                                $kategoriAsli = $proposal->kategoriBerkas ?? '-';
                                                $kategoriFormatted = '';

                                                switch ($kategoriAsli) {
                                                case 'undangan':
                                                $kategoriFormatted = 'Perm. Undangan';
                                                break;
                                                case 'peminjaman':
                                                $kategoriFormatted = 'Perm. Peminjaman';
                                                break;
                                                case 'BantuanDana':
                                                $kategoriFormatted = 'Perm. Dana';
                                                break;
                                                case 'lainnya':
                                                $kategoriFormatted = 'Perm. Lainnya';
                                                break;
                                                default:
                                                $kategoriFormatted = ucfirst($kategoriAsli);
                                                break;
                                                }
                                                @endphp
                                                {{ $kategoriFormatted }}
                                            </td>
                                            {{-- MODIFIED: Increased width for "Perihal" --}}
                                            <td style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; vertical-align: middle; text-align: left;">{{ $proposal->perihal }}</td>
                                            {{-- MODIFIED: Adjusted width for "Judul" --}}
                                            <td class="project-title" style="white-space: normal; word-wrap: break-word; font-size: 0.875rem; line-height: 1.4; vertical-align: middle; text-align: left;">
                                                <h6 style="margin-bottom: 0;">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" style="display: block; white-space: normal; word-wrap: break-word;">
                                                        @if ($proposal->judul_berkas)
                                                        {{ $proposal->judul_berkas }}
                                                        @else
                                                        -
                                                        @endif
                                                    </a>
                                                </h6>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">{{$proposal->jenis_berkas}}</td>
                                            <td style="vertical-align: middle; text-align: center;">{{ $proposal->pengaju }}</td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                @if($proposal->mitra)
                                                {{ strtoupper($proposal->mitra->nama) }}
                                                @else
                                                {{ strtoupper($proposal->nama_cabor) }}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">{{ $proposal->nama_petugas }}</td>
                                            <td class="project-actions" style="vertical-align: middle; text-align: center;">
                                                <div class="actions d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('superadmin.proposal.show', $proposal->id) }}" class="btn btn-neutral btn-sm" title="Lihat Proposal">
                                                        <i class="zmdi zmdi-eye col-green"></i>
                                                    </a>
                                                    <a href="{{ route('superadmin.proposal.edit', $proposal->id) }}" class="btn btn-neutral btn-sm" title="Edit Proposal">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="13" class="text-center" style="vertical-align: middle;">Tidak ada proposal yang ditemukan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $proposals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 20);
        }
    }, 2000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');

        if (searchInput && searchButton) {
            function performSearch() {
                const searchValue = searchInput.value;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.delete('page');
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
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

<script src="{{ asset('assets/js/pages/index.js') }}"></script>

</body>

</html>
@endsection