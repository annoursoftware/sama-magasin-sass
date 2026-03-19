<?php

namespace App\Services;

use OTPHP\TOTP;

class MfaTotpService
{
    public function generateSecret()
    {
        $totp = TOTP::create();
        return $totp->getSecret();
    }

    public function getQrUrl($user, $secret)
    {
        $totp = TOTP::create($secret);
        $totp->setLabel($user->email);
        $totp->setIssuer('MonAppLaravel');
        return $totp->getProvisioningUri();
    }

    public function verify($secret, $code)
    {
        $totp = TOTP::create($secret);
        return $totp->verify($code);
    }
}
