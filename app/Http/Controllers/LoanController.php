<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\Support\Facades\DB; // Wajib import ini untuk Transaction

class LoanController extends Controller
{
    // Fungsi untuk Meminjam Barang
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $itemId = $request->item_id;
        $userId = $request->user_id;

        try {
            // --- MULAI TRANSAKSI ---
            // Kode di dalam sini akan dijalankan sebagai satu kesatuan
            DB::transaction(function () use ($itemId, $userId) {
                
                // 2. Cek Stok & KUNCI Baris Data (lockForUpdate)
                // Ini mencegah "Race Condition" jika ada 2 orang klik pinjam bebarengan
                $item = Item::where('id', $itemId)->lockForUpdate()->first();

                // 3. Logika Pengecekan Stok
                if ($item->stock > 0) {
                    
                    // Kurangi stok
                    $item->stock = $item->stock - 1;
                    $item->save();

                    // Catat peminjaman
                    Loan::create([
                        'user_id' => $userId,
                        'item_id' => $itemId,
                        'loan_date' => now(), // Tanggal hari ini
                        'status' => 'borrowed'
                    ]);

                } else {
                    // Jika stok habis, lempar error agar transaksi batal
                    throw new \Exception("Stok barang habis!");
                }
            });

            // Jika berhasil
            return response()->json(['message' => 'Berhasil meminjam barang!'], 200);

        } catch (\Exception $e) {
            // Jika gagal
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // --- TAMBAHKAN FUNGSI INI DI BAWAH FUNGSI STORE ---
    
    public function returnItem(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required',
            'item_id' => 'required',
        ]);

        $userId = $request->user_id;
        $itemId = $request->item_id;

        try {
            DB::transaction(function () use ($userId, $itemId) {
                
                // 1. Cari data peminjaman yang AKTIF (status 'borrowed')
                $loan = Loan::where('user_id', $userId)
                            ->where('item_id', $itemId)
                            ->where('status', 'borrowed')
                            ->first();

                if ($loan) {
                    // 2. Update status jadi 'returned' & isi tanggal kembali
                    $loan->update([
                        'status' => 'returned',
                        'return_date' => now()
                    ]);

                    // 3. Kembalikan Stok Barang (+1)
                    $item = Item::find($itemId);
                    $item->stock = $item->stock + 1;
                    $item->save();
                    
                } else {
                    throw new \Exception("Data peminjaman tidak ditemukan atau sudah dikembalikan!");
                }
            });

            return response()->json(['message' => 'Barang berhasil dikembalikan! Stok kembali normal.']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
