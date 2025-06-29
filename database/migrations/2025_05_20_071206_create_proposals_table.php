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
            $table->string('no_surat')->unique();
            $table->string('agenda_number')->nullable();
            $table->date('tgl_surat');
            $table->text('jenis_berkas');
            $table->enum('kategoriBerkas', ['undangan', 'peminjaman', 'BantuanDana', 'lainnya'])->nullable()->default(null);
            $table->string('perihal');
            $table->string('pengaju');
            $table->string('pengcab');
            $table->string('jabatan');
            $table->string('cabang_olahraga')->nullable();
            $table->foreignId('mitra_id')->nullable()->constrained('mitras')->onDelete('set null');
            $table->string('no_telepon');
            $table->string('email');
            $table->text('alamat');
            $table->date('tgl_pengajuan');
            $table->enum('status', ['disetujui', 'ditolak', 'diproses', 'diterima', 'selesai', 'pending', 'cancel'])->default('pending');
            $table->boolean('is_finished')->default(false);
            $table->string('file_utama')->nullable();
            $table->string('nama_petugas');
            $table->timestamps();
            $table->timestamp('data_updated_at')->nullable();
            $table->unsignedBigInteger('data_updated_by_user_id')->nullable();
            $table->foreign('data_updated_by_user_id')->references('id')->on('users')->onDelete('set null');
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
