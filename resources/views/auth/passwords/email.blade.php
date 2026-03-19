@extends('layouts.app')

@section('content')

<div class="container">
        <div class="image-section">
            <img src="{{ asset('back/connexion/img/forget.jpg') }}"
                alt="African woman in headwrap">
        </div>
        <div class="login-section">
            <div class="login-header">
                <h2><i class="bi bi-send-check"></i> Réinitialisation du mot de passe</h2>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form id="login-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Identifiant</label>
                    <input type="text" id="username" name="username" placeholder="email, telephone ou identifiant" value="{{ old('username') }}" class="@error('username') is-invalid @enderror" required autofocus />

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">Envoyer le lien de réinitialisation</button>
            </form>
            <div class="create-account">
                <a href="{{ route('login') }}">Retour à la connexion</a>
            </div>
        </div>
</div>
@endsection
