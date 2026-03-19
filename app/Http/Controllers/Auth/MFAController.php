<?php
namespace App\Http\Controllers\Auth;

use App\Helpers\RoleRedirectHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MfaEmailService;
use App\Services\MfaSmsService;
use App\Services\MfaTotpService;
use Illuminate\Support\Facades\Hash;

class MFAController extends Controller
{
    /**
     * Affiche le formulaire de vérification MFA.
     */
    public function showVerify(Request $request)
    {
        if (!session()->has('mfa_user_id')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session MFA introuvable. Veuillez vous reconnecter.',
                    'redirect_url' => route('login'),
                ], 401);
            }

            return redirect()->route('login');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Veuillez entrer votre code MFA.',
            ]);
        }

        return view('auth.mfa_verify');
    }

    /**
     * Envoie le code MFA par email ou SMS.
     */
    public function sendCode(Request $request, MfaEmailService $email, MfaSmsService $sms)
    {
        $user = User::find(session('mfa_user_id'));
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur introuvable.',
                ], 404);
            }
            
            return redirect()->route('login')->withErrors([
                'login' => 'Utilisateur introuvable.'
            ]);
        }

        $code = random_int(100000, 999999);

        session([
            'mfa_code' => Hash::make($code),
            'mfa_expires' => now()->addMinutes(5),
            'mfa_attempts' => 0,
        ]);

        if (session('mfa_method') === 'sms') {
            $sms->send($user, $code);
        } else {
            $email->send($user, $code);
        }
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Code envoyé via ' . session('mfa_method'),
            ]);
        }

        return back()->with('status', 'Code envoyé');
    }

    public function resend(Request $request, MfaEmailService $email, MfaSmsService $sms)
    {
        if (!session()->has('mfa_user_id')) {
            return response()->json(['success' => false, 'message' => 'Session MFA invalide'], 422);
        }

        // Réutiliser la logique de sendCode
        return $this->sendCode($request, $email, $sms);
    }


    /**
     * Envoie le code MFA par email ou SMS.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        // Vérification de l'expiration du code
        $expires = session('mfa_expires');
        if (!$expires) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Aucun code MFA en session'
                ], 422)
                : back()->withErrors(['code' => 'Aucun code MFA en cours. Veuillez redemander un nouveau code.']);
        }

        // Vérifier si le code a expiré
        if (now()->greaterThan($expires)) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Le code a expiré'
                ], 422)
                : back()->withErrors(['code' => 'Le code a expiré']);
        }

        //Limiter le nombre de tentatives
        $attempts = session('mfa_attempts', 0);
        if ($attempts >= 5) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Trop de tentatives'
                ], 429)
                : back()->withErrors(['code' => 'Trop de tentatives. Veuillez redemander un nouveau code.']);
        }
        session(['mfa_attempts' => $attempts+1]);

        // Vérification du code
        if (!Hash::check($request->code, session('mfa_code'))) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Code incorrect',
                    'remaining_attempts' => 5 - ($attempts + 1),
                ], 422)
                : back()->withErrors(['code' => 'Code incorrect']);
        }

        $user = User::find(session('mfa_user_id'));
        if (!$user) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Utilisateur introuvable'
                ], 404)
                : back()->withErrors(['code' => 'Utilisateur introuvable.']);
        }

        // Connexion de l'utilisateur
        Auth::login($user, session('mfa_remember', false));
        session(['mfa_verified' => true]);

        // Nettoyer les données MFA de la session
        session()->forget([
            'mfa_user_id', 
            'mfa_code', 
            'mfa_expires', 
            'mfa_method', 
            'mfa_attempts'
        ]);

        // Redirection par rôle
        $redirectUrl = RoleRedirectHelper::getRedirectUrlByRole($user->role_id);

        return $request->expectsJson()
                ? response()->json([
                    'success' => true, 
                    'message' => 'MFA vérifié. Redirection en cours.', 
                    'redirect_url' => $redirectUrl
                ])
                : redirect($redirectUrl);
    }

    /**
     * Vérifie le code TOTP (Google Authenticator, etc.).
     */
    public function verifyTotp(Request $request, MfaTotpService $totp)
    {
        $user = User::find(session('mfa_user_id'));
        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Utilisateur introuvable'], 404)
                : back()->withErrors(['code' => 'Utilisateur introuvable.']);
        }

        if ($totp->verify($user->mfa_secret, $request->code)) {
            Auth::login($user, session('mfa_remember', false));
            session(['mfa_verified' => true]);
            session()->forget(['mfa_user_id', 'mfa_remember']);
            
            // Redirection par rôle
            $redirectUrl = RoleRedirectHelper::getRedirectUrlByRole($user->role_id);
            
            return $request->expectsJson()
                ? response()->json([
                    'success' => true, 
                    'message' => 'MFA vérifié. Redirection en cours.', 
                    'redirect_url' => $redirectUrl
                ])
                : redirect($redirectUrl);
        }
        
        return $request->expectsJson()
                ? response()->json([
                    'success' => false, 
                    'message' => 'Code incorrect'
                ], 422)
                : back()->withErrors(['code' => 'Code incorrect']);
    }
}
