<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\LoanRequest as Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function create()
    {
        $equipments = Equipment::with('category')->where('status', 'tersedia')->orderBy('name')->get(); // Hanya aset yang tersedia dipilih.
        return view('loans.create', compact('equipments')); // Tampilkan form pengajuan.
    }

    public function store(Request $request)
    {
        $validated = $request->validate([ // Periksa semua input dari formulir.
            'equipment_id' => ['required','integer','exists:equipments,id'],
            'borrower_name' => ['required','string','min:3','max:100'],
            'borrower_nim' => ['required','regex:/^[0-9A-Za-z]{8}$/'], // Tepat delapan karakter angka/huruf.
            'borrower_email' => ['required','email','max:100'],
            'loan_date' => ['required','date','after_or_equal:today'],
            'expected_return_date' => ['required','date','after_or_equal:loan_date'],
            'purpose' => ['required','string','min:3'],
        ], [
            'borrower_nim.regex' => 'Format NIM harus terdiri dari tepat 8 digit angka/huruf institusi.',
            'loan_date.after_or_equal' => 'Tanggal peminjaman tidak boleh sebelum tanggal hari ini.',
        ]);

        $loan = DB::transaction(function () use ($validated) { // Simpan pengajuan dalam transaksi database.
            $equipment = Equipment::whereKey($validated['equipment_id'])->lockForUpdate()->firstOrFail(); // Kunci aset agar tidak dicek bersamaan.
            if ($equipment->status !== 'tersedia') { // Tolak jika aset tidak tersedia.
                throw ValidationException::withMessages(['equipment_id' => "Perangkat {$equipment->name} saat ini {$equipment->status} dan tidak tersedia."]); // Tampilkan error di form.
            }
            $start = Carbon::parse($validated['loan_date']); // Ubah tanggal mulai menjadi objek tanggal.
            $end = Carbon::parse($validated['expected_return_date']); // Ubah tanggal kembali menjadi objek tanggal.
            $days = $start->diffInDays($end); // Hitung lama pinjam dalam hari kalender.
            if ($days > 7) { throw ValidationException::withMessages(['expected_return_date' => 'Durasi peminjaman maksimal adalah 7 hari kalender.']); } // Batasi durasi.
            $validated['total_estimated_fee'] = $days * $equipment->daily_rental_fee; // Hitung biaya berdasarkan hari dan tarif.
            $validated['status'] = 'diajukan'; // Status awal pengajuan.
            $created = Loan::create($validated); // Simpan permintaan peminjaman.
            $equipment->update(['status' => 'dipinjam']); // Tandai aset tidak tersedia agar tidak diajukan ganda.
            return $created; // Kembalikan data pengajuan.
        });
        return redirect()->route('loans.create')->with('success', 'Pengajuan peminjaman berhasil disimpan. Estimasi biaya: Rp '.number_format($loan->total_estimated_fee, 0, ',', '.')); // Kembali ke form dengan pesan sukses.
    }
}
