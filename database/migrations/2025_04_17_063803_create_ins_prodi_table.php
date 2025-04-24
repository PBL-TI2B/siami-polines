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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->char('nama_kriteria', 100)->nullable(); // kolom char dengan panjang 100
        });

        Schema::create('deskripsi', function (Blueprint $table) {
            $table->id('deskripsi_id'); // primary key auto-increment
            $table->unsignedBigInteger('kriteria_id'); // foreign key
            $table->text('isi_deskripsi'); // cocok untuk teks panjang

            // definisi foreign key
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        });

        Schema::create('unsur', function (Blueprint $table) {
            $table->id('unsur_id'); // primary key auto-increment
            $table->unsignedBigInteger('deskripsi_id'); // foreign key
            $table->text('isi_unsur'); // cocok untuk teks panjang

            // definisi foreign key
            $table->foreign('deskripsi_id')->references('deskripsi_id')->on('deskripsi')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unsur');
        Schema::dropIfExists('deskripsi');
        Schema::dropIfExists('kriteria');
    }
};
