<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\PembelianTiket;
use App\Models\DetailPembelian;
// use Illuminate\Http\Request;



class CheckoutController extends Controller
{
    public function halamancheckout(Request $request)
    {
        // Validasi input
        $request->validate([
            'anakQty' => 'required|integer|min:0',
            'dewasaQty' => 'required|integer|min:0',
        ]);

        // Ambil data jumlah tiket anak dan dewasa dari request
        $anakQty = $request->input('anakQty');
        $dewasaQty = $request->input('dewasaQty');

        // Proses pembelian tiket
        $pembelian = $this->prosesPembelian($anakQty, $dewasaQty);

        // Redirect ke halaman checkout dengan menyertakan informasi pembelian
        return view('checkout', compact('pembelian'));
    }

    private function prosesPembelian($anakQty, $dewasaQty)
    {
        // Ambil data tiket dari sesi atau database
        // Misalnya, di sini saya mengasumsikan Anda sudah memiliki data tiket yang dipilih sebelumnya
        $tiket = session('tiket');

        // Hitung total harga
        $hargaAnak = $tiket->harga_anak * $anakQty;
        $hargaDewasa = $tiket->harga_dewasa * $dewasaQty;
        $totalHarga = $hargaAnak + $hargaDewasa;

        // Simpan pembelian tiket
        $pembelian = new PembelianTiket();
        $pembelian->user_id = auth()->user()->id; // Sesuaikan dengan cara Anda mendapatkan ID pengguna
        $pembelian->kode_pembelian = uniqid();
        $pembelian->jumlah_tiket = $anakQty + $dewasaQty;
        $pembelian->total_harga = $totalHarga;
        $pembelian->status_pembayaran = 'pending';
        $pembelian->save();

        // Simpan detail pembelian
        DetailPembelian::create([
            'pembelian_id' => $pembelian->id,
            'tiket_id' => $tiket->id,
            'jumlah' => $anakQty + $dewasaQty,
            'harga_satuan' => $tiket->harga_anak + $tiket->harga_dewasa,
            'subtotal' => $totalHarga,
        ]);

        return $pembelian;
    }


    //
    // public function checkout(Request $request)
    // {
    //     // Lakukan validasi jika diperlukan
    //     $request->validate([
    //         'jenis_tiket' => 'required|in:wahana,event,program_kreativitas',
    //         'anak' => 'required|integer|min:0',
    //         'dewasa' => 'required|integer|min:0',
    //     ]);

    //     // Ambil data jumlah tiket anak dan dewasa dari request
    //     $jenisTiket = $request->input('jenis_tiket');
    //     $anakQty = $request->input('anak');
    //     $dewasaQty = $request->input('dewasa');

    //     // Ambil data tiket berdasarkan jenis tiket
    //     $tiket = Tiket::where('jenis', $jenisTiket)->first();

    //     // Hitung total harga
    //     $hargaAnak = $tiket->harga_anak * $anakQty;
    //     $hargaDewasa = $tiket->harga_dewasa * $dewasaQty;
    //     $totalHarga = $hargaAnak + $hargaDewasa;

    //     // Simpan pembelian
    //     $pembelian = new PembelianTiket();
    //     $pembelian->user_id = auth()->user()->id; // Jika menggunakan autentikasi pengguna
    //     $pembelian->kode_pembelian = uniqid();
    //     $pembelian->jumlah_tiket = $anakQty + $dewasaQty;
    //     $pembelian->total_harga = $totalHarga;
    //     $pembelian->status_pembayaran = 'pending';
    //     $pembelian->save();

    //     // Simpan detail pembelian
    //     DetailPembelian::create([
    //         'pembelian_id' => $pembelian->id,
    //         'tiket_id' => $tiket->id,
    //         'jumlah' => $anakQty + $dewasaQty,
    //         'harga_satuan' => $tiket->harga_anak + $tiket->harga_dewasa,
    //         'subtotal' => $totalHarga,
    //     ]);

    //     // Redirect ke halaman checkout dengan menyertakan informasi pembelian
    //     return view('checkout', compact('pembelian'));
    // }
}

