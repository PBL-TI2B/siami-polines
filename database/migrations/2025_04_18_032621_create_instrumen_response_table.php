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
        Schema::create('instrumen_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditing_id');
            $table->unsignedBigInteger('set_instrumen_unit_kerja_id');
            $table->unsignedBigInteger('response_id');
            $table->char('status_instrumen', 100);

            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('set_instrumen_unit_kerja_id')->references('set_instrumen_unit_kerja_id')->on('set_instrumen')->onDelete('cascade');
            $table->foreign('response_id')->references('response_id')->on('responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrumen_response');
    }
};
