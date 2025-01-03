<?php namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function currentTime(): JsonResponse
    {
        // Set the timezone to Asia/Jakarta
        $time = Carbon::now('Asia/Jakarta')->format('H:i:s Y-m-d'); // Mengubah format waktu
        return response()->json(['time' => $time]);
    }
}