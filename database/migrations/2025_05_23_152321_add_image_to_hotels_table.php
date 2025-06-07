<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('image_path')->nullable();
            // $table->json('facilities_image')->nullable();
             // ganti nama_kolom_terakhir sesuai struktur tabelmu
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('image_path');
            // $table->dropColumn('facilities_image');
        });
    }
};
