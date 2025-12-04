@extends('layouts.public')

@section('content')

<div class="preloader">
    <img src="{{ asset('assets/images/logos/favicon.png')}}" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="row">
          <div class="col-xl-7 col-xxl-8">
            <a href="#" class="text-nowrap logo-img d-block px-4 py-9 w-100">
              {{-- <img src="{{ asset('assets/images/logos/dark-logo.svg')}}" class="dark-logo" alt="Logo-Dark"> --}}
              <img src="{{ asset('assets/images/logos/light-logo.svg')}}" class="light-logo" alt="Logo-light">
            </a>
            <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
              <img src="{{ asset('assets/images/backgrounds/login-security.svg')}}" alt="" class="img-fluid" width="500">
            </div>
          </div>
          <div class="col-xl-5 col-xxl-4">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
              <div class="col-sm-8 col-md-6 col-xl-9">
                <h2 class="mb-3 fs-7 fw-bolder text-center "> IMS</h2>
                {{-- <p class=" mb-9">Your Admin Dashboard</p> --}}
                <div class="row">
                  <div class="col-6 mb-2 mb-sm-0">
                    {{-- <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                      <img src="{{ asset('assets/images/svgs/google-icon.svg')}}" alt="" class="img-fluid me-2" width="18" height="18">
                      <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>Google
                    </a> --}}
                  </div>
                  <div class="col-6">
                    {{-- <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                      <img src="{{ asset('assets/images/svgs/facebook-icon.svg')}}" alt="" class="img-fluid me-2" width="18" height="18">
                      <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>FB
                    </a> --}}
                  </div>
                </div>
                {{-- <div class="position-relative text-center my-4">
                  <p class="mb-0 fs-4 px-3 d-inline-block text-bg-white text-dark z-index-5 position-relative">or sign
                    in
                    with</p>
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div> --}}
                <form  method="POST" action="{{ route('login') }}"  >
                  @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email"  aria-describedby="emailHelp">
                    <x-error for="email" />
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                    <x-error for="password" />
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked="">
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-medium" href="authentication-forgot-password.html">Forgot Password ?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    {{-- <p class="fs-4 mb-0 fw-medium">New to Modernize?</p> --}}
                    {{-- <a class="text-primary fw-medium ms-2" href="authentication-register.html">Create an account</a> --}}
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->






@endsection




{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}



