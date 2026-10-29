<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id(); // ID aset otomatis.
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete(); // Kategori wajib ada dan tidak boleh dihapus jika dipakai.
            $table->string('asset_code', 20)->unique(); // Kode inventaris harus unik.
            $table->string('name', 150); // Nama aset.
            $table->text('specification')->nullable(); // Spesifikasi teknis boleh kosong.
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik'); // Kondisi fisik.
            $table->enum('status', ['tersedia', 'dipinjam', 'dalam_perbaikan'])->default('tersedia'); // Status aset.
            $table->unsignedInteger('daily_rental_fee'); // Tarif kompensasi per hari dalam rupiah.
            $table->string('image_path', 255)->nullable(); // 
            $table->timestamps(); // Waktu dibuat dan diperbarui.
        });
    }
    public function down(): void { Schema::dropIfExists('equipments'); } // Hapus tabel saat rollback.
};
