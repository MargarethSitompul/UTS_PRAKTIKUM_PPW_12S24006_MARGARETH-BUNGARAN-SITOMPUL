<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model {
    protected $fillable = ['category_id', 'category_name', 'category_code'];

    public function course(): BelongsTo {
        return $this->belongsTo(category::class);
    }
}