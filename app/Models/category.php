<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // --- TAMBAHKAN INI (Relasi One to Many) ---
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}