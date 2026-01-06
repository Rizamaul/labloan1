<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    // Pastikan category_id ada di sini
    protected $fillable = ['name', 'description', 'stock', 'category_id'];

    // --- TAMBAHKAN INI (Relasi Belongs To) ---
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}