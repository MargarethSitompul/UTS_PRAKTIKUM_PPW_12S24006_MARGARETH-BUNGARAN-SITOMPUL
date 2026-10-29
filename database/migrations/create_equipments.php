<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('categori_id', 50)->constrained('categoris')->cascadeOnDelete();
            $table->foreignId('asset_code, 20')->constrained('equipments')->unique(); // format: EQ-[KODE_KAT]-[NOMOR])
            $table->string('name_quipment', 150);
            $table->string('spesification_quipment', 150);
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->enum('status', ['tersedia', 'dipinjam', 'dalam_perbaikan'])->default('tersedia');
            $table->INTEGER('daily_rental_fee'); //tarif kompensasi harian dalam Rupiah
            $table->sring('image_path',255)->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipments');
    }
};