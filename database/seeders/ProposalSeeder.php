<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;
use App\Models\ProposalTrack;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Temukan atau buat user 'Super Admin' yang akan menjadi pemilik proposal
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'super_admin',
                'password' => Hash::make('123456'),
                'role' => 'superadmin',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $proposalsData = [
            // Proposal 1
            [
                'no_surat' => '001/PBSI/VI/2025',
                'perihal' => 'Permohonan Dana Pembinaan Atlet Junior',
                'judul_berkas' => 'Proposal Anggaran Program Pembinaan Bulutangkis Junior 2025',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Bambang Sudiro',
                'cabang_olahraga' => 'Bulutangkis',
                'tgl_pengajuan' => '2025-05-20',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diterima',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Proposal ini berisi permohonan dana untuk program pembinaan atlet bulutangkis junior tahun 2025, mencakup anggaran pelatihan, peralatan, dan kompetisi.',
                'tujuan_berkas' => 'Kepala Dinas Pemuda dan Olahraga Provinsi',
                'no_telepon' => '081234567890',
                'email' => 'bambang.sudiro@example.com',
                'alamat' => 'Jl. Pahlawan No. 12, Bandung',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 2
            [
                'no_surat' => '002/PRSI/VI/2025',
                'perihal' => 'Pengajuan Program Latihan Intensif Tim Renang',
                'judul_berkas' => 'Proposal Pelatihan Tim Renang Pra-PON 2025',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Dewi Sartika',
                'cabang_olahraga' => 'Renang',
                'tgl_pengajuan' => '2025-05-21',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Pengajuan program latihan intensif untuk tim renang menghadapi Pra-PON 2025, termasuk jadwal latihan, kebutuhan gizi, dan psikologis atlet.',
                'tujuan_berkas' => 'Komite Olahraga Nasional Indonesia (KONI) Provinsi',
                'no_telepon' => '081345678901',
                'email' => 'dewi.sartika@example.com',
                'alamat' => 'Perumahan Griya Indah Blok C No. 5, Cimahi',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 3
            [
                'no_surat' => '003/PBVSI/VI/2025',
                'perihal' => 'Permintaan Fasilitas GOR untuk Pelatda Voli',
                'judul_berkas' => 'Surat Permohonan Pemanfaatan GOR KONI untuk Pelatda Voli',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Rudi Hartono',
                'cabang_olahraga' => 'Bola Voli',
                'tgl_pengajuan' => '2025-05-22',
                'nama_petugas' => 'Admin Utama',
                'status' => 'revisi',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Surat permohonan penggunaan fasilitas GOR KONI untuk kegiatan pemusatan latihan daerah (Pelatda) tim bola voli provinsi.',
                'tujuan_berkas' => 'Kepala Pengelola Sarana dan Prasarana Olahraga KONI',
                'no_telepon' => '081456789012',
                'email' => 'rudi.hartono@example.com',
                'alamat' => 'Jl. Olahraga Raya No. 30, Soreang',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 4
            [
                'no_surat' => '004/PERPANI/VI/2025',
                'perihal' => 'Laporan Pertanggungjawaban Dana Kejuaraan Daerah Panahan',
                'judul_berkas' => 'Surat LPJ Kejurda Panahan Provinsi Jawa Barat 2024',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Siti Aminah',
                'cabang_olahraga' => 'Panahan',
                'tgl_pengajuan' => '2025-05-23',
                'nama_petugas' => 'Admin Utama',
                'status' => 'disetujui',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Laporan pertanggungjawaban penggunaan dana untuk penyelenggaraan Kejuaraan Daerah Panahan Provinsi Jawa Barat tahun 2024, dilampiri bukti-bukti transaksi.',
                'tujuan_berkas' => 'Divisi Keuangan KONI Provinsi',
                'no_telepon' => '081567890123',
                'email' => 'siti.aminah@example.com',
                'alamat' => 'Jl. Panahan Indah No. 8, Lembang',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 5
            [
                'no_surat' => '005/FIRI/VI/2025',
                'perihal' => 'Usulan Pengadaan Peralatan Renang',
                'judul_berkas' => 'Proposal Pengadaan Peralatan Renang Standar Internasional',
                'jenis_berkas' => 'barang',
                'pengaju' => 'PT Harmoni Jaya',
                'cabang_olahraga' => 'Renang',
                'tgl_pengajuan' => '2025-05-24',
                'nama_petugas' => 'Admin Utama',
                'status' => 'ditolak',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Usulan pengadaan peralatan renang dengan standar internasional untuk mendukung latihan dan kompetisi atlet renang nasional.',
                'tujuan_berkas' => 'Divisi Logistik dan Peralatan KONI',
                'no_telepon' => '081678901234',
                'email' => 'harmoni.jaya@example.com',
                'alamat' => 'Komplek Bisnis Sentosa Kav. 15, Gedebage',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 6
            [
                'no_surat' => '006/FORKI/VI/2025',
                'perihal' => 'Pembaruan Data Anggota Kontingen Karate',
                'judul_berkas' => 'Surat Pembaruan Daftar Anggota Kontingen Karate Nasional 2025',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Anton Wijaya',
                'cabang_olahraga' => 'Karate',
                'tgl_pengajuan' => '2025-05-25',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diterima',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Surat pembaruan dan verifikasi data anggota kontingen karate yang akan diberangkatkan untuk kompetisi nasional 2025.',
                'tujuan_berkas' => 'Sekretaris Umum KONI Provinsi',
                'no_telepon' => '081789012345',
                'email' => 'anton.wijaya@example.com',
                'alamat' => 'Jl. Bela Diri No. 7, Antapani',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 7
            [
                'no_surat' => '007/PBVSI/VI/2025',
                'perihal' => 'Permohonan Bantuan Transportasi Pelatihan Atlet',
                'judul_berkas' => 'Proposal Anggaran Transportasi Atlet Voli Pantai',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Maria Kusumawati',
                'cabang_olahraga' => 'Bola Voli',
                'tgl_pengajuan' => '2025-05-26',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Permohonan bantuan dana transportasi untuk keperluan pelatihan dan uji coba tanding atlet voli pantai di luar kota.',
                'tujuan_berkas' => 'Kepala Bidang Pembinaan Prestasi KONI',
                'no_telepon' => '081890123456',
                'email' => 'maria.kusuma@example.com',
                'alamat' => 'Jl. Pantai Indah No. 22, Pangandaran',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 8
            [
                'no_surat' => '008/FPTI/VI/2025',
                'perihal' => 'Dokumen Teknis Pengadaan Alat Panjat Tebing',
                'judul_berkas' => 'Proposal Pengadaan Alat Panjat Tebing Standar Internasional',
                'jenis_berkas' => 'barang',
                'pengaju' => 'PT Ketinggian Abadi',
                'cabang_olahraga' => 'Panjat Tebing',
                'tgl_pengajuan' => '2025-05-27',
                'nama_petugas' => 'Admin Utama',
                'status' => 'disetujui',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Dokumen teknis dan penawaran harga untuk pengadaan alat panjat tebing yang memenuhi standar keamanan dan kualitas internasional.',
                'tujuan_berkas' => 'Divisi Pengadaan Barang dan Jasa KONI',
                'no_telepon' => '081901234567',
                'email' => 'ketinggian.abadi@example.com',
                'alamat' => 'Kawasan Industri Raya No. 4, Cikarang',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 9
            [
                'no_surat' => '009/PSSI/VI/2025',
                'perihal' => 'Revisi Anggaran Pembinaan Tim Sepak Bola',
                'judul_berkas' => 'Proposal Revisi Detail Anggaran Pembinaan Tim Sepak Bola U-17',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Bima Perkasa',
                'cabang_olahraga' => 'Sepak Bola',
                'tgl_pengajuan' => '2025-05-28',
                'nama_petugas' => 'Admin Utama',
                'status' => 'revisi',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Proposal revisi anggaran pembinaan tim sepak bola U-17, dengan penyesuaian alokasi dana untuk pelatihan, kompetisi, dan kebutuhan atlet.',
                'tujuan_berkas' => 'Tim Verifikasi Anggaran KONI',
                'no_telepon' => '082123456789',
                'email' => 'bima.perkasa@example.com',
                'alamat' => 'Komplek Stadion Harapan Bangsa No. 1, Bandung',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 10
            [
                'no_surat' => '010/KONI/VI/2025',
                'perihal' => 'Laporan Hasil Evaluasi Program Atlet Berprestasi',
                'judul_berkas' => 'Surat Evaluasi Kinerja Atlet Berprestasi KONI Periode 2024-2025',
                'jenis_berkas' => 'surat',
                'pengaju' => 'KONI Provinsi',
                'cabang_olahraga' => 'Olahraga Umum',
                'tgl_pengajuan' => '2025-05-29',
                'nama_petugas' => 'Admin Utama',
                'status' => 'selesai',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Laporan hasil evaluasi komprehensif terhadap kinerja dan progres atlet berprestasi KONI selama periode 2024-2025.',
                'tujuan_berkas' => 'Ketua Umum KONI Provinsi',
                'no_telepon' => '082234567890',
                'email' => 'koni.provinsi@example.com',
                'alamat' => 'Kantor KONI Provinsi, Jl. Asia Afrika No. 10, Bandung',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 11
            [
                'no_surat' => '011/PERBASI/VI/2025',
                'perihal' => 'Permohonan Kerja Sama Sponsorship Event Basket',
                'judul_berkas' => 'Proposal Sponsorship Turnamen Basket Antar Kota',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'PT Bola Mania',
                'cabang_olahraga' => 'Basket',
                'tgl_pengajuan' => '2025-05-30',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Proposal penawaran kerja sama sponsorship untuk turnamen basket antar kota yang akan diselenggarakan bulan depan, menargetkan pasar remaja.',
                'tujuan_berkas' => 'Divisi Pemasaran dan Kemitraan KONI',
                'no_telepon' => '082345678901',
                'email' => 'pt.bolamania@example.com',
                'alamat' => 'Jl. Industri No. 45, Karawang',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 12
            [
                'no_surat' => '012/PABSI/VI/2025',
                'perihal' => 'Permintaan Pengadaan Barbel Latihan',
                'judul_berkas' => 'Permintaan Pengadaan Barbel Latihan Angkat Besi',
                'jenis_berkas' => 'barang',
                'pengaju' => 'Joko Susilo',
                'cabang_olahraga' => 'Angkat Besi',
                'tgl_pengajuan' => '2025-06-01',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diterima',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Permintaan resmi pengadaan barbel dan alat latihan angkat besi untuk pemusatan latihan atlet provinsi.',
                'tujuan_berkas' => 'Divisi Logistik dan Peralatan KONI',
                'no_telepon' => '082456789012',
                'email' => 'joko.susilo@example.com',
                'alamat' => 'Perumahan Sehat Bugar Blok B No. 9, Subang',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 13
            [
                'no_surat' => '013/PTI/VI/2025',
                'perihal' => 'Pengajuan Anggaran Pengadaan Seragam Atlet Taekwondo',
                'judul_berkas' => 'Proposal Anggaran Pengadaan Seragam Tim Taekwondo Junior',
                'jenis_berkas' => 'barang',
                'pengaju' => 'Linda Sari',
                'cabang_olahraga' => 'Taekwondo',
                'tgl_pengajuan' => '2025-06-02',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Pengajuan anggaran untuk pengadaan seragam baru bagi tim taekwondo junior yang akan berlaga di kejuaraan nasional.',
                'tujuan_berkas' => 'Divisi Pengadaan Barang dan Jasa KONI',
                'no_telepon' => '082567890123',
                'email' => 'linda.sari@example.com',
                'alamat' => 'Jl. Prestasi No. 3, Purwakarta',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 14
            [
                'no_surat' => '014/PERCASI/VI/2025',
                'perihal' => 'Laporan Konsolidasi Data Peserta Lomba Catur',
                'judul_berkas' => 'Surat Finalisasi Data Peserta Kejuaraan Catur Provinsi',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Dewan Catur Nasional',
                'cabang_olahraga' => 'Catur',
                'tgl_pengajuan' => '2025-06-03',
                'nama_petugas' => 'Admin Utama',
                'status' => 'selesai',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Surat yang berisi laporan konsolidasi dan finalisasi data peserta yang terdaftar untuk Kejuaraan Catur Tingkat Provinsi.',
                'tujuan_berkas' => 'Bidang Data dan Informasi KONI',
                'no_telepon' => '082678901234',
                'email' => 'dewan.catur@example.com',
                'alamat' => 'Kantor Percasi Pusat, Jl. Garuda No. 1, Jakarta',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 15
            [
                'no_surat' => '015/PBSI/VI/2025',
                'perihal' => 'Permohonan Dana Operasional Sekretariat Cabor',
                'judul_berkas' => 'Proposal Dana Rutin Operasional Sekretariat PBSI',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Sekretaris PBSI',
                'cabang_olahraga' => 'Bulutangkis',
                'tgl_pengajuan' => '2025-06-04',
                'nama_petugas' => 'Admin Utama',
                'status' => 'ditolak',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Permohonan dana untuk mendukung operasional rutin sekretariat PBSI, termasuk kebutuhan administrasi dan kegiatan harian.',
                'tujuan_berkas' => 'Kepala Divisi Dana dan Usaha KONI',
                'no_telepon' => '082789012345',
                'email' => 'sekretaris.pbsi@example.com',
                'alamat' => 'Gedung Olahraga Badminton, Jl. Raya Atlet No. 5, Bogor',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 16
            [
                'no_surat' => '016/DISPORA/VI/2025',
                'perihal' => 'Usulan Pembelian Matras Latihan',
                'judul_berkas' => 'Proposal Pengadaan Matras Latihan Standar Baru',
                'jenis_berkas' => 'barang',
                'pengaju' => 'Dinas Olahraga',
                'cabang_olahraga' => 'Senam',
                'tgl_pengajuan' => '2025-06-05',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Usulan pembelian matras latihan baru dengan spesifikasi standar untuk mendukung kegiatan senam dan kebugaran di pusat pelatihan.',
                'tujuan_berkas' => 'Unit Pengadaan Dinas Olahraga',
                'no_telepon' => '082890123456',
                'email' => 'dinas.olahraga@example.com',
                'alamat' => 'Kantor Dispora Kota, Jl. Kebon Sirih No. 1, Cirebon',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 17
            [
                'no_surat' => '017/KONI/VI/2025',
                'perihal' => 'Revisi Laporan Keuangan Tahunan KONI',
                'judul_berkas' => 'Surat Perbaikan Laporan Keuangan KONI Tahun Anggaran 2024',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Divisi Keuangan KONI',
                'cabang_olahraga' => 'Olahraga Umum',
                'tgl_pengajuan' => '2025-06-06',
                'nama_petugas' => 'Admin Utama',
                'status' => 'revisi',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Surat resmi yang berisi perbaikan dan penyesuaian pada laporan keuangan tahunan KONI untuk tahun anggaran 2024.',
                'tujuan_berkas' => 'Badan Pemeriksa Keuangan (BPK) Provinsi',
                'no_telepon' => '082901234567',
                'email' => 'keuangan.koni@example.com',
                'alamat' => 'Kantor BPK Provinsi, Jl. Diponegoro No. 20, Bandung',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 18
            [
                'no_surat' => '018/KOMUNITAS/VI/2025',
                'perihal' => 'Permohonan Izin Penggunaan Fasilitas GOR untuk Umum',
                'judul_berkas' => 'Surat Permohonan Izin Penggunaan GOR Masyarakat',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Komunitas Sehat Bugar',
                'cabang_olahraga' => 'Olahraga Umum',
                'tgl_pengajuan' => '2025-06-07',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diterima',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Permohonan izin penggunaan GOR KONI untuk kegiatan olahraga rutin yang diselenggarakan oleh komunitas masyarakat umum.',
                'tujuan_berkas' => 'Manajemen GOR KONI Provinsi',
                'no_telepon' => '083123456789',
                'email' => 'komunitas.sehat@example.com',
                'alamat' => 'Sekretariat Komunitas, Jl. Harmoni No. 5, Garut',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 19
            [
                'no_surat' => '019/PRSI/VI/2025',
                'perihal' => 'Pengajuan Penambahan Nomor Pertandingan di Kejuaraan',
                'judul_berkas' => 'Proposal Penambahan Kategori Pertandingan Renang Junior',
                'jenis_berkas' => 'proposal',
                'pengaju' => 'Pelatih Renang',
                'cabang_olahraga' => 'Renang',
                'tgl_pengajuan' => '2025-06-08',
                'nama_petugas' => 'Admin Utama',
                'status' => 'diproses',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Pengajuan untuk penambahan nomor pertandingan baru dalam kategori renang junior di kejuaraan tingkat provinsi.',
                'tujuan_berkas' => 'Ketua Bidang Pertandingan PRSI Provinsi',
                'no_telepon' => '083234567890',
                'email' => 'pelatih.renang@example.com',
                'alamat' => 'Kolam Renang Tirta Kencana, Jl. Air Mancur No. 10, Kuningan',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
            // Proposal 20
            [
                'no_surat' => '020/KONTRAKTOR/VI/2025',
                'perihal' => 'Laporan Progres Pembangunan Lapangan Futsal KONI',
                'judul_berkas' => 'Surat Laporan Progres Pembangunan Lapangan Futsal Tahap II',
                'jenis_berkas' => 'surat',
                'pengaju' => 'Kontraktor Jaya',
                'cabang_olahraga' => 'Futsal',
                'tgl_pengajuan' => '2025-06-09',
                'nama_petugas' => 'Admin Utama',
                'status' => 'selesai',
                'user_id' => $superAdminUser->id,
                'ringkasan_berkas' => 'Laporan terkini mengenai progres pembangunan lapangan futsal di kompleks KONI, mencakup tahap kedua pekerjaan konstruksi.',
                'tujuan_berkas' => 'Kepala Divisi Proyek KONI',
                'no_telepon' => '083345678901',
                'email' => 'kontraktor.jaya@example.com',
                'alamat' => 'Kantor Kontraktor Jaya, Jl. Pembangunan No. 5, Sukabumi',
                'no_telepon_petugas' => '085123456789', // Tambahkan no_telepon_petugas
            ],
        ];

        foreach ($proposalsData as $data) {
            $proposal = Proposal::create($data);

            // Membuat track awal berdasarkan status proposal
            ProposalTrack::create([
                'proposal_id' => $proposal->id,
                'status_label' => Str::title($proposal->status),
                'keterangan' => 'Status awal proposal saat diajukan.',
                'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addMinutes(1),
                'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addMinutes(1),
            ]);

            // Tambahkan track tambahan untuk mensimulasikan alur sesuai status
            if ($proposal->status != 'diterima') {
                if ($proposal->status == 'diproses' || $proposal->status == 'revisi' || $proposal->status == 'disetujui' || $proposal->status == 'ditolak' || $proposal->status == 'selesai') {
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Diproses',
                        'keterangan' => 'Proposal sedang dalam tinjauan awal oleh petugas.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addHours(2),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addHours(2),
                    ]);
                }

                if ($proposal->status == 'revisi') {
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Revisi',
                        'keterangan' => 'Mohon lengkapi dokumen yang kurang atau perbaiki format penulisan. Detail terlampir.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(1),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(1),
                    ]);
                } elseif ($proposal->status == 'disetujui') {
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Disetujui',
                        'keterangan' => 'Proposal Anda disetujui. Silakan ambil surat persetujuan di kantor KONI dalam 3 hari kerja.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                    ]);
                } elseif ($proposal->status == 'ditolak') {
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Ditolak',
                        'keterangan' => 'Maaf, proposal tidak dapat kami proses lebih lanjut karena tidak memenuhi kriteria. Detail alasan penolakan dapat dilihat di lampiran.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                    ]);
                } elseif ($proposal->status == 'selesai') {
                    // Untuk status 'selesai', biasanya melewati 'disetujui' terlebih dahulu
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Disetujui',
                        'keterangan' => 'Proposal Anda disetujui dan siap untuk proses finalisasi.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(2),
                    ]);
                    ProposalTrack::create([
                        'proposal_id' => $proposal->id,
                        'status_label' => 'Selesai',
                        'keterangan' => 'Proses proposal Anda telah selesai dan dana sudah dicairkan. Harap segera berikan laporan pertanggungjawaban setelah kegiatan.',
                        'created_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(3),
                        'updated_at' => Carbon::parse($proposal->tgl_pengajuan)->addDays(3),
                    ]);
                }
            }
        }
    }
}