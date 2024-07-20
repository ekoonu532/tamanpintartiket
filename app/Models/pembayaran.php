<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_tiket_id',
        'total_bayar',
        'metode_pembayaran',
        'status',
    ];

    public function pembelianTiket()
    {
        return $this->belongsTo(PembelianTiket::class, 'pembelian_tiket_id');
    }
}
