<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PembelianTiket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function pesanan(Request $request)
    {
        $status = $request->input('status', 'all');
        $userId = Auth::id();

        // Periksa dan perbarui status pesanan yang kedaluwarsa
        PembelianTiket::where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->where('expired_at', '<', Carbon::now())
            ->update(['status_pembayaran' => 'failed']);

        // Query pesanan berdasarkan status
        $query = PembelianTiket::where('user_id', $userId);
        if ($status !== 'all') {
            $query->where('status_pembayaran', $status);
        }
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('profile.pesanan-saya', compact('orders', 'status'));
    }
}
