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
        Schema::create('responses', function (Blueprint $table) {
            $table->id('response_id');
            $table->unsignedBigInteger('auditing_id');
            $table->unsignedBigInteger('set_instrumen_unit_kerja_id');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->unsignedBigInteger('user_id');

            
            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('set_instrumen_unit_kerja_id')->references('set_instrumen_unit_kerja_id')->on('set_instrumen')->onDelete('cascade');
            $table->foreign('unit_kerja_id')->references('unit_kerja_id')->on('unit_kerja')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
