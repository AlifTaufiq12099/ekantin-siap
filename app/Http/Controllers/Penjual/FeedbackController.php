<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Penjual;

class FeedbackController extends Controller
{
    public function index()
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $lapakId = $penjual->lapak_id;

        // Ambil semua rating dan feedback
        $ratings = Rating::with('user', 'transaksi.menu')
            ->where('lapak_id', $lapakId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Debug: Log rating values untuk memastikan data benar
        foreach ($ratings as $rating) {
            \Log::info('Rating display', [
                'rating_id' => $rating->rating_id,
                'transaksi_id' => $rating->transaksi_id,
                'raw_rating' => $rating->rating,
                'casted_rating' => (int) $rating->rating,
                'rating_type' => gettype($rating->rating)
            ]);
        }

        // Statistik rating
        $totalRating = Rating::where('lapak_id', $lapakId)->count();
        $averageRating = $totalRating > 0 
            ? round(Rating::where('lapak_id', $lapakId)->avg('rating'), 1) 
            : 0;
        
        // Distribusi rating
        $ratingDistribution = [
            5 => Rating::where('lapak_id', $lapakId)->where('rating', 5)->count(),
            4 => Rating::where('lapak_id', $lapakId)->where('rating', 4)->count(),
            3 => Rating::where('lapak_id', $lapakId)->where('rating', 3)->count(),
            2 => Rating::where('lapak_id', $lapakId)->where('rating', 2)->count(),
            1 => Rating::where('lapak_id', $lapakId)->where('rating', 1)->count(),
        ];

        return view('penjual.feedback.index', compact(
            'ratings',
            'totalRating',
            'averageRating',
            'ratingDistribution'
        ));
    }
}

