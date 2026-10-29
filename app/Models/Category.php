<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HashMany;

class Category extends Model {
    protected $fillable = ['category_id', 'category_name', 'category_code'];

    public function equipments(): HasMany { 
        return $this->hashMany(Equipment::class);
    }
}