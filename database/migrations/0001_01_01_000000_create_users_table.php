<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('klien');
            $table->string('no_telepon')->nullable();  // Kolom untuk nomor telepon
            $table->string('jabatan')->nullable();     // Kolom untuk jabatan
            $table->text('alamat')->nullable();        // Kolom untuk alamat
            $table->string('kota')->nullable();        // Kolom untuk kota
            $table->string('cabor_id')->nullable(); // Mengubah cabor_id menjadi string
            $table->string('cabor_type')->default('api');
            $table->rememberToken(); // penting untuk auth
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cabor_id');
        });
    }
};
