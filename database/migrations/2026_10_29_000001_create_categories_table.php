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
    Schema::create('categories', function (Blueprint $table) {
        $table->id(); // ID kategori otomatis.
        $table->string('name', 100)->unique(); // Nama kategori tidak boleh sama.
        $table->string('code', 10)->unique();// Kode kategori unik, misalnya IOT.
        $table->timestamp(); // Waktu data dibuat dan diperbarui.
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoris');
    }
};
