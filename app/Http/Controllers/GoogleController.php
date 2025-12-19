<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;

class GoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $user = Socialite::driver('google')->user();

            $findUser = User::where(function ($q) use ($user) {
                            $q->where('google_id', $user->getId())->orWhere('email', $user->getEmail());
                        })
                        ->first();

            if ($findUser) {
                // Cek apakah email sudah terverifikasi
                if (!$findUser->hasVerifiedEmail()) {
                    Auth::login($findUser);
                    return redirect()->route('verification.notice');
                }

                Auth::login($findUser);
                return redirect()->route('dashboard');
            } else {
                // Buat user baru TANPA email_verified_at
                // Sehingga mereka harus verifikasi email manual
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'email_verified_at' => null, // Tidak langsung diverifikasi
                    'password' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, eligendi.',
                ]);

                // Assign user role
                $newUser->assignRole('user');

                // Trigger event untuk mengirim email verifikasi
                event(new Registered($newUser));

                Auth::login($newUser);
                
                // Redirect ke halaman verifikasi email
                return redirect()->route('verification.notice');
            }
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

}


