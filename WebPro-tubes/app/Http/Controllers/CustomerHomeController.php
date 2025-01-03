<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CustomerHomeController extends Controller
{
    public function index()
    {
        // Ambil daftar game unik dengan nama dan gambar
        $games = Product::select('nama_game', 'image_url')->distinct()->get();
    
        return view('home-customer', compact('games'));
    }    
}

