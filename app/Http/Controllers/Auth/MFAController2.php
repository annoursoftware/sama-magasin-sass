<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MFACodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use OTPHP\TOTP;
use App\Mail\OtpMail; 
class MFAController2 extends Controller
{
    /**
     * Show the MFA verification form.
     */
    public function showVerify()
    {
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.mfa_verify');
    }

    /**
     * Send the MFA code via email or SMS.
     */
    public function sendCode()
    {
        $user = User::find(session('mfa_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        $code = rand(100000, 999999);

        session(['mfa_code' => $code, 'mfa_expires' => now()->addMinutes(5)]);

        if (session('mfa_method') === 'sms') {
            // SMS provider
            // SmsService::send($user->telephone, "Votre code MFA est : $code");
        } else {
            try {
                Mail::to($user->email)->send(new MFACodeMail($code));
                return "Email sent successfully!";
            } catch (\Exception $e) {
                return "Failed to send email: " . $e->getMessage();
            }
        }

        return back()->with('status', 'Code envoyé');
    }
    
    /**
     * Verify the MFA code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6']
        ],[
            'code.required' => 'Le code est obligatoire.',
            'code.digits' => 'Le code doit contenir 6 chiffres.',
        ]);

        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        if (now()->greaterThan(session('mfa_expires'))) {
            return back()->withErrors(['code' => 'Le code a expiré']);
        }

        if ($request->code != session('mfa_code')) {
            return back()->withErrors(['code' => 'Code incorrect']);
        }

        $user = User::find(session('mfa_user_id'));

        // Authentifier l'utilisateur
        Auth::login($user, session('mfa_remember'));

        // Nettoyage session MFA
        session()->forget(['mfa_user_id', 'mfa_code', 'mfa_expires', 'mfa_method']);

        // Redirection vers la destination initiale
        return redirect()->intended('/');
    }

    /**
     * Send OTP via email.
     */
    public function sendOtp(Request $request) 
    { 
        $otp = rand(100000, 999999); // Génère un code à 6 chiffres 
        // Sauvegarder l’OTP en base ou en cache avec expiration 
        cache()->put('otp_'.$request->user()->id, $otp, now()->addMinutes(5)); 
        // Envoyer l’email 
        Mail::to($request->user()->email)->send(new OtpMail($otp)); 
        return response()->json(['message' => 'OTP envoyé par email']); 
    }

    /**
     * Verify the MFA code.
     */
    public function old_verify(Request $request)
    {
        /* $request->validate(['code' => 'required']);
        $user = User::find(session('mfa_user_id'));

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Session expirée']);
        }

        $totp = TOTP::create($user->mfa_secret);
        if ($totp->verify($request->code)) {
            Auth::login($user);
            session()->forget('mfa_user_id');
            return redirect()->intended('home');
        }

        return back()->withErrors(['code' => 'Code invalide']); */

        /* Nouveau code */
        $request->validate([
            'code' => ['required', 'digits:6']
        ],[
            'code.required' => 'Le code est obligatoire.',
            'code.digits' => 'Le code doit contenir 6 chiffres.',
        ]);

        // Récupérer l'utilisateur depuis la session
        $userId = session('mfa_user_id');
        if (!$userId) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Session expirée, veuillez vous reconnecter.']);
        }

        $user = User::find($userId);
        if (!$user || !$user->mfa_secret) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Utilisateur ou secret MFA introuvable.']);
        }

        /* Vérification du code TOTP */
        $totp = TOTP::create($user->mfa_secret);
        if ($totp->verify($request->code)) {
            // Authentifier l'utilisateur
            Auth::login($user, session('mfa_remember', false));

            // Nettoyer la session MFA
            session()->forget(['mfa_user_id', 'mfa_remember']);

            return redirect()->intended('home');
        }

        return back()->withErrors(['code' => 'Code invalide ou expiré.']);    

    }

    /**
     * Show the MFA setup form.
     */
    public function setup(Request $request)
    {
        //dd($request->user());
        /* $user = DB::table('users')
            ->where('id', $request->user()->id)
            ->first();
        $secret = \Illuminate\Support\Str::random(32);

        $user->update([
            'mfa_secret' => $secret,
            'mfa_enabled' => true,
        ]);

        $totp = TOTP::create($secret);
        $totp->setLabel($user->email);
        $totp->setIssuer('MonAppLaravel');

        $qrUrl = $totp->getProvisioningUri();

        return view('auth.mfa_setup', compact('qrUrl')); */
        $user = User::findOrFail($request->user()->id); 
        // Générer un secret TOTP 
        $totp = TOTP::create(); 
        $secret = $totp->getSecret(); 
        $user->update([ 
            'mfa_secret' => $secret, 
            'mfa_enabled' => true, 
        ]); 
        $totp->setLabel($user->email); 
        $totp->setIssuer('MonAppLaravel'); 
        $qrUrl = $totp->getProvisioningUri(); 
        return view('auth.mfa_setup', compact('qrUrl'));
    }

}