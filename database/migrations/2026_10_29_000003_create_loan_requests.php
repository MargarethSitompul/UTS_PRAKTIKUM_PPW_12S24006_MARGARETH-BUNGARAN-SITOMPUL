<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loan_request', function (Blueprint $table) {
            $table->id();// ID pengajuan otomatis.
            $table->foreignId('equipment_id')->constrained('equipments.id')->restrictOnDelete();// Aset yang diajukan.
            $table->string('borrower_nim', 10); // Nim peminjam.
            $table->string('borrower_name', 100); // Nama peminjam.
            $table->string('borrower_email', 100); // Email peminjam.
            $table->date('loan_date');//Tanggal mulai pinjam.
            $table->date('expected_return_date');//Rencana tanggal kembali.
            $table->text('purpose'); // Tujuan peminjaman.
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');// Status pengajuan.
            $table->unsignedInteger('total_estimated_fee')->default(0); // Total perkiraan biaya.
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loan_request');
    }
};