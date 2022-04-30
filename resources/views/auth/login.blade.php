@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-3">
      <div class="text-center p-3">
        <h4>
          {{ __('Admin Login') }}
        </h4>
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class=" p-3">
          @csrf
          <div class="col py-2">
            <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="col py-2">
            <label for="password" class="col-md-4 col-form-label ">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="col py-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>
          </div>

          <div class="col d-grid gap-2 py-2">
            <button type="submit" class="btn btn-primary block">
              {{ __('Login') }}
            </button>
          </div>

          <div class="row justify-content-space-between">
              <a class="btn btn-link" href="{{ route('register') }}">
                {{ __('Register') }}
              </a>
              
              @if (Route::has('password.request'))
              <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
              </a>
              @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection