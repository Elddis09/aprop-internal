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

<main class="content p-3">
    <div class="container-fluid">

        <div class="print-button-wrapper">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="zmdi zmdi-print"></i> Cetak
            </button>
        </div>

        <div class="table-container">
            <table class="table-receipt">
                <tr>
                    <td style="width: 20%; text-align: center" rowspan="2" class="vertical-middle">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL3i6VHFbddiBnbZrqHoPptmuLaSezDgSFag&s" alt="Logo Koni Kota Bandung" class="logo" />
                    </td>
                    <td colspan="2" class="text-center col-header-main">
                        <strong>
                            KOMITE OLAHRAGA NASIONAL INDONESIA<br />
                            KOTA BANDUNG <br />
                        </strong>
                        Sekretariat: Jl. Jakarta No. 18 Tlp/Fax : (022) 7275739<br />
                        Website: www.koni-kotabandung.or.id Email: sekretariat@koni-kotabandung.or.id
                    </td>
                </tr>
                <tr class="middle-line">
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="w-100 no-border">
                            <tr>
                                <td style="width: 50%;"><strong> TELAH TERIMA DARI : </strong></td>
                                <td style="width: 50%;" class="left-align-content">:
                                    {{ strtoupper($proposal->pengcab) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="w-100 no-border">
                            <tr>
                                <td style="width: 50%;"><strong> KEPADA YTH : </strong></td>
                                <td style="width: 50%;" class="left-align-content">: KONI KOTA BANDUNG</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="w-100 no-border">
                            <tr>
                                <td style="width: 50%;" class="text-center vertical-middle">
                                    <strong> BERUPA </strong><br />
                                    <input type="checkbox" checked />Surat
                                    <input type="checkbox" />Proposal
                                    <input type="checkbox" />Barang
                                </td>
                                <td style="width: 50%;" id="proposal-reference" class="left-align-content vertical-middle">: {{$proposal->no_surat}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p class="text-center" style="color: black; margin-bottom: 5px;"><strong> PERIHAL </strong></p>
                        <p class="text-center" style="color: black; margin-top: 0;">{{$proposal->perihal}}.</p>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" class="qr-code-cell">
                        {{-- Ganti div #qrcode dengan tag img langsung --}}
                        @if(isset($proposal) && Route::has('proposal.tracking.public'))
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(route('proposal.tracking.public', $proposal->id)) }}&size=120x120" alt="QR Code Tracking Proposal" class="img-fluid">
                        @else
                        {{-- Fallback jika proposal tidak ada atau rute tidak terdefinisi --}}
                        <p>QR Code tidak tersedia.</p>
                        @endif
                        <p>* Scan untuk melacak status berkas ini.</p>
                        <p>Atau kunjungi link berikut: <br>
                            {{-- Pastikan ini juga hanya muncul jika proposal dan rute ada --}}
                            @if(isset($proposal) && Route::has('proposal.tracking.public'))
                            {{ route('proposal.tracking.public', ['id' => $proposal->id]) }}
                            @else
                            Tidak ada link
                            @endif
                        </p>
                    </td>
                    <td class="text-center vertical-middle info-cell">
                        <strong> KETERANGAN </strong>
                    </td>
                    <td class="text-center vertical-middle info-cell">
                        {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center vertical-middle info-cell">
                        {{$proposal->pengaju}} <br />
                        ({{$proposal->no_telepon}})
                    </td>
                    <td class="text-center vertical-middle salma-cell">
                        <strong>
                            {{$proposal->nama_petugas}}
                            <br />
                            <br />
                            <br />
                            Petugas
                        </strong>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</main>

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