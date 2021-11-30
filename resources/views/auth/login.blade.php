@extends('layouts.app')

@section('content')
    <div class="container mt-8">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-sm-12 border shadow rounded">
                <div class="card">
                    <div class="card-header display-5 bg-white">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check d-flex" style="width: 200px">
                                        <a href="{{url('/auth/google/redirect')}}" >
                                            <svg class="social" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                 viewBox="0 0 24 24"
                                                 style="fill: rgba(255, 195, 111, 1);transform: ;msFilter:;">
                                                <path
                                                    d="M22.014 11.974C21.996 6.462 17.521 2 12.008 2 6.493 2 2.019 6.462 2.001 11.974L2 11.948v.112l.001-.023c.017 5.513 4.491 9.977 10.007 9.977 5.514 0 9.988-4.462 10.006-9.974l.001.026v-.118l-.001.026zM9.281 16.557c-2.509 0-4.548-2.039-4.548-4.549s2.039-4.549 4.548-4.549c1.23 0 2.258.451 3.046 1.188l-1.295 1.255c-.325-.309-.899-.673-1.751-.673-1.505 0-2.733 1.251-2.733 2.785 0 1.533 1.229 2.784 2.733 2.784 1.742 0 2.384-1.206 2.502-1.92H9.279V11.18h4.255c.066.286.115.554.115.932 0 2.597-1.742 4.445-4.368 4.445zm10.458-4.095H17.92v1.819h-1.364v-1.819h-1.82v-1.364h1.82v-1.82h1.364v1.82h1.819v1.364z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{url('/auth/github/redirect')}}" class="social">
                                            <svg class="social" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                 viewBox="0 0 24 24"
                                                 style="fill: rgba(255, 195, 111, 1);transform: ;msFilter:;">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                    <button type="submit"  class="btn btn-primary border shadow rounded">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .social:hover {
            box-shadow: 10px 5px 5px #242424;
        }
    </style>
@endsection
