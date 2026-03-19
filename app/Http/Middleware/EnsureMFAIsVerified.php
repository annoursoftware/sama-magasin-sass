<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMFAIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->mfa_enabled) {
            if (!session()->has('mfa_verified') || !session('mfa_verified')) {
                // Déconnexion immédiate pour éviter une session non validée
                Auth::logout(); // Log out the user
                
                // Stocker les infos nécessaires pour MFA
                session([
                    'mfa_user_id' => Auth::user()->id,
                    'mfa_method' => is_numeric(Auth::user()->telephone ?? '') ? 'sms' : 'email',
                    'mfa_remember' => $request->filled('remember'),
                ]); // Store user ID in session for MFA
                
                // 🔹 API-first : réponse JSON si la requête attend du JSON
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Authentification à deux facteurs requise.',
                        'redirect_url' => route('mfa.show'),
                    ], 403);
                }

                // fallback web
                return redirect()->route('mfa.show');
            }
        }
        return $next($request);
    }
}
