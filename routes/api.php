<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\LoanController;

Route::post('/pinjam', [LoanController::class, 'store']);
Route::post('/kembali', [LoanController::class, 'returnItem']);