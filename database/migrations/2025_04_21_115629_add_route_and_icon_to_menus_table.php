<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('route')->nullable()->after('nama_menu');
            $table->string('icon')->nullable()->after('route');
        });

        Schema::table('sub_menus', function (Blueprint $table) {
            $table->string('route')->nullable()->after('nama_sub_menu');
            $table->string('icon')->nullable()->after('route');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['route', 'icon']);
        });

        Schema::table('sub_menus', function (Blueprint $table) {
            $table->dropColumn(['route', 'icon']);
        });
    }
};
