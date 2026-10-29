<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category'); // Ambil data aset beserta kategorinya.
        if ($request->filled('search')) { // Cari jika kata kunci diisi.
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%") // Cari pada nama.
                  ->orWhere('asset_code', 'like', "%{$keyword}%"); // Atau pada kode aset.
            });
        }
        if ($request->filled('category_id')) { $query->where('category_id', $request->category_id); } // Filter kategori.
        if (in_array($request->status, ['tersedia','dipinjam','dalam_perbaikan'], true)) { $query->where('status', $request->status); } // Filter status yang valid.
        $equipments = $query->latest()->paginate(5)->appends($request->query()); // Lima kartu per halaman dan pertahankan filter.
        $categories = Category::orderBy('name')->get(); // Isi dropdown kategori.
        return view('equipments.index', compact('equipments', 'categories')); // Kirim data ke halaman katalog.
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get(); // Ambil kategori untuk formulir.
        return view('equipments.create', compact('categories')); // Tampilkan form tambah aset.
    }

    public function store(Request $request)
    {
        $validated = $request->validate([ // Validasi data dari browser di server.
            'category_id' => ['required','exists:categories,id'],
            'asset_code' => ['required','string','max:20','unique:equipments,asset_code'],
            'name' => ['required','string','min:5','max:150'],
            'specification' => ['nullable','string'],
            'condition' => ['required', Rule::in(['baik','rusak_ringan','rusak_berat'])],
            'daily_rental_fee' => ['required','numeric','min:0','max:4294967295'],
            'image' => ['required','image','mimes:jpeg,png,webp','max:2048'],
        ]);
        $validated['image_path'] = $request->file('image')->store('equipments', 'public'); // Simpan foto dengan nama unik di storage publik.
        unset($validated['image']); // Hapus field upload sebelum menyimpan ke tabel.
        $equipment = Equipment::create($validated); // Simpan data aset.
        return redirect()->route('equipments.index')->with('success', "Perangkat {$equipment->name} ({$equipment->asset_code}) berhasil didaftarkan!"); // PRG dan notifikasi sukses.
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('category', 'loanRequests'); // Ambil kategori dan riwayat peminjaman.
        return view('equipments.show', compact('equipment')); // Tampilkan detail aset.
    }
}
