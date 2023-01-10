<!DOCTYPE html>
<html>
<head>
  @include('layouts.header')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <p>{{\Config::get('app.name')}}</p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Update Password</p>
      <form method="POST" action="{{ route('password.request') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
            @if($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </span>
            @endif
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" placeholder="Password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first() }}</strong>
                </span>
          @endif
        </div>
        <div class="input-group mb-3">
          <input id="password-confirm" type="password" class="form-control @if($errors->has('password_confirm')) is-invalid @endif" name="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
@include('layouts.footer')
</body>
</html>