@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="container">
        <div class="image-section">
            {{-- <img src="https://s3-eu-central-1.amazonaws.com/glossika-blog/2021/10/oladimeji-odunsi-tUUmR82pq68-unsplash.jpg"
                alt="African woman in headwrap"> --}}
            <img src="{{ asset('back/connexion/img/login.jpg') }}"
                alt="Slogan">
        </div>
        <div class="login-section">
            <div class="login-header">
                <h1 class="text-center"><i class="bi bi-shield-lock"></i> Connexion</h1>
            </div>
            
            
            <form id="login-form" method="POST" action="{{ route('login') }}" validate="true">
                @csrf

                <div class="section-error">
                    <div class="col-12">
                        <blockquote class="quote-danger print-error-msg" style="display:none">
                            <ul style="color: red"></ul>
                        </blockquote>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="username">Identifiant</label>
                    <input  
                        type="text" id="username" name="login" placeholder="email, telephone ou identifiant" 
                        value="{{ old('login') }}" class="@error('login') is-invalid @enderror" required autofocus />

                    @error('login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required placeholder="mot de passe" class="@error('password') is-invalid @enderror">
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('mot de passe oublié ?') }}</a>
                    @endif
                </div>
                <button type="submit" class="submit-btn" id="login-btn">Connexion</button>
            </form>
            <div class="create-account">
                <a href="{{ route('register') }}">Créer un compte</a>
            </div>
            <div class="alternative-login">
                <p>Or</p>
                <div class="social-login">
                    <div class="social-btn">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z' fill='%234285F4'/%3E%3C/svg%3E"
                            alt="Google login">
                    </div>
                    <div class="social-btn">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12,2C6.477,2,2,6.477,2,12c0,5.013,3.693,9.153,8.505,9.876V14.65H8.031v-2.629h2.474v-1.749 c0-2.896,1.411-4.167,3.818-4.167c1.153,0,1.762,0.085,2.051,0.124v2.294h-1.642c-1.022,0-1.379,0.969-1.379,2.061v1.437h2.995 l-0.406,2.629h-2.588v7.226C18.307,21.153,22,17.013,22,12C22,6.477,17.523,2,12,2z' fill='%231877F2'/%3E%3C/svg%3E"
                            alt="Facebook login">
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        let isSubmitting = false;
        $('#login-form').submit(function (e) {
            e.preventDefault();
            /* $('#login-btn').prepend('<i class="bi bi-arrow-repeat"></i>'); */
            $('#login-btn').html('<i class="fa-solid fa-sync fa-spin"></i>'+' En cours de vérification...');
            
            if (isSubmitting) {
                return; // Prevent multiple submissions
            }
            isSubmitting = true;

            let formData = new FormData(this);

            url = $(this).attr('action');
        
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#login-btn').html('Ouverture du tableau de bord...');
                    $('#login-form').trigger("reset");
                    setTimeout(function() {
                        $('#login-btn').html('<i class="bi bi-check-all" style="font-size:20px"></i>'+' '+response.message);
                    }, 500); // 2000 milliseconds = 2 seconds

                    if (response.success) {
                        setTimeout(function() {
                            window.location.href = response.redirect_url;
                        }, 2000); // 2000 milliseconds = 2 seconds
                    } else {
                        setTimeout(function() {
                            /* alert(response.message) */
                            //$('#login-form').find(".print-error-msg").append('<span>' + response.message + '</span>');
                            $('.print-error-msg ul').html('');
                            $('.print-error-msg').show();
                            $('.print-error-msg ul').append('<li>' + response.message + '</li>');
                        }, 300); // 300 milliseconds = 0.3 seconds
                    }
                },
                error: function (response) {
                    $('#login-form').find(".print-error-msg").find("ul").html('');
                    $('#login-form').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#login-form').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });
                    
                    $('#login-btn').html('Connexion');
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                }
            });
        });
    </script>
@endpush