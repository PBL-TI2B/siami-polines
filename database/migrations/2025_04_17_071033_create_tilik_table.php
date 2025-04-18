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
        Schema::create('tilik', function (Blueprint $table) {
            $table->id('tilik_id');
            $table->text('pertanyaan');
            $table->text('indikator');
            $table->char('sumber_data', 100)->nullable();
            $table->char('metode_perhitungan', 100)->nullable();
            $table->char('target', 100)->nullable;
        });

        Schema::create('response_tilik', function (Blueprint $table) {
            $table->id('response_tilik_id');
            $table->unsignedBigInteger('auditing_id');
            $table->unsignedBigInteger('tilik_id');
            $table->text('realisasi')->nullable();
            $table->text('standar_nasional')->nullable();
            $table->text('uraian isian')->nullable();
            $table->text('akar_penyebab_penunjang')->nullable();
            $table->text('rencana_perbaikan_tindak_lanjut')->nullable();

            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('tilik_id')->references('tilik_id')->on('tilik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_tilik');
        Schema::dropIfExists('tilik');
    }
};
