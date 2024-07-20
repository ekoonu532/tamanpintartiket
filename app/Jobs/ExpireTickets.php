<?php

namespace App\Jobs;

use App\Models\PembelianTiket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        // Mendapatkan tanggal saat ini
        $currentDate = Carbon::now();

        // Mengambil semua tiket yang sudah melewati tanggal kunjungan dan belum expired
        $tikets = PembelianTiket::where('tanggal_kunjungan', '<', $currentDate)
                                  ->where('status', '!=', 'expired')
                                  ->get();

        foreach ($tikets as $tiket) {
            $tiket->status = 'expired';
            $tiket->expired_at = $currentDate;
            $tiket->save();
        }
    }
}
