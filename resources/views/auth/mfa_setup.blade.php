@extends('layouts.app')

@section('content')

<div class="container">
        <div class="image-section">
            {{-- <img src="https://s3-eu-central-1.amazonaws.com/glossika-blog/2021/10/oladimeji-odunsi-tUUmR82pq68-unsplash.jpg"
                alt="African woman in headwrap"> --}}
            <img src="{{ asset('back/connexion/img/otp.jpg') }}"
                alt="OTP">
        </div>
        <div class="login-section">
            <div class="login-header">
                <h1 class="text-center"><i class="bi bi-phone"></i> Configuration MFA</h1>
            </div>
            
            <p>Scannez le code QR ci-dessous avec votre application d'authentification pour configurer MFA :</p>  
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($qrUrl) }}&size=200x200" alt="QR Code">  
            
            <div class="create-account">
                <a href="{{ route('login') }}">Retour à la page de connexion</a>
            </div>
        </div>
</div>
@endsection
