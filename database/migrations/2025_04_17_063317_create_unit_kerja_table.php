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
            Schema::create('unit_kerja', function (Blueprint $table) {
                $table->id('unit_kerja_id');
                $table->char('nama_unit_kerja',100);
                $table->integer('parent_id')->nullable();
                $table->unsignedBigInteger('jenis_unit_id');
                
                $table->foreign('jenis_unit_id')->references('jenis_unit_id')->on('jenis_units')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kerja');
    }
};
