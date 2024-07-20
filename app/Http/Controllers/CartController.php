<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\Wahana; // Import class Cart

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('tiket.kategoriTiket')->get();

        return view('cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
{
    $request->validate([
        'kategori' => 'required|string',
        'tiket_id' => 'required|string',
        'tanggal_kunjungan' => 'required|date',
    ]);

    $userId = Auth::id();
    $tanggalKunjungan = $request->tanggal_kunjungan;

    // Periksa apakah tanggal kunjungan sudah ada di keranjang
    $existingCartItem = Cart::where('user_id', $userId)
                            ->where('tanggal_kunjungan', $tanggalKunjungan)
                            ->first();

    if ($existingCartItem) {
        // Jika tanggal kunjungan sudah ada di keranjang, kembalikan respons error
        return response()->json(['success' => false, 'message' => 'Tanggal kunjungan ini sudah ada di keranjang silahkan pilih tanggal kunjungan lain'], 400);
    }

    // Tambahkan tiket ke keranjang
    Cart::create([
        'user_id' => Auth::id(),
        'tiket_id' => $request->tiket_id,
        'quantity_anak' => 0,
        'quantity_dewasa' => 0,
        'harga_anak' => 0,
        'harga_dewasa' => 0,
        'tanggal_kunjungan' => $tanggalKunjungan,
    ]);

    return response()->json(['success' => true]);
}

    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->quantity_anak = $request->quantity_anak ?? 0;
            $cartItem->quantity_dewasa = $request->quantity_dewasa ?? 0;
            $cartItem->harga_anak = $cartItem->tiket->harga_anak * $cartItem->quantity_anak;
            $cartItem->harga_dewasa = $cartItem->tiket->harga_dewasa * $cartItem->quantity_dewasa;
            $cartItem->save();

            return Response::json(['success' => true]);
        }

        return Response::json(['success' => false], 403);
    }

    public function remove($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Tiket berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        $userId = Auth::id();
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('cart.index')->with('success', 'Checkout berhasil.');
    }

    public function getCartCount()
{
    $userId = Auth::id();
    $cartCount = Cart::where('user_id', $userId)->count();
    return response()->json(['cartCount' => $cartCount]);
}

}
