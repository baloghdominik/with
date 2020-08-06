@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('page-style')
        <link rel="stylesheet" href="{{ asset(mix('css/bootstrap.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/bootstrap-extended.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/colors.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/components.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/themes/dark-layout.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/themes/semi-dark-layout.css')) }}">
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/core/menu/menu-types/vertical-menu.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/core/colors/palette-gradient.css')) }}">
        <link rel="stylesheet" href="css/pages/authentication.css">
@endsection

@section('content')
<section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="images/pages/login.png" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h1 class="brand-text mb-0 with-logo" style="color: #47b272; font-weight: 600; letter-spacing: 0.10rem;">With</h1>
                                            </div>
                                        </div>
                                        <p class="px-2">Üdvözöljük újra, kérjük jelentkezzen be!</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                @error('email')
                                                <div class="alert alert-danger">
                                                    <strong>Hoppá!</strong> Problémába ütköztünk!
                                                    <ul>
                                                            <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                <br/>
                                                @enderror
                                                @error('password')
                                                <div class="alert alert-danger">
                                                    <strong>Hoppá!</strong> Problémába ütköztünk!
                                                    <ul>
                                                            <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                <br/>
                                                @enderror
                                                <form method="POST" action="{{ route('login') }}">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control @error('email') @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" placeholder="Email">
                                                        <label for="email">Email</label>
                                                    </fieldset>

                                                    @csrf

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input id="password" type="password" class="form-control @error('password') @enderror" name="password" required autocomplete="current-password" placeholder="Jelszó">
                                                        <label for="password">Jelszó</label>
                                                    </fieldset>
                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">Emlékezzen rám!</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="text-right"><a href="{{ route('password.request') }}" class="card-link">Elfelejtett jelszó?</a></div>
                                                    </div>
                                                    <a href="#" class=".d-sm-none .d-md-block btn btn-outline-primary float-left btn-inline">Mi az a <span class="brand-text mb-0 with-logo" style="color: #47b272; font-weight: 600;
    letter-spacing: 0.10rem;">With</span>?</a>
                                                    <button type="submit" class="btn btn-primary float-right btn-inline">Bejelentkezés</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endsection


@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
        <script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
        <script src="{{ asset(mix('js/core/app.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/components.js')) }}"></script>
@endsection