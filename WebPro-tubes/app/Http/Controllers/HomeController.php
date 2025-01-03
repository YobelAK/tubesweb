<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Halaman Admin
     */
    public function homeAdmin()
    {
        return view('home-admin', ['games' => $this->getGames()]);
    }

    /**
     * Halaman Customer
     */
    public function homeCustomer()
    {
        return view('home-customer', ['games' => $this->getGames()]);
    }

    /**
     * Mendapatkan daftar game
     */
    private function getGames()
    {
        return [
            (object) ['name' => 'Mobile Legends', 'image' => 'ml.jpeg', 'slug' => 'mobile-legends'],
            (object) ['name' => 'Genshin Impact', 'image' => 'genshin-logo.jpg', 'slug' => 'genshin-impact'],
            (object) ['name' => 'Honkai Star Rail', 'image' => 'hsr-logo.jpg', 'slug' => 'honkai-star-rail'],
            (object) ['name' => 'Valorant', 'image' => 'valorant-logo.jpg', 'slug' => 'valorant'],
            (object) ['name' => 'Steam Wallet', 'image' => 'Steam Logo.jpg', 'slug' => 'steam-wallet'],
            (object) ['name' => 'Wuthering Waves', 'image' => 'wuwa-logo.jpg', 'slug' => 'wuthering-waves'],
        ];
    }
}
