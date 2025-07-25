@extends('Layouts.header')

@section('content')

<div class="print-button-container">
    <button class="btn btn-primary" onclick="window.print()">
        Cetak Kartu Disposisi
    </button>
</div>
<div class="print-button-container">
    {{-- Tampilkan tombol Generate No Agenda HANYA jika agenda_number belum ada --}}
    @if (empty($proposal->agenda_number))
    <button id="generateAgendaButton"
        class="btn btn-primary"
        data-url="{{ route('proposal.generateAgenda', ['proposal' => $proposal->id]) }}">
        Generate No Agenda
    </button>
    <small class="form-text text-muted">Klik tombol ini untuk menghasilkan nomor agenda proposal.</small>
    @else
    <button class="btn btn-success" disabled>Nomor Agenda Sudah Digenerate</button>
    @endif
</div>

<div class="card-disposisi">
    <table>
        <thead>
            <tr>
                <td >
                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL3i6VHFbddiBnbZrqHoPptmuLaSezDgSFag&s"
                        alt="Logo Koni Kota Bandung"
                        class="logo"
                        {{-- Hapus inline style width dan height di sini --}}
                        style="display: block; margin: 0 auto;" /> {{-- Hanya sisakan display dan margin --}}
               
                </td>
                <td class="header-title">
                    <h3>KARTU DISPOSISI</h3>
                </td>
                <td class="header-info-atas" colspan="4">
                    <div class="header-info-item">
                        <span class="header-info-label">NO AGENDA</span>
                        {{-- Menggunakan agenda_number dari objek proposal --}}
                        <span class="header-info-value" id="agendaNumberDisplay">
                            @if ($proposal->agenda_number)
                            {{ $proposal->agenda_number }}
                            @else
                            Belum Digenerate
                            @endif
                        </span>
                    </div>
                    <div class="header-info-item">
                        <span class="header-info-label">TGL. MASUK</span>
                        {{-- Menggunakan tgl_pengajuan dari objek proposal dan memformatnya --}}
                        <span class="header-info-value">{{ \Carbon\Carbon::parse($proposal->tgl_pengajuan)->format('d/m/y') }}</span>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="info-label">DARI / PENGIRIM</td>
                <td class="info-field">
                    : {{ $proposal->pengcab ?? '___' }}
                </td>
                <td class="no-tgl-surat-label">No. Surat</td>
                <td class="no-tgl-surat-field">
                    {{ $proposal->no_surat ?? '___' }}
                </td>
                <td class="no-tgl-surat-label">Tgl. Surat</td>
                <td class="no-tgl-surat-field">{{ \Carbon\Carbon::parse($proposal->tgl_surat)->format('d/m/y') }}</td>
            </tr>
            <tr>
                <td class="info-label">PERIHAL</td>
                <td class="info-field" colspan="6">
                    : {{ $proposal->perihal ?? '___' }}
                </td>
            </tr>
            <tr>
                <td class="info-label">SIFAT</td>
                <td class="info-field" colspan="6">
                    :
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatTembusan" name="sifat[]" value="Tembusan/Informasi">
                        <label class="form-check-label-sifat" for="sifatTembusan">TEMBUSAN/INFORMASI</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatBantuan" name="sifat[]" value="Bantuan/Penawaran">
                        <label class="form-check-label-sifat" for="sifatBantuan">BANTUAN/PENAWARAN</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatRekomendasi" name="sifat[]" value="Rekomendasi">
                        <label class="form-check-label-sifat" for="sifatRekomendasi">REKOMENDASI</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatPentingRahasia" name="sifat[]" value="Penting/Rahasia">
                        <label class="form-check-label-sifat" for="sifatPentingRahasia">PENTING/RAHASIA</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatSegera" name="sifat[]" value="Segera">
                        <label class="form-check-label-sifat" for="sifatSegera">SEGERA</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="sifatLaporan" name="sifat[]" value="Laporan">
                        <label class="form-check-label-sifat" for="sifatLaporan">LAPORAN</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="disposisi-header-cell">DISPOSISI</td>
            </tr>
            <tr>
                <td class="disposisi-notes-cell">
                    <label>Catatan/Saran Sekretaris Umum:</label>
                </td>
                <td class="disposisi-kelengkapan-cell">
                    <label>Kelengkapan:</label>
                </td>
                <td class="disposisi-diteruskan-cell" colspan="4">
                    <label>Diteruskan ke:</label>
                    <div class="disposisi-option-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaUmumSU" />
                            <label class="form-check-label" for="ketuaUmumSU">Ketua Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bendaharaUmumSU" />
                            <label class="form-check-label" for="bendaharaUmumSU">Bendahara Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaBAI" />
                            <label class="form-check-label" for="wkKetuaBAI">Ketua BAI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkSekretarisISU" />
                            <label class="form-check-label" for="wkSekretarisISU">Wk. Sekretaris I</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkSekretarisIISU" />
                            <label class="form-check-label" for="wkSekretarisIISU">Wk. Sekretaris II</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkSekretarisIIISU" />
                            <label class="form-check-label" for="wkSekretarisIIISU">Wk. Sekretaris III</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkSekretarisIVSU" />
                            <label class="form-check-label" for="wkSekretarisIVSU">Wk. Sekretaris IV</label>
                        </div><br>
                        ---------------------------
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer-notes-label">Sekretaris Umum :</td>
                <td class="footer-notes-label">Paraf :</td>
                <td class="footer-notes-label" colspan="4">Tgl. :</td>
            </tr>
            <tr>
                <td class="disposisi-notes-cell" colspan="2">
                    <label>Catatan/Saran Wakil Sekretaris I / II / III / IV</label>
                </td>
                <td class="disposisi-diteruskan-cell" colspan="4">
                    <label>Diteruskan ke:</label>
                    <div class="disposisi-option-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIWS" />
                            <label class="form-check-label" for="wkKetuaIWS">Wk. Ketua I</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIIWS" />
                            <label class="form-check-label" for="wkKetuaIIWS">Wk. Ketua II</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIIIWS" />
                            <label class="form-check-label" for="wkKetuaIIIWS">Wk. Ketua III</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIVWS" />
                            <label class="form-check-label" for="wkKetuaIVWS">Wk. Ketua IV</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaBidangWS" />
                            <label class="form-check-label" for="ketuaBidangWS">Ketua/Wk Ketua Bidang</label>
                        </div><br>
                        ---------------------------
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer-notes-label">
                    Wakil Sekretaris<br />I / II / III / IV :
                </td>
                <td class="footer-notes-label">Paraf :</td>
                <td class="footer-notes-label" colspan="4">Tgl. : </td>
            </tr>
            <tr>
                <td class="disposisi-notes-cell" colspan="2">
                    <label>Catatan/Saran Ketua / Wakil Ketua I / II / III / IV :</label>
                </td>
                <td class="disposisi-diteruskan-cell" colspan="4">
                    <label>Diteruskan ke:</label>
                    <div class="disposisi-option-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaUmumKKWK" />
                            <label class="form-check-label" for="ketuaUmumKKWK">Ketua Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sekretarisUmumKKWK" />
                            <label class="form-check-label" for="sekretarisUmumKKWK">Sekretaris Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bendaharaUmumKKWK" />
                            <label class="form-check-label" for="bendaharaUmumKKWK">Bendahara Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaBAIKKWK" />
                            <label class="form-check-label" for="wkKetuaBAIKKWK">Ketua BAI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaBidangKKWK" />
                            <label class="form-check-label" for="ketuaBidangKKWK">Ketua/Wk Ketua Bidang</label>
                        </div><br>
                        ---------------------------
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer-notes-label">
                    Ketua / Wk. Ketua<br />I / II / III / IV :
                </td>
                <td class="footer-notes-label">Paraf :</td>
                <td class="footer-notes-label" colspan="4">Tgl. : </td>
            </tr>
            <tr>
                <td class="disposisi-notes-cell" colspan="2">
                    <label>Catatan/Saran Ketua Umum :</label>
                </td>
                <td class="disposisi-diteruskan-cell" colspan="4">
                    <label>Diteruskan ke:</label>
                    <div class="disposisi-option-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sekretarisUmumKU" />
                            <label class="form-check-label" for="sekretarisUmumKU">Sekretaris Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bendaharaUmumKU" />
                            <label class="form-check-label" for="bendaharaUmumKU">Bendahara Umum</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaBaIKU" />
                            <label class="form-check-label" for="ketuaBaIKU">Ketua BAI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIKU" />
                            <label class="form-check-label" for="wkKetuaIKU">Wk. Ketua I</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIIKU" />
                            <label class="form-check-label" for="wkKetuaIIKU">Wk. Ketua II</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIIIKU" />
                            <label class="form-check-label" for="wkKetuaIIIKU">Wk. Ketua III</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wkKetuaIVKU" />
                            <label class="form-check-label" for="wkKetuaIVKU">Wk. Ketua IV</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sekretarisIKU" />
                            <label class="form-check-label" for="sekretarisIKU">Sekretaris/I/II/III/IV</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ketuaBidangKU" />
                            <label class="form-check-label" for="ketuaBidangKU">Ketua/Wk Ketua Bidang</label>
                        </div><br>
                        ---------------------------
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer-notes-label">Ketua Umum :</td>
                <td class="footer-notes-label">Paraf :</td>
                <td class="footer-notes-label" colspan="4">Tgl. : </td>
            </tr>
        </tbody>
    </table>
</div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const generateButton = document.getElementById('generateAgendaButton');
        const agendaNumberDisplay = document.getElementById('agendaNumberDisplay');

        if (generateButton) {
            generateButton.addEventListener('click', function() {
                const url = generateButton.dataset.url;

                if (!confirm('Apakah Anda yakin ingin meng-generate nomor agenda untuk proposal ini?')) {
                    return;
                }

                generateButton.innerText = 'Generating...';
                generateButton.disabled = true;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Terjadi kesalahan.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        agendaNumberDisplay.innerText = data.agenda_number;
                        alert(data.message);

                        generateButton.innerText = 'Nomor Agenda Sudah Digenerate';
                        generateButton.classList.remove('btn-primary');
                        generateButton.classList.add('btn-success');
                        generateButton.disabled = true;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses: ' + error.message);
                        generateButton.innerText = 'Generate No Agenda';
                        generateButton.disabled = false;
                    });
            });
        }
    });
</script>
@endpush
@stack('scripts')

@endsection