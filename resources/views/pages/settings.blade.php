@extends('layouts/contentLayoutMaster')

@section('title', 'Settings')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/select2.min.css')) }}">

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v6.0"></script>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
<div class="row match-height">

    <div class="col-md-12 col-12">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
    @endif

    @if ($message = Session::get('fail'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Hoppá!</strong> Problémába ütköztünk!
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>

    <div class="col-md-8 col-12">
        <div class="card" style="">
            <div class="card-header">
                <h4 class="card-title">Beállítások</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                <form class="form form-horizontal" method="post" action="{{ url('update-settings') }}"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                @csrf
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center">
                                            <h4>Általános</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Név</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Étterem neve" value="{{$restaurant->name}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Cím</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="address" placeholder="Étterem címe" value="{{$restaurant->address}}">
                                            @if($restaurant->address != NULL && strlen($restaurant->address) > 5)
                                            <iframe width="100%" height="120" src="https://maps.google.com/maps?q={{$iframe}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="margin-top: 20px;"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Telefonszám</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="phone" class="form-control" name="phone" placeholder="Étterem telefonszáma" value="{{$restaurant->phone}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Emailcím</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email" placeholder="Étterem emailcíme" value="{{$restaurant->email}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Facebook oldal URL</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-1" name="facebook" placeholder="Facebook oldal url" value="{{$restaurant->facebook}}">
                                            @if($restaurant->facebook != NULL && strlen($restaurant->facebook) > 12)
                                                <div class="fb-page" 
                                                data-href="{{$restaurant->facebook}}"
                                                data-width="380" 
                                                data-hide-cover="false"
                                                data-show-facepile="false"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Leírás</span>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea data-length="500" class="form-control char-textarea active" id="textarea-counter" name="description" rows="5" placeholder="Étterem leírása">{{$restaurant->description}}</textarea>
                                            <small class="counter-value float-right"><span class="char-count">0</span> / 500 </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Termék specifikációk megjelenítése</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->showspecifications)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showspecifications" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showspecifications" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Kalóriatartalom megjelenítése</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->showcalories)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showcalories" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showcalories" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Leírás megjelenítése</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->showdescription)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showdescription" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="showdescription" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Megjelenít</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Pizza tervező bekapcsolása</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->pizzadesigner)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="pizzadesigner" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Bekapcsolás</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="pizzadesigner" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Bekapcsolás</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center mt-3">
                                            <h4>Nyitvatartás</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Hétfő</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->monday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="monday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="monday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="mondayopen" step="300" value="{{$restaurant->mondayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="mondayclose" step="300" value="{{$restaurant->mondayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Kedd</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->tuesday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="tuesday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="tuesday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="tuesdayopen" step="300" value="{{$restaurant->tuesdayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="tuesdayclose" step="300" value="{{$restaurant->tuesdayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Szerda</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->wednesday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="wednesday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="wednesday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="wednesdayopen" step="300" value="{{$restaurant->wednesdayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="wednesdayclose" step="300" value="{{$restaurant->wednesdayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Csütörtök</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->thursday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="thursday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="thursday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="thursdayopen" step="300" value="{{$restaurant->thursdayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="thursdayclose" step="300" value="{{$restaurant->thursdayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Péntek</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->friday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="friday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="friday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="fridayopen" step="300" value="{{$restaurant->fridayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="fridayclose" step="300" value="{{$restaurant->fridayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Szombat</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->saturday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="saturday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="saturday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="saturdayopen" step="300" value="{{$restaurant->saturdayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="saturdayclose" step="300" value="{{$restaurant->saturdayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Vasárnap</span>
                                        </div>
                                        <div class="col-md-2">
                                            @if($restaurant->sunday)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="sunday" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="sunday" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Nyitva</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="sundayopen" step="300" value="{{$restaurant->sundayopen}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" class="form-control" name="sundayclose" step="300" value="{{$restaurant->sundayclose}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Rendelés ekkortól</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="firstorder" id="basicSelect">
                                                @if($restaurant->firstorder < 0)
                                                    <option value="{{$restaurant->firstorder}}" selected>Nyitás előtt {{ abs($restaurant->firstorder) }} perccel</option>
                                                @elseif($restaurant->firstorder > 0)
                                                    <option value="{{$restaurant->firstorder}}" selected>Nyitás után {{ abs($restaurant->firstorder) }} perccel</option>
                                                @else
                                                    <option value="{{$restaurant->firstorder}}" selected>Nyitás</option>
                                                @endif
                                                    <option value="-30">Nyitás előtt 30 perccel</option>
                                                    <option value="-25">Nyitás előtt 25 perccel</option>
                                                    <option value="-20">Nyitás előtt 20 perccel</option>
                                                    <option value="-15">Nyitás előtt 15 perccel</option>
                                                    <option value="-10">Nyitás előtt 10 perccel</option>
                                                    <option value="-5">Nyitás előtt 5 perccel</option>
                                                    <option value="0">Nyitás</option>
                                                    <option value="5">Nyitás után 5 perccel</option>
                                                    <option value="10">Nyitás után 10 perccel</option>
                                                    <option value="15">Nyitás után 15 perccel</option>
                                                    <option value="20">Nyitás után 20 perccel</option>
                                                    <option value="25">Nyitás után 25 perccel</option>
                                                    <option value="30">Nyitás után 30 perccel</option>
                                                    <option value="35">Nyitás után 35 perccel</option>
                                                    <option value="40">Nyitás után 40 perccel</option>
                                                    <option value="45">Nyitás után 45 perccel</option>
                                                    <option value="50">Nyitás után 50 perccel</option>
                                                    <option value="55">Nyitás után 55 perccel</option>
                                                    <option value="60">Nyitás után 60 perccel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Rendelés eddig</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="lastorder" id="basicSelect">
                                                @if($restaurant->lastorder < 0)
                                                    <option value="{{$restaurant->lastorder}}" selected>Zárás előtt {{ abs($restaurant->lastorder) }} perccel</option>
                                                @elseif($restaurant->lastorder > 0)
                                                    <option value="{{$restaurant->lastorder}}" selected>Zárás után {{ abs($restaurant->lastorder) }} perccel</option>
                                                @else
                                                    <option value="{{$restaurant->lastorder}}" selected>Zárás</option>
                                                @endif
                                                    <option value="-60">Zárás előtt 60 perccel</option>
                                                    <option value="-55">Zárás előtt 55 perccel</option>
                                                    <option value="-50">Zárás előtt 50 perccel</option>
                                                    <option value="-45">Zárás előtt 45 perccel</option>
                                                    <option value="-40">Zárás előtt 40 perccel</option>
                                                    <option value="-35">Zárás előtt 35 perccel</option>
                                                    <option value="-30">Zárás előtt 30 perccel</option>
                                                    <option value="-25">Zárás előtt 25 perccel</option>
                                                    <option value="-20">Zárás előtt 20 perccel</option>
                                                    <option value="-15">Zárás előtt 15 perccel</option>
                                                    <option value="-10">Zárás előtt 10 perccel</option>
                                                    <option value="-5">Zárás előtt 5 perccel</option>
                                                    <option value="0">Zárás</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center mt-3">
                                            <h4>Helyszíni átvétel</h4>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        Helyszíni átvétel
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->pickup)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="pickup" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="pickup" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Helyszíni átvétel idő számítás</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="pickuptimecalculation" id="basicSelect">
                                                @if($restaurant->pickuptimecalculation == 1)
                                                    <option value="1" selected>Elkészítési idő</option>
                                                @elseif($restaurant->pickuptimecalculation == 2)
                                                    <option value="2" selected>Kiszállítási idő</option>
                                                @elseif($restaurant->pickuptimecalculation == 3)
                                                    <option value="3" selected>Elkészítési idő + Kiszállítási idő</option>
                                                @elseif($restaurant->pickuptimecalculation == 4)
                                                    <option value="4" selected>Elkészítési idő + 5 perc</option>
                                                @elseif($restaurant->pickuptimecalculation == 5)
                                                    <option value="5" selected>Elkészítési idő + 10 perc</option>
                                                @elseif($restaurant->pickuptimecalculation == 6)
                                                    <option value="6" selected>Elkészítési idő + 15 perc</option>
                                                @elseif($restaurant->pickuptimecalculation == 7)
                                                    <option value="7" selected>Elkészítési idő + 20 perc</option>
                                                @endif
                                                    <option value="1">Elkészítési idő</option>
                                                    <option value="2">Kiszállítási idő</option>
                                                    <option value="3">Elkészítési idő + Kiszállítási idő</option>
                                                    <option value="4">Elkészítési idő + 5 perc</option>
                                                    <option value="5">Elkészítési idő + 10 perc</option>
                                                    <option value="6">Elkészítési idő + 15 perc</option>
                                                    <option value="7">Elkészítési idő + 20 perc</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Fizetési mód, helyszíni átvétel esetén</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="pickuppayingmethod" id="basicSelect">
                                                @if($restaurant->pickuppayingmethod == 1)
                                                    <option value="1" selected>Készpénz</option>
                                                @elseif($restaurant->pickuppayingmethod == 2)
                                                    <option value="2" selected>Bankkártya</option>
                                                @elseif($restaurant->pickuppayingmethod == 3)
                                                    <option value="3" selected>Online</option>
                                                @elseif($restaurant->pickuppayingmethod == 4)
                                                    <option value="4" selected>Készpénz, Bankkártya</option>
                                                @elseif($restaurant->pickuppayingmethod == 5)
                                                    <option value="5" selected>Készpénz, Online</option>
                                                @elseif($restaurant->pickuppayingmethod == 6)
                                                    <option value="6" selected>Online, Bankkártya</option>
                                                @elseif($restaurant->pickuppayingmethod == 7)
                                                    <option value="7" selected>Készpénz, Bankkártya, Online</option>
                                                @endif
                                                    <option value="1">Készpénz</option>
                                                    <option value="2">Bankkártya</option>
                                                    <option value="3">Online</option>
                                                    <option value="4">Készpénz, Bankkártya</option>
                                                    <option value="5">Készpénz, Online</option>
                                                    <option value="6">Online, Bankkártya</option>
                                                    <option value="7">Készpénz, Bankkártya, Online</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center mt-3">
                                            <h4>Asztalfoglalás</h4>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        Asztal foglalás
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->isreservation)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="isreservation" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="isreservation" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Maximum fő/foglalás</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="maxreservationperson" id="basicSelect">
                                                @if($restaurant->maxreservationperson > 0)
                                                    <option value="{{$restaurant->maxreservationperson}}" selected>{{ $restaurant->maxreservationperson }} fő</option>
                                                @endif
                                                    <option value="10">10 fő</option>
                                                    <option value="20">20 fő</option>
                                                    <option value="30">30 fő</option>
                                                    <option value="40">40 fő</option>
                                                    <option value="50">50 fő</option>
                                                    <option value="60">60 fő</option>
                                                    <option value="70">70 fő</option>
                                                    <option value="80">80 fő</option>
                                                    <option value="90">90 fő</option>
                                                    <option value="100">100 fő</option>
                                                    <option value="150">150 fő</option>
                                                    <option value="200">200 fő</option>
                                                    <option value="250">250 fő</option>
                                                    <option value="300">300 fő</option>
                                                    <option value="400">400 fő</option>
                                                    <option value="500">500 fő</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Foglalás időpontja</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="reservationtime" id="basicSelect">
                                                @if($restaurant->reservationtime > 0)
                                                    <option value="{{$restaurant->reservationtime}}" selected>Minimum {{ $restaurant->reservationtime }} órával elötte</option>
                                                @endif
                                                    <option value="1">Minimum 1 órával elötte</option>
                                                    <option value="2">Minimum 2 órával elötte</option>
                                                    <option value="3">Minimum 3 órával elötte</option>
                                                    <option value="4">Minimum 4 órával elötte</option>
                                                    <option value="5">Minimum 5 órával elötte</option>
                                                    <option value="6">Minimum 6 órával elötte</option>
                                                    <option value="7">Minimum 7 órával elötte</option>
                                                    <option value="8">Minimum 8 órával elötte</option>
                                                    <option value="9">Minimum 9 órával elötte</option>
                                                    <option value="10">Minimum 10 órával elötte</option>
                                                    <option value="11">Minimum 11 órával elötte</option>
                                                    <option value="12">Minimum 12 órával elötte</option>
                                                    <option value="24">Minimum 24 órával elötte</option>
                                                    <option value="48">Minimum 48 órával elötte</option>
                                                    <option value="72">Minimum 72 órával elötte</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8">
                                            <p>A felhasználóknak lehetőséget ad asztalt foglalni, maximum a feljebb megadott főig. Időpontot az étterem nyitvatartása szerint nyitástól a zárás előtti óráig lehet foglalni minimum a feljebb beállított idővel előtte. Az asztalfoglalásokat a "Foglalások" menüpontban lehet felülbírálni.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center mt-3">
                                            <h4>Házhozszállítás</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        Házhozszállítás
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->delivery)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="delivery" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="delivery" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elérhető</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-4">
                                        Házhozszállítási terület
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group">
                                                <select name="zipcodes[]" class="select2 form-control select2-hidden-accessible" multiple="multiple" aria-hidden="true">
                                                    @foreach ($zipcodes as $zip)
                                                        @php 
                                                        $selected = false;
                                                        @endphp
                                                        @foreach ($restaurantzipcodes as $rzc)
                                                            @if ($zip->zipcode == $rzc->zipcode)
                                                                @php
                                                                $selected = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        
                                                        @if ($selected)
                                                        <option value="{{ $zip->zipcode }}" data-select2-id="{{ $zip->zipcode }}" selected="selected">{{ $zip->city }} - {{ $zip->zipcode }}</option>
                                                        @else
                                                        <option value="{{ $zip->zipcode }}" data-select2-id="{{ $zip->zipcode }}">{{ $zip->city }} - {{ $zip->zipcode }}</option>
                                                        @endif
                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Minimum kosárérték</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="minimumordervalue" id="basicSelect">
                                                @if($restaurant->minimumordervalue > 0)
                                                    <option value="{{$restaurant->minimumordervalue}}" selected>{{ number_format($restaurant->minimumordervalue, 0, '.', ' ') }} Ft</option>
                                                @else
                                                    <option value="{{$restaurant->minimumordervalue}}" selected>Nincs minimum kosárérték</option>
                                                @endif
                                                    <option value="0">Nincs minimum kosárérték</option>
                                                    <option value="500">500 Ft</option>
                                                    <option value="1000">1 000 Ft</option>
                                                    <option value="1500">1 500 Ft</option>
                                                    <option value="2000">2 000 Ft</option>
                                                    <option value="2500">2 500 Ft</option>
                                                    <option value="3000">3 000 Ft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Házhozszállítás ára</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="deliveryprice" id="basicSelect">
                                                @if($restaurant->deliveryprice > 0)
                                                    <option value="{{$restaurant->deliveryprice}}" selected>+{{ $restaurant->deliveryprice }} Ft</option>
                                                @else
                                                    <option value="{{$restaurant->deliveryprice}}" selected>A házhozszállítás ingyenes</option>
                                                @endif
                                                    <option value="0">A házhozszállítás ingyenes</option>
                                                    <option value="50">+50 Ft</option>
                                                    <option value="100">+100 Ft</option>
                                                    <option value="150">+150 Ft</option>
                                                    <option value="200">+200 Ft</option>
                                                    <option value="250">+250 Ft</option>
                                                    <option value="300">+300 Ft</option>
                                                    <option value="350">+350 Ft</option>
                                                    <option value="400">+400 Ft</option>
                                                    <option value="450">+450 Ft</option>
                                                    <option value="500">+500 Ft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Kiszállítási idő</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="deliverytime" id="basicSelect">
                                                @if($restaurant->deliverytime > 0)
                                                    <option value="{{$restaurant->deliverytime}}" selected>{{ $restaurant->deliverytime }} perc</option>
                                                @endif
                                                    <option value="10">10 perc</option>
                                                    <option value="15">15 perc</option>
                                                    <option value="20">20 perc</option>
                                                    <option value="25">25 perc</option>
                                                    <option value="30">30 perc (Fél óra)</option>
                                                    <option value="35">35 perc</option>
                                                    <option value="40">40 perc</option>
                                                    <option value="45">45 perc</option>
                                                    <option value="50">50 perc</option>
                                                    <option value="55">55 perc</option>
                                                    <option value="60">60 perc (1 óra)</option>
                                                    <option value="65">65 perc</option>
                                                    <option value="70">70 perc</option>
                                                    <option value="75">75 perc</option>
                                                    <option value="80">80 perc</option>
                                                    <option value="85">85 perc</option>
                                                    <option value="90">90 perc (Másfél óra)</option>
                                                    <option value="95">95 perc</option>
                                                    <option value="100">100 perc</option>
                                                    <option value="105">105 perc</option>
                                                    <option value="110">110 perc</option>
                                                    <option value="115">115 perc</option>
                                                    <option value="120">120 perc (2 óra)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Kiszállítási idő számítása</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="deliverytimecalculation" id="basicSelect">
                                                @if($restaurant->deliverytimecalculation == 2)
                                                    <option value="2" selected>Elkészítési idő + Kiszállítási idő</option>
                                                @elseif($restaurant->deliverytimecalculation == 1)
                                                    <option value="1" selected>Kiszállítási idő</option>
                                                @endif
                                                    <option value="1">Kiszállítási idő</option>
                                                    <option value="2">Elkészítési idő + Kiszállítási idő</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Fizetési mód, házhozszállítás esetén</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="deliverypayingmethod" id="basicSelect">
                                                @if($restaurant->deliverypayingmethod == 1)
                                                    <option value="1" selected>Készpénz</option>
                                                @elseif($restaurant->deliverypayingmethod == 2)
                                                    <option value="2" selected>Bankkártya</option>
                                                @elseif($restaurant->deliverypayingmethod == 3)
                                                    <option value="3" selected>Online</option>
                                                @elseif($restaurant->deliverypayingmethod == 4)
                                                    <option value="4" selected>Készpénz, Bankkártya</option>
                                                @elseif($restaurant->deliverypayingmethod == 5)
                                                    <option value="5" selected>Készpénz, Online</option>
                                                @elseif($restaurant->deliverypayingmethod == 6)
                                                    <option value="6" selected>Online, Bankkártya</option>
                                                @elseif($restaurant->deliverypayingmethod == 7)
                                                    <option value="7" selected>Készpénz, Bankkártya, Online</option>
                                                @endif
                                                    <option value="1">Készpénz</option>
                                                    <option value="2">Bankkártya</option>
                                                    <option value="3">Online</option>
                                                    <option value="4">Készpénz, Bankkártya</option>
                                                    <option value="5">Készpénz, Online</option>
                                                    <option value="6">Online, Bankkártya</option>
                                                    <option value="7">Készpénz, Bankkártya, Online</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center mt-3">
                                            <h4>Fizetés</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>SZÉP kártya</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->szepcard)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="szepcard" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elfogadás</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="szepcard" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elfogadás</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Erzsébet utalvány</span>
                                        </div>
                                        <div class="col-md-6">
                                            @if($restaurant->erzsebetcard)
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="erzsebetcard" value="1" checked>
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elfogadás</span>
                                                </div>
                                            @else
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="erzsebetcard" value="0">
                                                    <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                    </span>
                                                    <span class="">Elfogadás</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Kedvezmény menü esetén</span>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="menusalepercent" id="basicSelect">
                                                    <option value="0" selected>Beállítás minden menühöz külön.</option>
                                                @if($restaurant->menusalepercent > 0)
                                                    <!--<option value="{{$restaurant->menusalepercent}}" selected>{{ $restaurant->menusalepercent }}%</option>-->
                                                @else
                                                    <!--<option value="{{$restaurant->menusalepercent}}" selected>Nincs</option>-->
                                                @endif
                                                    <option value="0">Nincs</option>
                                                    <option value="3">3%</option>
                                                    <option value="5">5%</option>
                                                    <option value="7">7%</option>
                                                    <option value="10">10%</option>
                                                    <option value="13">13%</option>
                                                    <option value="15">15%</option>
                                                    <option value="17">17%</option>
                                                    <option value="20">20%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Maximum vásárlási engedmény reklám célra</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="name" class="form-control" name="name" placeholder="0%" value="10%" disabled>
                                        </div>
                                    </div>
                                </div>

                                

                                
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Mentés</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-12">
        <div class="card" style="">
            <div class="card-header">
                <h4 class="card-title">Képek</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                <form class="form form-horizontal" method="post" action="{{ url('upload-images') }}"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                @csrf 
                                <div class="col-12 mb-3">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Logó</span>
                                        </div>
                                        <div class="col-md-8">
                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1" src="{{ asset('images/logos/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_logo.jpg') }}" alt="">
                                            <div class="custom-file">
                                                    <input type="file" name="logo" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label" for="inputGroupFile01">Válasszon fotót</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Fejléc</span>
                                        </div>
                                        <div class="col-md-8">
                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1" src="{{ asset('images/banners/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_banner.jpg') }}" alt="">
                                            <div class="custom-file">
                                                    <input type="file" name="banner" class="custom-file-input" id="inputGroupFile02">
                                                    <label class="custom-file-label" for="inputGroupFile02">Válasszon fotót</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Galéria</span>
                                        </div>
                                        <div class="col-md-8">
                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic1.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic1" class="custom-file-input" id="inputGroupFile03">
                                                    <label class="custom-file-label" for="inputGroupFile03">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic2.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic2" class="custom-file-input" id="inputGroupFile04">
                                                    <label class="custom-file-label" for="inputGroupFile04">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic3.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic3" class="custom-file-input" id="inputGroupFile05">
                                                    <label class="custom-file-label" for="inputGroupFile05">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic4.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic4" class="custom-file-input" id="inputGroupFile06">
                                                    <label class="custom-file-label" for="inputGroupFile06">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic5.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic5" class="custom-file-input" id="inputGroupFile07">
                                                    <label class="custom-file-label" for="inputGroupFile07">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic6.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic6" class="custom-file-input" id="inputGroupFile08">
                                                    <label class="custom-file-label" for="inputGroupFile08">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic7.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic7" class="custom-file-input" id="inputGroupFile09">
                                                    <label class="custom-file-label" for="inputGroupFile09">Válasszon fotót</label>
                                            </div>

                                            <img style="max-height: 190px; width: auto;" class="card-img img-fluid mb-1 mt-2" src="{{ asset('images/galleries/with.hu_'.$restaurant->id.'_'.$restaurant->name.'_pic8.jpg') }}" alt="">
                                            <div class="custom-file mb-2">
                                                    <input type="file" name="pic8" class="custom-file-input" id="inputGroupFile010">
                                                    <label class="custom-file-label" for="inputGroupFile010">Válasszon fotót</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Mentés</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
        <script src="{{ asset(mix('js/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('js/form-select2.js')) }}"></script>
@endsection