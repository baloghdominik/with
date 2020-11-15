@extends('layouts/contentLayoutMaster')

@section('title', 'Helpdesk')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">
@endsection

@section('content')
<section id="basic-horizontal-layouts">
<div class="row">
    <div class="col-md-9 col-sm-12">
        <div class="row match-height">

            <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
                <div class="card">
                    <div class="card-header mx-auto">
                        <div class="avatar avatar-xl">
                            <img class="img-fluid" src="{{ asset('images/support/support.jpg') }}" alt="support">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body text-center">
                            <h4>Elsholtz Ábel</h4>
                            <p class="">Ügyintézés</p>
                            <div class="card-btns d-flex justify-content-between mt-3">
                                <a href="tel:06303909135" class="btn btn-primary waves-effect waves-light"><i class="fa fa-phone"></i> Hívás</a>
                                <a href="mailto:admin@with.hu" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-envelope"></i> Üzenet</a>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <div class="float-left">
                                    06-30-000-0000
                                </div>
                                <div class="float-right">
                                    admin@with.hu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
                <div class="card">
                    <div class="card-header mx-auto">
                        <div class="avatar avatar-xl">
                            <img class="img-fluid" src="{{ asset('images/support/support.jpg') }}" alt="support">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body text-center">
                            <h4>Balogh Dominik</h4>
                            <p class="">Hibaelhárítás</p>
                            <div class="card-btns d-flex justify-content-between mt-3">
                                <a href="tel:06303909135" class="btn btn-primary waves-effect waves-light"><i class="fa fa-phone"></i> Hívás</a>
                                <a href="mailto:admin@with.hu" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-envelope"></i> Üzenet</a>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <div class="float-left">
                                    06-30-390-9135
                                </div>
                                <div class="float-right">
                                    admin@with.hu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
                <div class="card">
                    <div class="card-header mx-auto">
                        <h4>Titkos ellenőrző kód</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body text-center">
                            <p class="">Kérjük az alábbi kódot a With.hu munkatársain kívül senkivel ne ossza meg!</p>
                            <div class="form-group row">
                                <div class="col-md-4" style="text-align: left;">
                                    <span>Titkos azonosító</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" id="secretid" class="form-control" value="{{$secret}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4" style="text-align: left;">
                                    <span>Titkos jelszó</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" id="pass" class="form-control" value="{{$pass}}">
                                </div>
                            </div>
                            <p style="text-align: left;">Ön is megbizonyosodhat arról, hogy ténylegesen egy kollégánkkal beszél, kérdezze munkatársunktól az alábbi kódot: <b><span id="verify">********</span></b></p>
                            <div class="form-group">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" onclick="showit()">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">Titkos kódok megjelenítése</span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3 col-sm-12">
        <div class="row">

            @if($s1 == 1)
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-check-circle"></i>
                                <h4 class="card-title text-white">Szerver</h4>
                                <p class="card-text text-white">Elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-danger text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-times-circle"></i>
                                <h4 class="card-title text-white">Szerver</h4>
                                <p class="card-text text-white">Nem elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($s2 == 1)
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-check-circle"></i>
                                <h4 class="card-title text-white">Adatbázis</h4>
                                <p class="card-text text-white">Elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-danger text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-times-circle"></i>
                                <h4 class="card-title text-white">Adatbázis</h4>
                                <p class="card-text text-white">Nem elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($s3 == 1)
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-check-circle"></i>
                                <h4 class="card-title text-white">AdminPanel</h4>
                                <p class="card-text text-white">Elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-danger text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-times-circle"></i>
                                <h4 class="card-title text-white">AdminPanel</h4>
                                <p class="card-text text-white">Nem elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($s4 == 1)
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-check-circle"></i>
                                <h4 class="card-title text-white">With.hu</h4>
                                <p class="card-text text-white">Elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-danger text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-times-circle"></i>
                                <h4 class="card-title text-white">With.hu</h4>
                                <p class="card-text text-white">Nem elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($s4 == 1)
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-primary text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-check-circle"></i>
                                <h4 class="card-title text-white">Online Fizetés</h4>
                                <p class="card-text text-white">Elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="card text-white bg-danger text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <i class="mb-1 fa fa-4x fa-times-circle"></i>
                                <h4 class="card-title text-white">Online Fizetés</h4>
                                <p class="card-text text-white">Nem elérhető</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
</section>
@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
        <script>
            function showit() {
                var x = document.getElementById("secretid");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }

                var y = document.getElementById("pass");
                if (y.type === "password") {
                    y.type = "text";
                } else {
                    y.type = "password";
                }

                var z = document.getElementById("verify");
                if (z.innerHTML === "********") {
                    z.innerHTML = "{{$verify}}";
                } else {
                    z.innerHTML = "********";
                }
            }
        </script>
@endsection