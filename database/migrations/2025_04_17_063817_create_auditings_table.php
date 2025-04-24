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
        Schema::create('auditings', function (Blueprint $table) {
            $table->id('auditing_id');
            $table->unsignedBigInteger('user_id_1_auditor');
            $table->unsignedBigInteger('user_id_2_auditor');
            $table->unsignedBigInteger('user_id_1_auditee');
            $table->unsignedBigInteger('user_id_2_auditee');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->unsignedBigInteger('periode_id');
            $table->date('jadwal_audit')->nullable();
            $table->char('status',100);

            $table->foreign('user_id_1_auditor')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_2_auditor')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_1_auditee')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_2_auditee')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('unit_kerja_id')->references('unit_kerja_id')->on('unit_kerja')->onDelete('cascade');
            $table->foreign('periode_id')->references('periode_id')->on('periode_audits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditings');
    }
};
