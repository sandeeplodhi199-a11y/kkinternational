<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Firstnutrition</title>

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
    @media (max-width: 991.98px) {
      .vh-100 {
        margin-top: 0;
        padding-top: 20px;
        padding-bottom: 20px;
      }
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="container-fluid">
    <div class="row vh-100 align-items-center justify-content-center">

      <!-- Image Column (hidden on small devices) -->
      <div class="col-lg-6 col-md-6 d-none d-md-flex justify-content-center align-items-center">
        <img src="{{ url('public/firstnutrition_login.png') }}" class="img-fluid" alt="Login Image">
      </div>

      <!-- Login Form Column -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="login-box mx-auto">
          <div class="login-logo">
            <a><b>First Nutrition</b></a>
          </div>

          <div class="card">
            <div class="card-body login-card-body">

              <!-- Logo -->
              <div class="text-center mb-3">
                <img src="{{ url('public/firstnutrition.webp') }}" class="img-fluid mx-auto d-block" style="max-width: 150px;" alt="Logo" onerror="this.alt='Logo not found';">
              </div>

              <p class="login-box-msg">Forget Password</p>

              @if(session()->has('error'))
              <div class="alert alert-danger">
                {{ session()->get('error') }}
              </div>
              @endif

              <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                  @endif
                </div>

                <div class="form-group mt-3 text-right">
                  <button type="submit" class="btn btn-primary btn-block">Email Password Reset Link</button>
                </div>
              </form>

              <!-- Forgot Password & Register Links -->
              <p class="mt-3 d-flex justify-content-between">
                <a href="{{ url('login') }}">Login</a>
                <a href="{{ url('register') }}" class="text-center">Registration</a>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
