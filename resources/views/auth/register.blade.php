@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
    <div class="container-fluid register">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-transparent">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h1 class="text-light mb-3">Sign up</h4>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                        placeholder="First Name" name="firstName" value="{{ old('firstName') }}" autofocus>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control @error('middleName') is-invalid @enderror"
                                        placeholder="Middle Name" name="middleName" value="{{ old('middleName') }}"
                                        autofocus>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                        placeholder="Name" name="lastName" value="{{ old('lastName') }}" autofocus>
                                </div>
                                <div class="form-group mb-4">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        name="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
                                        placeholder="Phone Number" name="phoneNumber" value="{{ old('phoneNumber') }}"
                                        autofocus>
                                </div>
                                <div class="form-group mb-4">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                        name="password">
                                </div>
                                <div class="form-group mb-4">
                                    <input id="password-confirm" type="password" class="form-control"
                                        placeholder="Confirm password" name="password_confirmation">
                                </div>
                                <div class="form-group mb-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                                <div class="form-group">
                                    <p class="text-light">Already have an account? <a href="{{ route('login') }}">Sign
                                            in</a></p>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
