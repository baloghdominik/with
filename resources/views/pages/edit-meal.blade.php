@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Meal')

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
@if(sizeof($categories) !== 0)
<div class="row">
        <div class="col-12">
        <a href="{{ url('list-meal') }}" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">Étel lista</a>
        </div>
    </div>
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
                                    <h4 class="card-title">Étel szerkesztése</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form form-horizontal" method="post" action="{{ url('update-meal/'.$meal->id) }}"  enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf 
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel fotója</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <img src="{{ asset('images/meals/'.$meal->picid.'.jpg') }}" width="100%" height="auto" style="margin-bottom: 25px; border-radius: 1rem;">
                                                                <div class="custom-file">
                                                                        <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                                                                        <label class="custom-file-label" for="inputGroupFile01">Válasszon fotót</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="hidden" id="picid" class="form-control" name="picid" value="{{$meal->picid}}">
                                                                <input type="text" id="food-name" class="form-control" name="name" value="{{$meal->name}}" placeholder="Étel megnevezése">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Kategória</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" name="category" id="basicSelect">
                                                                    @foreach($categories as $key => $data)
                                                                        @if($data->id == $meal->category)
                                                                            <option value="{{ $data->id }}" selected>{{ $data->category }}</option>
                                                                        @else
                                                                            <option value="{{ $data->id }}">{{ $data->category }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel fogyasztói ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="v0" onkeyup="calculate()" class="form-control" name="price" value="{{$meal->price}}" placeholder="Étel eladási ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel akciós ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="v2" onkeyup="calculate()" class="form-control" name="saleprice" value="{{$meal->saleprice}}" placeholder="Étel kedvezményes ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Akció bekapcsolása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            @if($meal->sale)
                                                            <div class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" name="sale" value="1" class="custom-control-input" id="customSwitch1" checked>
                                                                <label class="custom-control-label" for="customSwitch1">
                                                                </label>
                                                                <span class="switch-label">Akció állapota</span>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <div class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" name="sale" value="0" class="custom-control-input" id="customSwitch1">
                                                                <label class="custom-control-label" for="customSwitch1">
                                                                </label>
                                                                <span class="switch-label">Akció állapota</span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel elkészítési ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="v1" onkeyup="calculate()" class="form-control" name="makeprice" value="{{$meal->makeprice}}" placeholder="Étel elkszítési költsége">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel árrése</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="result" class="form-control" placeholder="" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel elkészítési ideje</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" name="maketime" id="basicSelect">
                                                                        <option value="{{$meal->maketime}}" selected>{{$meal->maketime}} perc</option>
                                                                        <option value="0">Nincs elkészítési idő</option>
                                                                        <option value="1">1 perc</option>
                                                                        <option value="2">2 perc</option>
                                                                        <option value="3">3 perc</option>
                                                                        <option value="4">4 perc</option>
                                                                        <option value="5">5 perc</option>
                                                                        <option value="6">6 perc</option>
                                                                        <option value="7">7 perc</option>
                                                                        <option value="8">8 perc</option>
                                                                        <option value="9">9 perc</option>
                                                                        <option value="10">10 perc</option>
                                                                        <option value="11">11 perc</option>
                                                                        <option value="12">12 perc</option>
                                                                        <option value="13">13 perc</option>
                                                                        <option value="14">14 perc</option>
                                                                        <option value="15">15 perc</option>
                                                                        <option value="16">16 perc</option>
                                                                        <option value="17">17 perc</option>
                                                                        <option value="18">18 perc</option>
                                                                        <option value="19">19 perc</option>
                                                                        <option value="20">20 perc</option>
                                                                        <option value="21">21 perc</option>
                                                                        <option value="22">22 perc</option>
                                                                        <option value="23">23 perc</option>
                                                                        <option value="24">24 perc</option>
                                                                        <option value="25">25 perc</option>
                                                                        <option value="26">26 perc</option>
                                                                        <option value="27">27 perc</option>
                                                                        <option value="28">28 perc</option>
                                                                        <option value="29">29 perc</option>
                                                                        <option value="30">30 perc</option>
                                                                        <option value="35">35 perc</option>
                                                                        <option value="40">40 perc</option>
                                                                        <option value="35">45 perc</option>
                                                                        <option value="50">50 perc</option>
                                                                        <option value="55">55 perc</option>
                                                                        <option value="60">60 perc (1 óra)</option>
                                                                        <option value="65">65 perc</option>
                                                                        <option value="70">70 perc</option>
                                                                        <option value="75">75 perc</option>
                                                                        <option value="80">80 perc</option>
                                                                        <option value="85">85 perc</option>
                                                                        <option value="90">90 perc</option>
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
                                                                <span>Maximum extrák</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" min="0" max="20" id="extralimit" class="form-control" name="extralimit" placeholder="Maximum opcionális extrák száma" value="{{ $meal->extralimit }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel elérhetősége</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->monday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="monday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 1)
                                                                            <span class=""><b>Hétfő</b></span>
                                                                        @else
                                                                            <span class="">Hétfő</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="monday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 1)
                                                                            <span class=""><b>Hétfő</b></span>
                                                                        @else
                                                                            <span class="">Hétfő</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->tuesday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="tuesday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 2)
                                                                            <span class=""><b>Kedd</b></span>
                                                                        @else
                                                                            <span class="">Kedd</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="tuesday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 2)
                                                                            <span class=""><b>Kedd</b></span>
                                                                        @else
                                                                            <span class="">Kedd</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->wednesday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="wednesday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 3)
                                                                            <span class=""><b>Szerda</b></span>
                                                                        @else
                                                                            <span class="">Szerda</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="wednesday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 3)
                                                                            <span class=""><b>Szerda</b></span>
                                                                        @else
                                                                            <span class="">Szerda</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->thirsday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="thirsday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 4)
                                                                            <span class=""><b>Csütörtök</b></span>
                                                                        @else
                                                                            <span class="">Csütörtök</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="thirsday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 4)
                                                                            <span class=""><b>Csütörtök</b></span>
                                                                        @else
                                                                            <span class="">Csütörtök</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->friday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="friday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 5)
                                                                            <span class=""><b>Péntek</b></span>
                                                                        @else
                                                                            <span class="">Péntek</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="friday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 5)
                                                                            <span class=""><b>Péntek</b></span>
                                                                        @else
                                                                            <span class="">Péntek</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->saturday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="saturday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 6)
                                                                            <span class=""><b>Szombat</b></span>
                                                                        @else
                                                                            <span class="">Szombat</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="saturday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 6)
                                                                            <span class=""><b>Szombat</b></span>
                                                                        @else
                                                                            <span class="">Szombat</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($meal->sunday)
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="sunday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 7)
                                                                            <span class=""><b>Vasárnap</b></span>
                                                                        @else
                                                                            <span class="">Vasárnap</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="sunday" value="0">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        @if($day == 7)
                                                                            <span class=""><b>Vasárnap</b></span>
                                                                        @else
                                                                            <span class="">Vasárnap</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel leírása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                              <fieldset class="form-label-group mb-0">
                                                                <textarea data-length="500" class="form-control char-textarea active" id="textarea-counter" name="description" rows="5" placeholder="Étel leírás">{{$meal->description}}</textarea>
                                                              </fieldset>
                                                              <small class="counter-value float-right"><span class="char-count">0</span> / 500 </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel specifikációi</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                    @if($meal->vegan)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegan" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegán</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegan" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegán</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->vegetarian)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegetarian" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegetáriánus</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegetarian" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegetáriánus</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->glutenfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="glutenfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Glutén mentes</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="glutenfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Glutén mentes</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->lactosefree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="lactosefree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Laktóz mentes</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="lactosefree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Laktóz mentes</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->fatfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="fatfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott zsírt</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="fatfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott zsírt</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->sugarfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sugarfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott cukrot</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sugarfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott cukrot</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($meal->allergenicfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="allergenicfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz allergén alapanyagokat</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="allergenicfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz allergén alapanyagokat</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel kalóriatartalma</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <select class="form-control" name="calorie" id="basicSelect">
                                                                                @if($meal->calorie == NULL)
                                                                                    <option value="NULL">Nincs megadva</option>
                                                                                @else
                                                                                    <option value="{{$meal->calorie}}" selected>{{$meal->calorie}} Kalória</option>
                                                                                @endif
                                                                                <option value="NULL">Nincs megadva</option>
                                                                                <option value="0-200">0-200 Kalória</option>
                                                                                <option value="200-400">200-400 Kalória</option>
                                                                                <option value="400-600">400-600 Kalória</option>
                                                                                <option value="600-800">600-800 Kalória</option>
                                                                                <option value="800-1000">800-1000 Kalória</option>
                                                                                <option value="1000-1200">1000-1200 Kalória</option>
                                                                                <option value="1200-1400">1200-1400 Kalória</option>
                                                                                <option value="1400-1600">1400-1600 Kalória</option>
                                                                                <option value="1600-1800">1600-1800 Kalória</option>
                                                                                <option value="1800-2000">1800-2000 Kalória</option>
                                                                                <option value="2000+">2000+ Kalória</option>
                                                                        </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Külön is rendelhető</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                @if($meal->available_separately)
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" name="available_separately" value="1" class="custom-control-input" id="customSwitch2" checked>
                                                                        <label class="custom-control-label" for="customSwitch2">
                                                                        </label>
                                                                        <span class="switch-label">Külön is rendelhető</span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" name="available_separately" value="0" class="custom-control-input" id="customSwitch2" >
                                                                        <label class="custom-control-label" for="customSwitch2">
                                                                        </label>
                                                                        <span class="switch-label">Külön is rendelhető</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Elérhető</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                @if($meal->available)
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" name="available" value="1" class="custom-control-input" id="customSwitch3" checked>
                                                                        <label class="custom-control-label" for="customSwitch3">
                                                                        </label>
                                                                        <span class="switch-label">Jelenleg rendelhető</span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" name="available" value="0" class="custom-control-input" id="customSwitch3">
                                                                        <label class="custom-control-label" for="customSwitch3">
                                                                        </label>
                                                                        <span class="switch-label">Jelenleg rendelhető</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
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
                                    <h4 class="card-title">Extra opciók</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="{{ url('add-category') }}">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                            <div class="table-responsive">
                                                            <table class="table table-hover-animation mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Név</th>
                                                                            <th scope="col">fogyasztói ár</th>
                                                                            <th scope="col">Árrés</th>
                                                                            <th scope="col">Beszerzési ár</th>
                                                                            <th scope="col">Törlés</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($extras as $key => $data)
                                                                            <tr>
                                                                                <th scope="row"><b>{{$data->name}}</b></th>
                                                                                <td>{{number_format($data->price, 0)}} Ft</td>
                                                                                <td>{{number_format(($data->price - $data->makeprice), 0)}} Ft</td>
                                                                                <td>{{number_format($data->makeprice, 0)}} Ft</td>
                                                                                <td>
                                                                                    <form method="post" action="{{ url('remove-extra') }}">
                                                                                    @csrf
                                                                                    <input type="hidden" name="extraid" value="{{$data->id}}">
                                                                                    <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                    <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            </div>
                                                        </div>
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
                                    <h4 class="card-title">Extrák</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="{{ url('add-extra') }}">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf
                                                    <input type="hidden" id="mealid" class="form-control" name="mealid" value="{{$meal->id}}">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Opció neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="name" class="form-control" name="name" placeholder="Opció megnevezése">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Fogyasztói ár</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" id="price" class="form-control" name="price" placeholder="Eladási ár">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Beszerzési ár</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" id="makeprice" class="form-control" name="makeprice" placeholder="Beszerzési ár">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Hozzáadás</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title">Étel törlése</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{ url('delete-meal') }}">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <span>Biztosan törli véglegesen?</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $meal->id }}">
                                                            <div class="vs-checkbox-con vs-checkbox-danger">
                                                                <input type="checkbox" name="verify" value="0">
                                                                <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                                </span>
                                                                <span class="">Megerősítem, hogy ezt a terméket véglegesen törlni szeretném az étterem étlapjáról!</span>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Törlés</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
@else
<div class="row match-height">
    <div class="col-md-12 col-12">
        <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Az étel szerkesztése nem lehetséges, mert még hozott létre kategóriákat.</strong><br/>
            Kérjük előbb hozzon létre új kategóriákat, melyek az éttermének menüpontjaiként fognak szolgálni, majd próbálja újra.
        </div>
    </div>
    <div class="col-12">
        <a href="{{ url('category-settings') }}" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Kategória beállítások</a>
    </div>
</div>
@endif
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
            window.onload = function() {
                calculate();
            };
            function calculate() {
                var price = document.querySelector('#v0').value;
                var make = document.querySelector('#v1').value;
                var sale = document.querySelector('#v2').value;
                if (price && make && sale) {
                    document.querySelector('#result').value = (sale - make).toFixed(0) + '-' + (price - make).toFixed(0) + ' Ft';
                    var profit = (price - make).toFixed(0);
                    var saleprofit = (sale - make).toFixed(0);
                    var salepricediff = (price - sale).toFixed(0);
                    if (profit > 0 && saleprofit > 0 && salepricediff > 0) {
                        if (profit >= 250 && saleprofit >= 150) {
                            var el = document.querySelector('#result');

                            el.style.backgroundColor = 'rgba(40, 199, 111, 0.2)';
                            el.style.borderColor = '#28c76f';
                        } else {
                            var el = document.querySelector('#result');

                            el.style.backgroundColor = 'rgba(255, 159, 67, 0.2)';
                            el.style.borderColor = '#ff9f43';
                        }
                    } else {
                        var el = document.querySelector('#result');
                        
                        el.style.backgroundColor = 'rgba(234, 84, 85, 0.2)';
                        el.style.borderColor = '#ea5455';
                    }
                }
            }
        </script>
@endsection