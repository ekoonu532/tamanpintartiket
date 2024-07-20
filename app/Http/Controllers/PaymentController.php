<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pembayaran;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Models\PembelianTiket;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($kodePembelian)
    {
        $pembelian = PembelianTiket::where('kode_pembelian', $kodePembelian)->firstOrFail();
        $detailPembelian = DetailPembelian::where('pembelian_id', $pembelian->id)->get();



        // Cek apakah pembayaran sudah kadaluwarsa
        if (Carbon::now()->greaterThan($pembelian->expired_at)) {
            return redirect()->route('payment.failed')->with('error', 'Pesanan sudah kedaluwarsa.');
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $user = Auth::user();
        $params = [
            'transaction_details' => [
                'order_id' => $pembelian->kode_pembelian,
                'gross_amount' => $pembelian->total_harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return view('payment', compact('pembelian', 'detailPembelian', 'snapToken'));
    }

    public function processPayment(Request $request)
    {
        Log::info('Processing payment for order: ' . $request->input('kode_pembelian'));

        $kodePembelian = $request->input('kode_pembelian');
        $pembelian = PembelianTiket::where('kode_pembelian', $kodePembelian)->firstOrFail();

        Log::info('Order found: ' . $pembelian->id);

        Pembayaran::create([
            'pembelian_tiket_id' => $pembelian->id,
            'total_bayar' => $pembelian->total_harga,
            'metode_pembayaran' => 'Midtrans',
            'status' => 'unpaid'
        ]);

        Log::info('Payment record created for order: ' . $pembelian->id);

        return redirect()->route('payment.success', ['kode_pembelian' => $kodePembelian]);
    }

    public function success($kodePembelian)
    {
        $pembelian = PembelianTiket::where('kode_pembelian', $kodePembelian)->firstOrFail();
        return view('payment-success', compact('pembelian'));
    }

    public function paymentFailed()
    {
        // $pembelian = PembelianTiket::where('kode_pembelian', $kodePembelian)->firstOrFail();
        return view('payment-failed');
    }

    public function notificationHandler(Request $request)
{
    Log::info('Notification received from Midtrans', $request->all());

    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($hashed === $request->signature_key) {
        try {
            $pembelian = PembelianTiket::where('kode_pembelian', $request->order_id)->firstOrFail();
            Log::info('Order found for notification: ' . $pembelian->id);

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $pembelian->status_pembayaran = 'success';
            } elseif ($request->transaction_status == 'pending') {
                $pembelian->status_pembayaran = 'pending';
            } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                $pembelian->status_pembayaran = 'failed';
            }

            $pembelian->save();
            Log::info('Order status updated for notification: ' . $pembelian->id);

            $pembayaran = Pembayaran::where('pembelian_tiket_id', $pembelian->id)->first();
            if ($pembayaran) {
                Log::info('Payment record found for order: ' . $pembelian->id);
                $pembayaran->status = $pembelian->status_pembayaran == 'success' ? 'paid' : 'unpaid';
                $pembayaran->save();
                Log::info('Payment record updated for order: ' . $pembelian->id);
            }

            return response()->json(['message' => 'Notification received and processed.']);
        } catch (\Exception $e) {
            Log::error('Error processing notification: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    } else {
        Log::warning('Signature key mismatch for order: ' . $request->order_id);
        return response()->json(['message' => 'Invalid signature key'], 400);
    }
}

}
