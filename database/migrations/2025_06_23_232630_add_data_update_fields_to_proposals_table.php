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
        Schema::table('proposals', function (Blueprint $table) {
            // Kolom untuk waktu terakhir data proposal diupdate
            // ditempatkan setelah kolom 'updated_at' bawaan Laravel
            $table->timestamp('data_updated_at')->nullable()->after('updated_at');

            // Kolom untuk ID user yang terakhir update data proposal
            // Dibuat nullable agar data lama tidak error, dan dihubungkan ke tabel 'users'
            $table->unsignedBigInteger('data_updated_by_user_id')->nullable()->after('data_updated_at');
            $table->foreign('data_updated_by_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Saat rollback, hapus foreign key constraint dulu
            $table->dropForeign(['data_updated_by_user_id']);
            // Lalu hapus kolom-kolomnya
            $table->dropColumn('data_updated_by_user_id');
            $table->dropColumn('data_updated_at');
        });
    }
};
