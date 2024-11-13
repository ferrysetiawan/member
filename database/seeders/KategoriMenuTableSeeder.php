<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriMenu::create([
            'nama_kategori' => 'AYAM',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'BEBEK',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'CAFE DRINKS',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'CAFE FOOD',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'COFFEE BASED ',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'DESSERT',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'FRESH JUICE',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'LAINNYA',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'LELE',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'LIGHT MEAL',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'MIE & NASI',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'MILKSHAKE',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'REFRESHER',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'SALAD',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'SAYUR',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'TAMBAHAN BAR',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'TAMBAHAN DAPUR',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'TANPA NASI',
        ]);

        KategoriMenu::create([
            'nama_kategori' => 'TEA BASED',
        ]);
    }
}
