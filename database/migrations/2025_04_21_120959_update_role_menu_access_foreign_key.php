<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key lama
        Schema::table('role_menu_access', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        // Tambah foreign key baru dengan ON DELETE CASCADE
        Schema::table('role_menu_access', function (Blueprint $table) {
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Hapus foreign key baru
        Schema::table('role_menu_access', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        // Kembalikan foreign key tanpa ON DELETE CASCADE
        Schema::table('role_menu_access', function (Blueprint $table) {
            $table->foreign('menu_id')->references('menu_id')->on('menus');
        });
    }
};
