<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;


    protected $fillable = [
        'category_id',
        'asset_code',
        'name',
        'spesification',
        'condition',
        'status',
        'daily_rental_fee',
        
    ];

    /**
     * Relasi ke model Kategori (BelongsTo)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'categori_id');
    }

    /**
     * Relasi ke model Peminjaman (HasMany)
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class);
    }
}