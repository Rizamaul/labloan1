<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User (Peminjam)
        // Kita pakai email dummy & password 'password'
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password'), 
        ]);

        // 2. Buat Kategori (Karena Item butuh Category_ID)
        $category = Category::create([
            'name' => 'Peralatan Lab Biologi'
        ]);

        // 3. Buat Barang (Inventaris)
        Item::create([
            'name' => 'Mikroskop Digital',
            'description' => 'Mikroskop zoom 1000x',
            'stock' => 5, // Stok awal 5
            'category_id' => $category->id
        ]);

        Item::create([
            'name' => 'Gelas Ukur',
            'description' => 'Ukuran 100ml',
            'stock' => 10,
            'category_id' => $category->id
        ]);
    }
}