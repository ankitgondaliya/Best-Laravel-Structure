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
    @if($status==1)
    <div class="card-body login-card-body">
        <h4 class="login-box-msg">Update Password</h4>
        @if($errors->has('message'))
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li >{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ url('savepassword/'.$id.'/'.$date) }}">
        @csrf
        <input type="hidden" name="id" value="{{$user_id}}">
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
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
    @else
    <div class="card-body login-card-body">
      <p class="login-box-msg">Update Password</p>
    </div>
    @endif
  </div>
</div>

<!-- jQuery -->
@include('layouts.footer')
</body>
</html>