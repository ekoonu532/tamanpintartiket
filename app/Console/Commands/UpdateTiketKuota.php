<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tiket;
use App\Models\tiket_kuota;
use Carbon\Carbon;

class UpdateTiketKuota extends Command
{
    protected $signature = 'tiket:update-kuota';
    protected $description = 'Update kuota tiket untuk 7 hari ke depan';

    public function handle()
    {
        $tikets = Tiket::all();
        foreach ($tikets as $tiket) {
            for ($i = 0; $i < 7; $i++) {
                $tanggal = Carbon::now()->addDays($i)->toDateString();
                // Cek apakah kuota untuk tanggal ini sudah ada
                $kuota = tiket_kuota::firstOrNew([
                    'tiket_id' => $tiket->tiket_id,
                    'tanggal' => $tanggal
                ]);

                // Jika belum ada, tambahkan kuota
                if (!$kuota->exists) {
                    $kuota->kuota = $tiket->kuota;
                    $kuota->save();
                }
            }
        }

        $this->info('Kuota tiket berhasil diupdate untuk 7 hari ke depan');
    }
}
