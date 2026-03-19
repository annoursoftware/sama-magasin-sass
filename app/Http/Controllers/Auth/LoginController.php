<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RoleRedirectHelper;
use App\Http\Controllers\Controller;
use App\Services\MfaEmailService;
use App\Services\MfaSmsService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, MfaEmailService $email, MfaSmsService $sms)
    {
        // Validate input
        $request->validate([
            'login'    => ['required', 'string'], // can be email, username, or phone
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Le champ identifiant est obligatoire.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
        ]);

        // Determine login field type
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : (
            is_numeric($request->login) ? 'telephone' : 'username'
        );

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            //Vérifier si MFA est activé
            if ($user->mfa_enabled==1) {
                # code...
                Auth::logout(); // Immediately log out the user
                $login = $request->input('login');
                $method = is_numeric($login) ? 'sms' : 'email';

                session([
                    'mfa_user_id' => $user->id,
                    'mfa_method' => $method,
                    'mfa_remember' => $request->filled('remember'),
                ]); // Store user ID in session for MFA
                
                // 🔥 Délégation vers MFAController@sendCode
                $mfaController = app(MFAController::class);
                $response = $mfaController->sendCode($request, $email, $sms);
                
                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    \Log::info('MFA code envoyé', ['method' => session('mfa_method')]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Authentification à deux facteurs requise. Redirection en cours...',
                    'redirect_url' => route('mfa.show'),
                ]);
            }

            // Redirection par rôle
            $redirectUrl = RoleRedirectHelper::getRedirectUrlByRole($user->role_id);

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie. Redirection en cours.',
                'redirect_url' => $redirectUrl ,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => "Les informations d'identification fournies ne correspondent pas à nos enregistrements.",
                'errors' => [
                    'login' => ["Les informations d'identification fournies ne correspondent pas à nos enregistrements."]
                ]
            ], 422); // 422: Unprocessable Entity
        }
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    protected function maxAttempts()
    {
        return 5; // default
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    protected function decayMinutes()
    {
        return 1; // default
    }

    /**
     * Summary of logout
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
