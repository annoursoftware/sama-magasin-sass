<?php

namespace App\Services;

use App\Mail\MFACodeMail;
use Illuminate\Support\Facades\Mail;

class MfaEmailService
{
    public function send($user, $code)
    {
        // Mail::to($user->email)->send(new MFACodeMail($code));
        try {
            Mail::to($user->email)->send(new MFACodeMail($code));
            \Log::info('Envoi MFA Email réussi');
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l\'envoi du MFA Email : " . $e->getMessage());
            throw $e;
        }
    }
}
