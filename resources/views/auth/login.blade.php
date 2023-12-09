@extends('layouts.app')

@section('content')
<div class="container-fluid login">
    <div class="card bg-transparent border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="text-light">Sign in</h4>
                <div class="form-group mt-5 mb-4">
                    <input id="email" type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <input id="password" type="password" class="form-control rounded-0 @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                <div class="form-group">
                    <p class="text-light">Not registered yet? <a href="{{route('register')}}">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
