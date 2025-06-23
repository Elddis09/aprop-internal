@extends('Layouts.header')

@section('content')

@php
use App\Models\Mitra;
use App\Models\Cabor; // Pastikan model Cabor di-import di Blade jika Anda membutuhkannya langsung, meskipun tidak untuk kasus ini.
// Menguraikan string jenis_berkas menjadi array untuk pengecekan checkbox
$jenisBerkasArray = explode(',', $proposal->jenis_berkas ?? '');




// Tentukan nilai yang harus terpilih di dropdown
$selectedValue = '';
$isFound = false; // Flag untuk menandai apakah sudah ada kecocokan

// PRIORITAS 1: Cek apakah ini Mitra yang sudah ada berdasarkan mitra_id di proposal
if ($proposal->mitra_id) {
    $selectedValue = 'mitra-' . $proposal->mitra_id;
    $isFound = true;
} else {
    // PRIORITAS 2: Jika tidak ada mitra_id, coba cocokkan dengan NAMA Cabang Olahraga dari API
    // Asumsi: proposal->cabang_olahraga berisi NAMA cabor jika itu berasal dari API/data custom
    foreach ($caborData as $cabor) {
        // Penting: Pastikan perbandingan ini PERSIS sama dengan cara data disimpan di DB.
        // strtolower(trim()) digunakan untuk mengatasi perbedaan casing dan spasi ekstra.
        if (trim(strtolower($proposal->cabang_olahraga)) == trim(strtolower($cabor->nama_cabor))) {
            $selectedValue = $cabor->api_cabor_id; // Nilai option adalah api_cabor_id
            $isFound = true;
            break; // Hentikan loop jika sudah cocok
        }
    }
}

if (!$isFound) {
    $selectedValue = 'lainnya';
}

$selectedValue = old('cabang_olahraga', $selectedValue);


@endphp

<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
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
                        <h2>Update Proposal</h2>
                        <ul class="breadcrumb padding-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="zmdi zmdi-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active">Edit Proposal</li>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Form Edit Proposal</strong> <small>Silahkan Edit Data Proposal Berikut</small> </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="px-4">
                                <div class="card p-4">
                                    <h4 class="fw-bold mb-3">Informasi Pengaju</h4>

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    {{-- FORM UPDATE --}}
                                    <form action="{{ route('superadmin.proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') {{-- Penting untuk method PUT/PATCH --}}

                                        <div class="row mb-3">
                                            <div class="col-12 text-muted">
                                                <label for="pengaju">Nama Pengaju</label>
                                                <input type="text" name="pengaju" class="form-control"
                                                    value="{{ old('pengaju', $proposal->pengaju) }}">
                                            </div>
                                            <div class="col-12 text-muted mt-2">
                                                <label for="pengcab">Nama Pengcab/Organisasi</label>
                                                <input type="text" name="pengcab" class="form-control"
                                                    value="{{ old('pengcab', $proposal->pengcab) }}">
                                            </div>
                                            <div class="form-group mb-3 mt-2">
                                                <label for="cabang_olahraga" class="form-label fw-bold">Cabang Olahraga / Nama Pemohon</label>
                                                <select name="cabang_olahraga" id="cabang_olahraga" class="form-control" required>
                                                    <option value="">Pilih Cabang Olahraga atau Pemohon</option>
                                                    <optgroup label="Cabang Olahraga">
                                                        @foreach($caborData as $cabor)
                                                        <option value="{{ $cabor->api_cabor_id }}"
                                                            {{ ($selectedValue == $cabor->api_cabor_id) ? 'selected' : '' }}>
                                                            {{ $cabor->nama_cabor }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="Pemohon Terdaftar">
                                                        @foreach($mitras as $mitra)
                                                        <option value="mitra-{{ $mitra->id }}"
                                                            {{ ($selectedValue == 'mitra-' . $mitra->id) ? 'selected' : '' }}>
                                                            {{ $mitra->nama }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <option value="lainnya"
                                                        {{ ($selectedValue == 'lainnya') ? 'selected' : '' }}>
                                                        Lainnya (Tambah Pemohon Baru)
                                                    </option>
                                                </select>
                                                @error('cabang_olahraga')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Field untuk nama mitra baru, muncul jika 'lainnya' dipilih --}}
                                            <div class="mb-3 text-muted" id="nama_mitra_baru_container" style="display: none;">
                                                <label for="nama_mitra_baru">Nama Pemohon Baru (jika Lainnya dipilih)</label>
                                                <input type="text" name="nama_mitra_baru" id="nama_mitra_baru" class="form-control"
                                                    value="{{ old('nama_mitra_baru', ($selectedValue == 'lainnya') ? $proposal->cabang_olahraga : '') }}">
                                                @error('nama_mitra_baru')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 text-muted">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat"
                                                    value="{{ old('alamat', $proposal->alamat) }}">
                                            </div>
                                            <div class="mb-3 text-muted">
                                                <label for="jabatan">Jabatan/Sebagai</label>
                                                <input type="text" name="jabatan" class="form-control"
                                                    value="{{ old('jabatan', $proposal->jabatan) }}">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col text-muted">
                                                    <label for="no_telepon">Nomor Telepon</label>
                                                    <input type="text" name="no_telepon" class="form-control"
                                                        value="{{ old('no_telepon', $proposal->no_telepon) }}">
                                                </div>
                                                <div class="col text-muted">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email', $proposal->email) }}">
                                                </div>
                                            </div>

                                            <h4 class="fw-bold mt-4 mb-3">Informasi Berkas</h4>

                                            <div class="mb-3">
                                                <label for="no_surat">Nomor Surat</label>
                                                <input type="text" name="no_surat" class="form-control"
                                                    value="{{ old('no_surat', $proposal->no_surat) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="perihal">Perihal</label>
                                                <input type="text" name="perihal" class="form-control"
                                                    value="{{ old('perihal', $proposal->perihal) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_berkas" class="form-label">Jenis Berkas</label><br>
                                                <div class="d-flex flex-wrap gap-4">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="surat" id="jenis_berkas1"
                                                            {{ in_array('surat', old('jenis_berkas', $jenisBerkasArray)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas1">Surat</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="proposal" id="jenis_berkas2"
                                                            {{ in_array('proposal', old('jenis_berkas', $jenisBerkasArray)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas2">Proposal</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="barang" id="jenis_berkas3"
                                                            {{ in_array('barang', old('jenis_berkas', $jenisBerkasArray)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="jenis_berkas3">Barang</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="judul_berkas">Judul Berkas</label>
                                                <input type="text" name="judul_berkas" class="form-control"
                                                    value="{{ old('judul_berkas', $proposal->judul_berkas) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_surat">Tanggal Surat</label>
                                                <input type="date" name="tgl_surat" class="form-control"
                                                    value="{{ old('tgl_surat', $proposal->tgl_surat) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Tanggal Pengajuan</label>
                                                <input type="date" name="tgl_pengajuan" min="{{ \Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                                    value="{{ old('tgl_pengajuan', $proposal->tgl_pengajuan) }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label>File Utama</label>
                                                <input type="file" name="file_utama" class="form-control">
                                                @if ($proposal->file_utama)
                                                    <small class="text-muted">File saat ini: <a href="{{ Storage::url($proposal->file_utama) }}" target="_blank">Lihat File</a></small>
                                                @endif
                                            </div>

                                            <h4 class="fw-bold mt-4 mb-3">Penerima Berkas</h4>
                                            <div class="mb-3">
                                                <label for="nama_petugas">Nama Petugas</label>
                                                <input type="text" name="nama_petugas" class="form-control"
                                                    value="{{ old('nama_petugas', $proposal->nama_petugas) }}">
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn submit-button">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        const caborSelect = document.getElementById('cabang_olahraga');
        const namaMitraBaruContainer = document.getElementById('nama_mitra_baru_container');
        const namaMitraBaruInput = document.getElementById('nama_mitra_baru');

        function toggleNamaMitraBaru() {
            if (caborSelect.value === 'lainnya') {
                namaMitraBaruContainer.style.display = 'block';
                namaMitraBaruInput.setAttribute('required', 'required');
            } else {
                namaMitraBaruContainer.style.display = 'none';
                namaMitraBaruInput.removeAttribute('required');
            }
        }

        caborSelect.addEventListener('change', toggleNamaMitraBaru);

        // Panggil fungsi ini sekali saat halaman dimuat untuk mengatur tampilan awal
        toggleNamaMitraBaru();
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