@extends('layouts.app')
@section('title', 'Detail Aset')
@section('content')
<section class="form-panel"><a href="{{ route('equipments.index') }}">← Kembali ke katalog</a><h2>{{ $equipment->name }}</h2>
@if($equipment->image_path)<img class="detail-image" src="{{ asset('storage/'.$equipment->image_path) }}" alt="Foto {{ $equipment->name }}">@endif
<p><strong>Kode aset:</strong> {{ $equipment->asset_code }}</p><p><strong>Kategori:</strong> {{ $equipment->category->name }}</p><p><strong>Spesifikasi:</strong> {{ $equipment->specification ?: 'Belum diisi' }}</p><p><strong>Kondisi:</strong> {{ str_replace('_',' ',$equipment->condition) }}</p><p><strong>Status:</strong> {{ str_replace('_',' ',$equipment->status) }}</p><p><strong>Tarif harian:</strong> Rp {{ number_format($equipment->daily_rental_fee,0,',','.') }}</p>
@if($equipment->status==='tersedia')<a class="button" href="{{ route('loans.create') }}">Ajukan Peminjaman</a>@endif
</section>
@endsection
