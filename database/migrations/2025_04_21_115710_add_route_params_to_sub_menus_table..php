<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_menus', function (Blueprint $table) {
            $table->json('route_params')->nullable()->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('sub_menus', function (Blueprint $table) {
            $table->dropColumn('route_params');
        });
    }
};
