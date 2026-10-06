@php

$companyProfile = DB::table('tbl_general')->where('id',1)->first();

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | {{ $companyProfile->school_name }}
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/dist/css/adminlte.min.css') }}">

    <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #1abc9c;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Source Sans Pro', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }

    .login-card {
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        background: white;
        display: flex;
        min-height: 600px;
    }

    .login-image {
        flex: 1;
        background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)),
        url('{{ url("public/firstnutrition_login.png") }}') center/cover no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        color: white;
        text-align: center;
    }

    .login-image h2 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 2rem;
    }

    .login-image p {
        font-size: 1.1rem;
        line-height: 1.6;
        max-width: 400px;
    }

    .login-form {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-logo img {
        max-width: 120px;
        margin-bottom: 15px;
    }

    .login-logo h3 {
        color: var(--secondary-color);
        font-weight: 700;
        margin: 0;
    }

    .login-title {
        text-align: center;
        margin-bottom: 30px;
        color: var(--secondary-color);
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .form-group label i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e1e5eb;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .btn-group-toggle {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .btn-group-toggle .btn {
        border-radius: 6px;
        padding: 10px;
        font-size: 0.85rem;
        transition: var(--transition);
        border: 1px solid #e1e5eb;
        background: white;
        color: var(--dark-color);
    }

    .btn-group-toggle .btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }

    .login-links {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .login-links a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .login-links a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .alert {
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .login-card {
            flex-direction: column;
        }

        .login-image {
            display: none;
        }

        .login-form {
            padding: 30px;
        }
    }

    @media (max-width: 575.98px) {
        .btn-group-toggle {
            grid-template-columns: repeat(2, 1fr);
        }

        .login-links {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
    }
    </style>
</head>

<body>


    <div class="login-container">
        <div class="login-card">
            <!-- Image Section -->
            <div class="login-image">
                <h2>Welcome to {{ $companyProfile->school_name }}
                </h2>
                <p>Empowering education through innovative solutions and dedicated support for administrators, staff,
                    and faculty.</p>
                <div class="mt-4">
                    <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                    <p>Your gateway to managing educational excellence</p>
                </div>
            </div>

            <!-- Login Form Section -->
            <div class="login-form">
                <div class="login-logo">
                    <img src="{{ asset('public/uploads/'.$companyProfile->company_logo) }}" alt="{{ $companyProfile->school_name }}
 Logo" onerror="this.alt='Logo not found';">
                    <h3>{{ $companyProfile->school_name }}
                    </h3>
                </div>

                <h2 class="login-title">Admin Portal</h2>

                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
                @endif

                <div id="loginLoader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                 background-color: rgba(255, 255, 255, 0.9); z-index: 9999; text-align: center; padding-top: 20%;">
                    <div>
                        <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..." width="60" />
                        <p style="font-size: 18px; font-weight: bold; color: #333; margin-top: 15px;">
                            Processing your login panel...
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email address"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required>
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter your password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-group">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>

                    <!-- Login As -->
                    <div class="form-group">
                        <label class="d-block mb-2"><strong>Login As:</strong></label>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            @php
                            
                            $types = ['admin','teacher','subadmin'];
                            @endphp
                            @foreach($types as $index => $type)
                            <label class="btn {{ $index==0 ? 'active' : '' }}">
                                <input type="radio" name="loginAs" value="{{ $type }}" {{ $index==0 ? 'checked' : '' }}>
                                {{ ucfirst($type) }}
                            </label>
                            @endforeach
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                    </div>
                </form>

                <!-- Forgot Password & Register Links -->
                <!-- <div class="login-links">
                    <a href="{{ url('forgot-password') }}"><i class="fas fa-key mr-1"></i> Forgot Password?</a>
                    <a href="{{ url('register') }}"><i class="fas fa-user-plus mr-1"></i> Create New Account</a>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>

    <script>
    // Add animation to form elements on focus
    $(document).ready(function() {
        $('.form-control').focus(function() {
            $(this).parent().addClass('focused');
        }).blur(function() {
            if ($(this).val() === '') {
                $(this).parent().removeClass('focused');
            }
        });

        // Button group toggle styling
        $('.btn-group-toggle .btn').click(function() {
            $('.btn-group-toggle .btn').removeClass('active');
            $(this).addClass('active');
        });
    });
    </script>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function() {
        document.getElementById("loginLoader").style.display = "block";


        const btn = this.querySelector("button[type='submit']");
        btn.disabled = true;
        btn.innerText = "Processing...";
    });
    </script>

</body>

</html>