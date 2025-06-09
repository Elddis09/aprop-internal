@extends('Layouts.header')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f5f5f5;
    }

    .table-receipt,
    .table-receipt td,
    .table-receipt th {
        border: 1px solid #000;
        background-color: white;
    }

    .table-receipt td,
    .table-receipt th {
        padding: 6px;
        vertical-align: top;
        border-collapse: collapse;
    }

    .no-border {
        border: none !important;
    }

    .logo {
        height: 110px;
        max-width: 100%;
        /* Ensure logo scales within its cell */
    }

    .kop {
        text-align: center;
        font-weight: bold;
    }

    .underline {
        text-decoration: underline;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    .text-center {
        text-align: center;
    }

    .left-align-content {
        text-align: left;
        padding-left: 6px;
    }

    .vertical-middle {
        vertical-align: middle;
    }

    .print-button-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .table-container {
        display: flex;
        justify-content: center;
        overflow-x: auto;
    }

    table.table-receipt {
        width: 100%;
        max-width: 900px;
        border-collapse: collapse;
    }

    .qr-code-cell {
        text-align: center;
        vertical-align: middle;
        width: 20%;
        /* Defined width for the QR code column */
        padding: 8px;
    }

    #qrcode canvas {
        display: block;
        margin: 0 auto;
        border: 1px solid #ccc;
        padding: 3px;
        background-color: white;
    }

    .qr-code-cell p {
        font-size: 9px;
        margin-top: 3px;
        line-height: 2;
        color: #000;
        text-align: center;
    }

    /* Adjust padding for the "Keterangan" and "Tanggal" cells for visual balance */
    .info-cell {
        padding: 8px;
    }

    /* Style for vertical spacing in the Salma cell */
    .salma-cell {
        padding-top: 20px;
        /* Add top padding to create space */
        padding-bottom: 20px;
        /* Add bottom padding */
        min-height: 80px;
        /* Ensure a minimum height for consistent spacing */
        display: table-cell;
        /* Treat as table-cell for vertical-align to work if needed */
        vertical-align: top;
        /* Align content to top within the cell */
    }


    @media print {
        .print-button-wrapper {
            display: none !important;
        }

        body,
        main.content {
            padding: 0 !important;
            margin: 0 !important;
            background-color: white !important;
        }

        /* Adjust QR Code size for print more precisely */
        #qrcode {
            width: 80px !important;
            /* Fixed width for print */
            height: 80px !important;
            /* Fixed height for print */
            overflow: hidden;
            /* Hide overflow if canvas is slightly larger */
            margin: 0 auto !important;
            margin-top: 20px !important;
        }

        #qrcode canvas {
            width: 80px !important;
            height: 80px !important;
            border: none !important;
            padding: 0 !important;
            box-sizing: border-box;
            /* Include padding and border in the element's total width and height */
        }

        /* Ensure widths are more consistent in print */
        .table-receipt {
            width: 100% !important;
            margin: 0 auto !important;
            /* Center the table on the page */
        }

        .table-receipt td,
        .table-receipt th {
            padding: 4px !important;
            /* Reduce padding for print */
        }

        .qr-code-cell {
            width: 20% !important;
            /* Maintain width */
            padding: 4px !important;
        }

        .qr-code-cell p {
            font-size: 7px !important;
            /* Smaller font for print */
            margin-top: 1px !important;
        }

        /* Adjust column widths for the three main columns */
        .col-header-main {
            width: 80% !important;
            /* Adjust as needed */
        }

        /* Further refine spacing for Salma cell in print */
        .salma-cell {
            padding-top: 15px !important;
            /* Less padding in print */
            padding-bottom: 15px !important;
            min-height: 60px !important;
            /* Smaller min-height in print */
        }
    }
</style>

<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Alpino">
        </div>
        <p>Please wait...</p>
    </div>
</div>

<div>
    <main class="content flex-grow-1 p-3 mt-5">
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
                        {{-- Main header, spans 2 columns from the perspective of the *overall* table structure --}}
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
                        {{-- This row is conceptually part of the header, nothing specific for these 2 columns here. --}}
                    </tr>
                    <tr>
                        {{-- Telah Terima Dari --}}
                        <td colspan="3">
                            <table class="w-100 no-border">
                                <tr>
                                    <td style="width: 50%;"><strong> TELAH TERIMA DARI : </strong></td>
                                    <td style="width: 50%;" class="left-align-content">: {{$proposal->nama_cabor}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        {{-- Kepada YTH --}}
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
                        {{-- BERUPA --}}
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
                        {{-- PERIHAL --}}
                        <td colspan="3">
                            <p class="text-center" style="color: black; margin-bottom: 5px;"><strong> PERIHAL </strong></p>
                            <p class="text-center" style="color: black; margin-top: 0;">{{$proposal->perihal}}.</p>
                        </td>
                    </tr>
                    {{-- NEW: Row for QR Code, Keterangan, and Tanggal --}}
                    <tr>
                        <td rowspan="2" class="qr-code-cell">
                            <div id="qrcode"></div>
                            @if(isset($proposal))
                            <p>* Scan untuk melacak proposal ini.</p>
                            @else
                            <p>QR Code tidak tersedia.</p>
                            @endif
                        </td>
                        <td class="text-center vertical-middle info-cell">
                            <strong> KETERANGAN </strong>
                        </td>
                        <td class="text-center vertical-middle info-cell">
                            {{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d M Y') }}
                        </td>
                    </tr>
                    {{-- NEW: Row for Pak Imam and Salma (continuation from previous row due to rowspan) --}}
                    <tr>
                        {{-- QR Code cell is still active due to rowspan --}}
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
</div>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/index.js') }}"></script>

{{-- Include qrcode.js library from a CDN --}}
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const proposalId = {{ $proposal->id ?? 'null' }}; // This will render as an integer or 'null'

        if (proposalId !== null) {
            // Generate the base URL with a placeholder that JS can replace
            const baseUrl = "{{ route('proposal.tracking.public', ['id' => 'QR_ID_PLACEHOLDER']) }}";
            const trackingUrl = baseUrl.replace('QR_ID_PLACEHOLDER', proposalId);

            const qrcodeDiv = document.getElementById("qrcode");
            if (qrcodeDiv) {
                new QRCode(qrcodeDiv, {
                    text: trackingUrl,
                    width: 120,
                    height: 120,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        } else {
            console.warn("Proposal ID not found. QR Code for tracking cannot be generated.");
            const qrcodeDiv = document.getElementById("qrcode");
            if (qrcodeDiv) {
                qrcodeDiv.innerHTML = '<p>QR Code tidak tersedia.</p>';
            }
        }
    });
</script>

@endsection