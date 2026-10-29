@extends('layouts.app')
@section('title', 'Tambah Aset')
@section('content')
<section class="form-panel"><h2>Tambah Aset Baru</h2>
<form method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data"> {{-- enctype diperlukan untuk upload foto. --}}
@csrf {{-- Token untuk melindungi form dari CSRF. --}}
<label>Kategori<select name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Kode aset<input name="asset_code" value="{{ old('asset_code') }}" required maxlength="20" placeholder="EQ-IOT-005">@error('asset_code')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Nama perangkat<input name="name" value="{{ old('name') }}" required minlength="5" maxlength="150">@error('name')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Spesifikasi<textarea name="specification" rows="4">{{ old('specification') }}</textarea>@error('specification')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Kondisi<select name="condition" required>@foreach(['baik'=>'Baik','rusak_ringan'=>'Rusak Ringan','rusak_berat'=>'Rusak Berat'] as $key=>$label)<option value="{{ $key }}" @selected(old('condition','baik')===$key)>{{ $label }}</option>@endforeach</select>@error('condition')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Tarif harian (Rp)<input type="number" min="0" name="daily_rental_fee" value="{{ old('daily_rental_fee',0) }}" required>@error('daily_rental_fee')<small class="field-error">{{ $message }}</small>@enderror</label>
<label>Foto perangkat (JPEG, PNG, WEBP; maks. 2 MB)<input type="file" name="image" accept="image/jpeg,image/png,image/webp" required>@error('image')<small class="field-error">{{ $message }}</small>@enderror</label>
<button type="submit">Simpan Aset</button>
</form></section>
@endsection
