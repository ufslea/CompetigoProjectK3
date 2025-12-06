<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        return $this->redirectAfterLogin($user);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $exception) {
            return redirect()->route('login')->withErrors([
                'google' => 'Gagal redirect ke Google: '.$exception->getMessage(),
            ]);
        }
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            // Prepare Guzzle HTTP client with certificate verification
            $guzzleOptions = [
                'timeout' => 30,
                'connect_timeout' => 10,
            ];

            // Use the CA bundle for HTTPS verification
            $caPath = base_path('storage/app/cacert.pem');
            if (file_exists($caPath)) {
                $guzzleOptions['verify'] = $caPath;
            }

            $client = new Client($guzzleOptions);
            $driver = Socialite::driver('google');
            $driver->setHttpClient($client);

            $googleUser = $driver->stateless()->user();
            
            \Log::info('Google user authenticated', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
            ]);
        } catch (\Exception $exception) {
            \Log::error('Google Auth Error', [
                'message' => $exception->getMessage(),
                'class' => get_class($exception),
                'trace' => $exception->getTraceAsString()
            ]);
            return redirect()->route('login')->withErrors([
                'google' => 'Gagal autentikasi Google: '.$exception->getMessage(),
            ]);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'nama' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(32)),
                'role' => 'participant',
            ]);

            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // Paksa semua login Google ke dashboard participant
        if (Route::has('participant.dashboard')) {
            return redirect()->route('participant.dashboard');
        }

        return $this->redirectAfterLogin($user);
    }

    protected function redirectAfterLogin(?User $user): RedirectResponse
    {
        if ($user && $user->role === 'organizer' && Route::has('organizer.dashboard')) {
            return redirect()->route('organizer.dashboard');
        }

        if ($user && $user->role === 'participant' && Route::has('participant.dashboard')) {
            return redirect()->route('participant.dashboard');
        }

        if ($user && $user->role === 'admin' && Route::has('admin.dashboard')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended('/dashboard');
    }
}
