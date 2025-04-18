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
        Schema::create('sasaran_strategis', function (Blueprint $table) {
            $table->id('sasaran_strategis_id');
            $table->char('nama_sasaran', 100); // kolom char dengan panjang 100
        });

        Schema::create('indikator_kinerja', function (Blueprint $table) {
            $table->id('indikator_kinerja_id');
            $table->unsignedBigInteger('sasaran_strategis_id');
            $table->text('isi_indikator_kinerja');

            //foreign key
            $table->foreign('sasaran_strategis_id')->references('sasaran_strategis_id')->on('sasaran_strategis')->onDelete('cascade');
        });

        Schema::create('aktivitas', function (Blueprint $table) {
            $table->id('aktivitas_id');
            $table->unsignedBigInteger('indikator_kinerja_id');
            $table->char('nama_aktivitas', 200);
            $table->char('satuan', 100);
            $table->integer('target');

            //foreign key
            $table->foreign('indikator_kinerja_id')->references('indikator_kinerja_id')->on('indikator_kinerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas');
        Schema::dropIfExists('indikator_kinerja');
        Schema::dropIfExists('sasaran_strategis');
    }
};
