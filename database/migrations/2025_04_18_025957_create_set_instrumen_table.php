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
        Schema::create('set_instrumen', function (Blueprint $table) {
            $table->id('set_instrumen_unit_kerja_id');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->unsignedBigInteger('aktivitas_id')->nullable;
            $table->unsignedBigInteger('unsur_id')->nullable;

            $table->foreign('unit_kerja_id')->references('unit_kerja_id')->on('unit_kerja')->onDelete('cascade');
            $table->foreign('aktivitas_id')->references('aktivitas_id')->on('aktivitas')->onDelete('cascade');
            $table->foreign('unsur_id')->references('unsur_id')->on('unsur')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_instrumen');
    }
};
