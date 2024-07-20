<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelian';

    protected $primaryKey = 'id';

    public $incrementing = false; // Mengindikasikan bahwa primary key tidak incrementing

    protected $keyType = 'string'; // Menetapkan tipe kunci sebagai string

    protected $fillable = [
        'id','pembelian_id', 'tiket_id', 'jumlah', 'harga_satuan', 'subtotal','keterangan',  'tanggal_kunjungan'
    ];

    public function pembelianTiket()
    {
        return $this->belongsTo(PembelianTiket::class, 'pembelian_id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }
}
