<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function showForm(Request $request)
    {
        session(['transaction_user' => Auth::user()->username]);
        
        $products = Product::where('nama_game', $request->game)->get();
        
        return view('topup', compact('products', 'request'));
    }

    public function process(Request $request)
    {
        if (!session('transaction_user')) {
            return redirect()->route('home.customer')->with('error', 'Session expired. Please try again.');
        }

        $validated = $request->validate([
            'item' => 'required',
            'harga' => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);

        $username = session('transaction_user');
        
        session()->forget('transaction_user');

        Transaction::create([
            'product_id' => $request->item,
            'harga' => $request->harga,
            'status' => 'Pending',
            'metode_pembayaran' => $request->metode_pembayaran,
            'username' => $username,
        ]);

        return redirect()->route('transactions.history')->with('success', 'Top-Up berhasil dilakukan!');
    }

}


