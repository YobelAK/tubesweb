<?php
//testttttt

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $date = $request->get('date');

        $query = Transaction::with('product'); // Load relasi product

        if ($status !== 'all') {
            $query->where('status', $status);
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $transactions = $query->get();
        return view('history-admin', compact('transactions', 'status', 'date'));
    }


    public function cancel(Request $request)
    {
        // Validasi user sebagai admin langsung di controller
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Admins only.',
            ], 403);
        }

        try {
            $transaction = Transaction::findOrFail($request->id);
            $transaction->status = 'Gagal';
            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibatalkan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function history()
    {
        $username = Auth::user()->username;

        $transactions = Transaction::where('username', $username)->with('product')->get();

        return view('history-customer', compact('transactions'));
    }

    public function confirm(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);
        
        $transaction->status = 'Sukses';
        $transaction->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dikonfirmasi'
        ]);
    }

    public function getTransactions()
    {
        $username = Auth::user()->username;
        $transactions = Transaction::where('username', $username)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }

    public function getAdminTransactions(Request $request)
    {
        $query = Transaction::with('product');

        if ($request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('username')) {
            $query->where('username', $request->username);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }

}
