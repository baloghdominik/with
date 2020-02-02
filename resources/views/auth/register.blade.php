@extends('layouts/fullLayoutMaster')

@section('title', 'Fiók hozzáadása')

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
                                                @error('name')
                                                <div class="alert alert-danger">
                                                    <strong>Hoppá!</strong> Problémába ütköztünk!
                                                    <ul>
                                                            <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                <br/>
                                                @enderror
                                                @error('role')
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
                                                <form method="POST" action="{{ route('register') }}">
                                                    @csrf

                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control @error('name') @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" id="name" placeholder="Név">
                                                        <label for="email">Név</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control @error('name') @enderror" name="restaurantid" value="{{ old('restaurantid') }}" required id="res" placeholder="Étterem azonosító">
                                                        <label for="res">Étterem azonosító</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control @error('email') @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="email" placeholder="Email">
                                                        <label for="email">Email</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Chef</option>
                                                            <option value="3">Courier</option>
                                                        </select>
                                                        <label for="email">Jog</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input id="password" type="password" class="form-control @error('password') @enderror" name="password" required autocomplete="current-password" placeholder="Jelszó">
                                                        <label for="password">Jelszó</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Jelszó megerősítés">
                                                        <label for="password">Jelszó megerősítés</label>
                                                    </fieldset>

                                                    <button type="submit" class="btn btn-primary float-right btn-inline">Felhasználó hozzáadása</button>
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