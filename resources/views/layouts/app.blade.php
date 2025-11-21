<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
</head>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('back/connexion/css/style.css') }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <style>
        input:not([type="file"]).error, textarea.error, select.error {
            border: 1px solid red !important;
        }

        input:not([type="file"]).no-error, textarea.no-error, select.no-error {
            border: 1px solid green !important;
        }

        div.error-field {
            color: red;
            font-size: small;
        }
    </style>
    
    <title>Sama Magasin | LOGIN</title>
</head>

<body>
    {{-- <div class="container">
        <div class="image-section">
            <img src="https://s3-eu-central-1.amazonaws.com/glossika-blog/2021/10/oladimeji-odunsi-tUUmR82pq68-unsplash.jpg"
                alt="African woman in headwrap">
        </div>
        <div class="login-section">
            <div class="login-header">
                <h1 class="text-center"><i class="bi bi-shield-lock"></i> Connexion</h1>
            </div>
            <form id="login-form">
                <div class="form-group">
                    <label for="username">Identifiant</label>
                    <input type="text" id="username" name="username" required autofocus placeholder="email, telephone ou identifiant">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required placeholder="mot de passe">
                </div>
                <div class="forgot-password">
                    <a href="#">Forgot your password?</a>
                </div>
                <button type="submit" class="submit-btn">SUBMIT</button>
            </form>
            <div class="create-account">
                <a href="#">Create an Account</a>
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
    </div> --}}
    @yield('content')
    <script>
        document.getElementById("login-form").addEventListener("submit", function (e) {
            e.preventDefault();
            // Add your login logic here
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            console.log("Login attempted with:", { username, password });
        });
    </script>
    
    <!-- jQuery -->
    <script src="{{ asset('back/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('back/validation/jquery-simple-validator.min.js') }}"></script>
</body>

</html>