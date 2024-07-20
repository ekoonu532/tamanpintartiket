<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KategoriTiket extends Model
{
    use HasFactory;
    protected $table = 'kategori_tikets';

    protected $primaryKey = 'kategori_tiket_id';

    protected $fillable = [
         'nama', 'deskripsi'
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'kategori_tiket_id');
    }
}
