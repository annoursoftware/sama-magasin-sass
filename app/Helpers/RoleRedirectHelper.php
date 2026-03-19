<?php
namespace App\Helpers;

class RoleRedirectHelper
{
    /**
     * Retourne l'URL de redirection selon le rôle utilisateur.
     */
    public static function getRedirectUrlByRole(int $roleId): string
    {
        $env = app()->environment(); // "local", "staging", "production"
        $redirects = config('roles.redirects.'.$env, []);
        $productionRedirects = config('roles.redirects.production', []);

        // Fallback automatiquement vers "production" si l'environnement n'est pas défini
        $routeName = $redirects[$roleId] ?? $productionRedirects[$roleId] ?? null;

        return route($routeName) ?? 'home';
    }
}
