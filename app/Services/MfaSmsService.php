<?php

namespace App\Services;

use Twilio\Rest\Client;

class MfaSmsService
{
    /* protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    } */

    public function send($user, $code)
    {
        try {
            //code...
            $id = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.from');

            $client = new Client($id, $token);
            $telephone_usager = '+221771583558';//.$user->telephone;
            /* $client->verify->v2->services("VA7d681a815483eb6cbd7d4bee6ca73ace")
                                   ->verifications
                                   ->create($telephone_usager, "sms"); */
            $client->messages->create(
                $telephone_usager, //numéro du destinataire
                [
                    'from' => $from,
                    'body' => "Votre code MFA est : ".$code
                ]
            );
            \Log::info('MFA SMS envoyé', ['to' => $user->telephone]);
        } catch (\Exception $e) {
            //throw $th;
            \Log::error('Erreur envoi MFA SMS', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
