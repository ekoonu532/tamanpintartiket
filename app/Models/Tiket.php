<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tiket extends Model
{
    use HasFactory;
    protected $table = 'tikets';


    protected $primaryKey = 'tiket_id'; // Set primary key ke 'tiket_id'
    public $incrementing = false; // Set agar tidak auto increment
    protected $keyType = 'string'; // Set tipe primary key ke string
    protected $fillable = [
        'tiket_id',
        'nama',
        'slug', // Tambahkan slug ke fillable
        'deskripsi',
        'kategori_tiket_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'gambar', // Tambahkan gambar ke fillable
        'harga_anak',
        'harga_dewasa',
        'kuota',
        'usia_minimal',
        'status',
        'tiket_terkait_id'

    ];

    public function kategoriTiket()
    {
        return $this->belongsTo(KategoriTiket::class, 'kategori_tiket_id');
    }



    public function pembelianTikets()
    {
        return $this->hasMany(PembelianTiket::class, 'tiket_id');
    }

    public function detailPembelianTikets()
    {
        return $this->hasMany(DetailPembelian::class, 'tiket_id');
    }

    public function tiketTerkait()
    {
        return $this->belongsTo(Tiket::class, 'tiket_terkait_id');
    }

}
