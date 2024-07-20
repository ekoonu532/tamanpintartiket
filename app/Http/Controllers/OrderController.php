<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PembelianTiket;
use App\Models\DetailPembelian;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Pembayaran; // Tambahkan ini

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $selectedTicket = Session::get('selected_ticket');

        if (!$selectedTicket) {
            // Handle error, redirect to a different page or show an error message
            return redirect()->back()->withErrors(['error' => 'No ticket selected.']);
        }

        $relatedTicket = $selectedTicket->tiketTerkait()->first();

        $selectedDate = $request->query('selected_date', Session::get('selected_date'));

        return view('orders.index', [
            'selectedTicket' => $selectedTicket,
            'selectedDate' => $selectedDate,
            'relatedTicket' => $relatedTicket,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'jumlah_anak' => 'nullable|integer|min:0',
            'jumlah_dewasa' => 'nullable|integer|min:0',
            'selected_date' => 'required|date',
            'tiket_id' => 'required',
            'harga_anak' => 'required|numeric|min:0',
            'harga_dewasa' => 'required|numeric|min:0',
            'selected_ticket_name' => 'required',
            'total_harga' => 'required|numeric|min:0',
            'jumlah_terkait_anak' => 'nullable|integer|min:0',
            'jumlah_terkait_dewasa' => 'nullable|integer|min:0',
        ]);

        // Mengambil data dari request
        $totalHarga = $request->input('total_harga');
        $jumlahAnak = $request->input('jumlah_anak');
        $jumlahDewasa = $request->input('jumlah_dewasa');
        $jumlahTerkaitAnak = $request->input('jumlah_terkait_anak');
        $jumlahTerkaitDewasa = $request->input('jumlah_terkait_dewasa');
        $selectedDate = $request->input('selected_date');
        $tiketId = $request->input('tiket_id');
        $hargaAnak = $request->input('harga_anak');
        $hargaDewasa = $request->input('harga_dewasa');
        $selectedTicketName = $request->input('selected_ticket_name');

        // Buat pembelian tiket
        $pembelian = PembelianTiket::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'kode_pembelian' => Str::random(10),
            'jumlah_tiket' => $jumlahAnak + $jumlahDewasa + $jumlahTerkaitAnak + $jumlahTerkaitDewasa,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'pending',
            'status' => 'active',
            'expired_at' => Carbon::now()->addMinutes(15)
        ]);

        // Buat detail pembelian tiket untuk anak
        if ($jumlahAnak > 0) {
            DetailPembelian::create([
                'id' => Str::uuid(),
                'pembelian_id' => $pembelian->id,
                'tiket_id' => $tiketId,
                'jumlah' => $jumlahAnak,
                'harga_satuan' => $hargaAnak,
                'subtotal' => $jumlahAnak * $hargaAnak,
                'keterangan' => $selectedTicketName . ' Anak',
                'tanggal_kunjungan' => $selectedDate,
            ]);
        }

        // Buat detail pembelian tiket untuk dewasa
        if ($jumlahDewasa > 0) {
            DetailPembelian::create([
                'id' => Str::uuid(),
                'pembelian_id' => $pembelian->id,
                'tiket_id' => $tiketId,
                'jumlah' => $jumlahDewasa,
                'harga_satuan' => $hargaDewasa,
                'subtotal' => $jumlahDewasa * $hargaDewasa,
                'keterangan' => $selectedTicketName . ' Dewasa',
                'tanggal_kunjungan' => $selectedDate,
            ]);
        }

        // Jika ada tiket terkait, tambahkan juga detail pembeliannya
        if ($request->has('related_ticket_id')) {
            $relatedTicketId = $request->input('related_ticket_id');
            $relatedTicketName = $request->input('related_ticket_name');
            $relatedTicketHargaAnak = $request->input('related_ticket_harga_anak');
            $relatedTicketHargaDewasa = $request->input('related_ticket_harga_dewasa');
            $jumlahTerkaitAnak = $request->input('jumlah_terkait_anak');
            $jumlahTerkaitDewasa = $request->input('jumlah_terkait_dewasa');

            if ($jumlahTerkaitAnak > 0) {
                DetailPembelian::create([
                    'id' => Str::uuid(),
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $relatedTicketId,
                    'jumlah' => $jumlahTerkaitAnak,
                    'harga_satuan' => $relatedTicketHargaAnak,
                    'subtotal' => $jumlahTerkaitAnak * $relatedTicketHargaAnak,
                    'keterangan' => $relatedTicketName . ' Anak',
                    'tanggal_kunjungan' => $selectedDate,
                ]);
            }

            if ($jumlahTerkaitDewasa > 0) {
                DetailPembelian::create([
                    'id' => Str::uuid(),
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $relatedTicketId,
                    'jumlah' => $jumlahTerkaitDewasa,
                    'harga_satuan' => $relatedTicketHargaDewasa,
                    'subtotal' => $jumlahTerkaitDewasa * $relatedTicketHargaDewasa,
                    'keterangan' => $relatedTicketName . ' Dewasa',
                    'tanggal_kunjungan' => $selectedDate,
                ]);
            }
        }

        return redirect()->route('payment.page', ['kode_pembelian' => $pembelian->kode_pembelian]);
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get(); // Ambil item keranjang dari tabel berdasarkan user_id

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Keranjang Anda kosong.']);
        }

        // Hitung total harga dan jumlah tiket
        $totalHarga = 0;
        $jumlahTiket = 0;

        foreach ($cartItems as $item) {
            $totalHarga += ($item->harga_anak * $item->quantity_anak) + ($item->harga_dewasa * $item->quantity_dewasa);
            $jumlahTiket += $item->quantity_anak + $item->quantity_dewasa;
        }

        // Buat pembelian tiket
        $pembelian = PembelianTiket::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'kode_pembelian' => Str::random(10),
            'jumlah_tiket' => $jumlahTiket,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'pending',
            'status' => 'active',
            'expired_at' => Carbon::now()->addMinutes(15)
        ]);

        // Buat detail pembelian tiket
        foreach ($cartItems as $item) {
            if ($item->quantity_anak > 0) {
                DetailPembelian::create([
                    'id' => Str::uuid(),
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $item->tiket_id,
                    'jumlah' => $item->quantity_anak,
                    'harga_satuan' => $item->harga_anak,
                    'subtotal' => $item->harga_anak * $item->quantity_anak,
                    'keterangan' => $item->tiket->nama . ' Anak',
                    'tanggal_kunjungan' => $item->tanggal_kunjungan,
                ]);
            }

            if ($item->quantity_dewasa > 0) {
                DetailPembelian::create([
                    'id' => Str::uuid(),
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $item->tiket_id,
                    'jumlah' => $item->quantity_dewasa,
                    'harga_satuan' => $item->harga_dewasa,
                    'subtotal' => $item->harga_dewasa * $item->quantity_dewasa,
                    'keterangan' => $item->tiket->nama . ' Dewasa',
                    'tanggal_kunjungan' => $item->tanggal_kunjungan,
                ]);
            }
        }

        // Hapus item dari keranjang setelah checkout
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('payment.page', ['kode_pembelian' => $pembelian->kode_pembelian]);
    }

}
