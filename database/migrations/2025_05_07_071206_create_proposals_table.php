<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul_berkas');
            $table->string('no_surat');
            $table->text('jenis_berkas');
            $table->string('perihal');
            $table->string('pengaju');
            $table->string('ringkasan_berkas');
            $table->string('tujuan_berkas');
            $table->string('cabang_olahraga');
            $table->string('no_telepon');
            $table->string('email');
            $table->text('alamat');
            $table->date('tgl_pengajuan');
            $table->enum('status', ['disetujui', 'ditolak', 'diproses', 'selesai', 'diterima', 'revisi'])->default('diterima');
            $table->boolean('is_finished')->default(false);
            $table->string('file_utama')->nullable();
            $table->string('nama_petugas');
            $table->string('no_telepon_petugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
