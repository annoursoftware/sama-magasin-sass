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
                <h1 class="text-center"><i class="bi bi-phone"></i> Vérification MFA</h1>
                <p class="text-center">
                    Un code MFA vous a été envoyé par <strong>{{ session('mfa_method') === 'sms' ? 'SMS' : 'Email' }}</strong>
                </p>

                @if (session('status') )
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div> 
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
            
            <form id="login-form" method="POST" action="{{ route('mfa.verify.otp') }}" validate="true">
                @csrf

                <div class="section-error">
                    <div class="col-12">
                        <blockquote class="quote-danger print-error-msg" style="display:none">
                            <ul style="color: red"></ul>
                        </blockquote>
                    </div>
                </div>
                
                <div class="form-group">
                    {{-- <label for="code">Code OTP</label> --}}
                    <input type="text" id="code" name="code" placeholder="Code OTP" maxlength="6"
                            pattern="\d{6}" required autofocus />
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn" id="login-btn">Vérification</button>
            </form>
            
            {{-- <div class="forgot-password">
                <form action="{{ route('mfa.resend') }}" method="POST">
                    @csrf
                    <button type="submit" class="resend-btn" id="resend-btn">Renvoyer le code</button>
                </form>
            </div> --}}
            <div class="alternative-login">
                <p>Renvoyer le code</p>
                <form action="{{-- {{ route('mfa.resend') }} --}}" method="POST">
                    @csrf
                    <div class="social-login">
                        <div class="social-btn">
                            <button type="submit" class="resend-btn" id="resend-btn">Renvoyer le code</button>
                        </div>
                    </div>
                </form>
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
                    /* setTimeout(function() {
                        window.location.href = "http://sama-magasin-sass.sn/dev/dashboard";
                    }, 2000); // 2000 milliseconds = 2 seconds */

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
                },
                complete: function() {
                    isSubmitting = false; // Reset the flag
                }
            });
        });
    </script>
@endpush