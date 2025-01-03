<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'nama_game' => 'Mobile Legends',
                'item' => '316 Diamonds',
                'image_url' => 'ml.jpeg',
                'harga' => 68000,
            ],
            [
                'nama_game' => 'Genshin Impact',
                'item' => '1000 Genesis Crystals',
                'image_url' => 'genshin-logo.jpg',
                'harga' => 225000,
            ],
            [
                'nama_game' => 'Honkai Star Rail',
                'item' => '1600 Oneric Shards',
                'image_url' => 'hsr-logo.jpg',
                'harga' => 345000,
            ],
            [
                'nama_game' => 'Valorant',
                'item' => '1200 Valorant Points',
                'image_url' => 'valorant-logo.jpg',
                'harga' => 175000,
            ],
            [
                'nama_game' => 'Wuthering Waves',
                'item' => '1628 Lunites',
                'image_url' => 'wuwa-logo.jpg',
                'harga' => 365000,
            ],
            [
                'nama_game' => 'Steam Wallet',
                'item' => '100000 Steam Wallets',
                'image_url' => 'Steam Logo.jpg',
                'harga' => 225000,
            ],
        ]);
    }
}
