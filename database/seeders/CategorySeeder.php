<?php

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Elektronik'],
            ['name' => 'Alat Lab'],
            ['name' => 'ATK'],
            ['name' => 'Lainnya'],
        ]);
    }
}
