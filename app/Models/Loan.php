<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    // Matikan timestamp jika di tabel loans tidak ada kolom created_at/updated_at
    // Tapi default migration Laravel biasanya ada, jadi biarkan true jika ada.
    public $timestamps = false; 

    protected $fillable = ['user_id', 'item_id', 'loan_date', 'return_date', 'status'];
}