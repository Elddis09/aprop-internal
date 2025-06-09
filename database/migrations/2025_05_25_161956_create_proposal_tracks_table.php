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
        Schema::create('proposal_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->onDelete('cascade'); // Link ke tabel proposals
            $table->string('status_label'); // Contoh: "Proposal Telah Diterima"
            $table->string('position')->nullable(); // Posisi atau jabatan yang update status
            $table->string('keterangan')->nullable(); // Catatan tambahan
            $table->string('actor')->nullable(); // Contoh: "Front Office KONI"
            $table->string('file_attachment')->nullable(); // Path file terkait status
            $table->string('file_disposisi')->nullable(); // File disposisi terkait
            $table->timestamps(); // created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_tracks', function (Blueprint $table) {
            $table->dropColumn(['position', 'keterangan', 'file_disposisi']);
        });
    }
};
