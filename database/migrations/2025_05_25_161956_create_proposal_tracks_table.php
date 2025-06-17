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
            $table->foreignId('proposal_id')->constrained()->onDelete('cascade');
            $table->foreignId('actor_id')
                ->nullable()           
                ->constrained('users') 
                ->onDelete('set null');
            $table->string('status_label');
            $table->string('from_position')->nullable();
            $table->string('to_position')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_tracks', function (Blueprint $table) {
            $table->dropForeign(['proposal_id']);
            $table->dropForeign(['actor_id']);
        });
      
        Schema::dropIfExists('proposal_tracks');
    }
};
