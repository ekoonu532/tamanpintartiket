<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\TryCatch;

class ProviderController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::updateOrCreate([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ],[
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'username' => User::generateUsername($socialUser->nickname),
                'provider_token' => $socialUser->token,
            ]);
        //      if (!$user->hasVerifiedEmail()) {
        //     $user->sendEmailVerificationNotification();
        //     return redirect()->route('verification.notice');
        // }

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Login with Google failed: ' . $e->getMessage()]);
        }
    }

}
