<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try{

            $googleUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $googleUser->id)->first();
        if ($user) {
            Auth::login($user);
            return redirect()->route('balai');
        } else {
            $userData = User::create([
                'name' => $googleUser -> name,
                'email' => $googleUser ->email,
                'password' => Hash::make('Password@1234'),
                'google_id' => $googleUser -> id,
            ]);

            if ($userData) {
                Auth::login($userData);
                return redirect()->route('balai');
            }
        }

        } catch(Exception $e){
            dd($e);
        }


    }
}
