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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');  // ID pengguna
            $table->unsignedBigInteger('role_id');  // Relasi ke role
            $table->unsignedBigInteger('unit_kerja_id');  // Relasi ke unit kerja
            $table->string('email', 100)->unique();  // Email harus unik
            $table->string('password');  // Password, tipe string lebih fleksibel
            $table->string('nama', 100);  // Nama pengguna
            $table->string('nip', 100)->unique();  // NIP harus unik
    
            // Menambahkan foreign key dengan aturan onDelete
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->foreign('unit_kerja_id')->references('unit_kerja_id')->on('unit_kerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
