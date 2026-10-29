@extends('layouts.app') 
@section('title', 'Katalog Aset')
@section('content')
<section><h2>Katalog Aset Laboratorium</h2>
<form method="GET" action="{{ route('equipments.index') }}" class="filter-form"> {{-- GET menjaga filter di URL. --}}
    <label>Kata kunci<input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau kode aset"></label>
    <label>Kategori<select name="category_id"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
    <label>Status<select name="status"><option value="">Semua status</option><option value="tersedia" @selected(request('status')==='tersedia')>Tersedia</option><option value="dipinjam" @selected(request('status')==='dipinjam')>Dipinjam</option><option value="dalam_perbaikan" @selected(request('status')==='dalam_perbaikan')>Dalam Perbaikan</option></select></label>
    <button type="submit">Cari / Filter</button><a class="button secondary" href="{{ route('equipments.index') }}">Reset</a>
</form>
<div class="asset-grid">
@forelse($equipments as $equipment)
<article class="asset-card">
    @if($equipment->image_path)<img class="asset-image" src="{{ asset('storage/'.$equipment->image_path) }}" alt="Foto {{ $equipment->name }}">@else<div class="image-placeholder">Foto belum tersedia</div>@endif
    <div class="asset-body"><p class="asset-code">{{ $equipment->asset_code }}</p><h3>{{ $equipment->name }}</h3><p>{{ $equipment->category->name }}</p>
    @php($badgeClass = $equipment->status === 'tersedia' ? 'green' : ($equipment->status === 'dipinjam' ? 'yellow' : 'red')) {{-- Pilih warna badge sesuai status. --}}
    <span class="badge {{ $badgeClass }}">{{ str_replace('_', ' ', ucfirst($equipment->status)) }}</span>
    <p>Rp {{ number_format($equipment->daily_rental_fee, 0, ',', '.') }} / hari</p>
    <div class="actions"><a class="button" href="{{ route('equipments.show', $equipment) }}">Detail</a>@if($equipment->status === 'tersedia')<a class="button secondary" href="{{ route('loans.create') }}">Ajukan Pinjam</a>@endif</div></div>
</article>
@empty <p>Belum ada aset yang cocok dengan pencarian.</p> @endforelse
</div>
<div class="pagination">{{ $equipments->links() }}</div
</section>
@endsection
