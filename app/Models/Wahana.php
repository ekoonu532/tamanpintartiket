<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wahana extends Model
{
    use HasFactory;

    protected $fillable = [
         'nama', 'deskripsi', 'gambar', 'harga_anak', 'harga_dewasa', 'kuota',
    ];


}

