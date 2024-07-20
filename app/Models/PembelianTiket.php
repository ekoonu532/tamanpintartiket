<?php

namespace App\Models;

use Midtrans\Snap;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class PembelianTiket extends Model
{
    protected $table = 'pembelian_tikets';

    protected $primaryKey = 'id';

    public $incrementing = false; // Mengindikasikan bahwa primary key tidak incrementing

    protected $keyType = 'string'; // Menetapkan tipe kunci sebagai string

    protected $fillable = [
        'id', 'user_id', 'kode_pembelian','jumlah_tiket', 'total_harga', 'status_pembayaran', 'status', 'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPembelianTikets()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }

    public function expire()
    {
        $this->status = 'expired';
        $this->expired_at = Carbon::now();
        $this->save();
    }


}
// App\Models\PembelianTiket.php





