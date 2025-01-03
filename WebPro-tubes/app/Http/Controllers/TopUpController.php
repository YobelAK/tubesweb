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
        // Store the current user's username in the session when they access the form
        session(['transaction_user' => Auth::user()->username]);
        
        // Ambil produk berdasarkan game yang dipilih
        $products = Product::where('nama_game', $request->game)->get();
        
        return view('topup', compact('products', 'request'));
    }

    public function process(Request $request)
    {
        if (!session('transaction_user')) {
            return redirect()->route('home.customer')
                ->with('error', 'Session expired. Please try again.');
        }

        $validated = $request->validate([
            'item' => 'required',
            'harga' => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);

        // Get the username from the session that was set when the form was accessed
        $username = session('transaction_user');
        
        // Clear the session variable after using it
        session()->forget('transaction_user');

        Transaction::create([
            'product_id' => $request->item,
            'harga' => $request->harga,
            'status' => 'Pending',
            'metode_pembayaran' => $request->metode_pembayaran,
            'username' => $username, // Use the stored username instead of Auth::user()
        ]);

        return redirect()->route('transactions.history')
            ->with('success', 'Top-Up berhasil dilakukan!');
    }

}


