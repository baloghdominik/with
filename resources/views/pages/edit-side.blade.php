@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Side')

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
        <div class="col-12">
        <a href="{{ url('list-side') }}" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">Köret lista</a>
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
                                    <h4 class="card-title">Köret szerkesztése</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form form-horizontal" method="post" action="/withadmin/public/update-side/{{$side->id}}"  enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf 
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret fotója</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <img src="{{ asset('images/sides/'.$side->picid.'.jpg') }}" width="100%" height="auto" style="margin-bottom: 25px; border-radius: 1rem;">
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
                                                                <span>Köret neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="hidden" id="picid" class="form-control" name="picid" value="{{$side->picid}}">
                                                                <input type="text" id="food-name" class="form-control" name="name" value="{{$side->name}}" placeholder="Köret megnevezése">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret fogyasztói ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="price" value="{{$side->price}}" placeholder="Köret eladási ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret akciós ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="saleprice" value="{{$side->saleprice}}" placeholder="Köret kedvezményes ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Akció bekapcsolása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            @if($side->sale)
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
                                                                <span>Köret elkészítési ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="makeprice" value="{{$side->makeprice}}" placeholder="Köret elkszítési költsége">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret árrése</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>~0 ft</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret elkészítési ideje</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <select class="form-control" name="maketime" id="basicSelect">
                                                                                <option value="{{$side->maketime}}" selected>{{$side->maketime}} perc</option>
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
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret elérhetősége</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                @if($side->monday)
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
                                                                @if($side->tuesday)
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
                                                                @if($side->wednesday)
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
                                                                @if($side->thirsday)
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
                                                                @if($side->friday)
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
                                                                @if($side->saturday)
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
                                                                @if($side->sunday)
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
                                                                <span>Köret leírása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <fieldset class="form-label-group mb-0">
                                                                <textarea data-length="500" class="form-control char-textarea active" id="textarea-counter" name="description" rows="5" placeholder="Köret leírás">{{$side->description}}</textarea>
                                                              </fieldset>
                                                              <small class="counter-value float-right"><span class="char-count">0</span> / 500 </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret specifikációi</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                    @if($side->vegan)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegan" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Vegán</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegan" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Vegán</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->vegetarian)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegetarian" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Vegetáriánus</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="vegetarian" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Vegetáriánus</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->glutenfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="glutenfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Glutén mentes</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="glutenfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Glutén mentes</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->lactosefree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="lactosefree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Laktóz mentes</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="lactosefree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret Laktóz mentes</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->fatfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="fatfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz hozzá adott zsírt</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="fatfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz hozzá adott zsírt</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->sugarfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sugarfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz hozzá adott cukrot</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sugarfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz hozzá adott cukrot</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                    @if($side->allergenicfree)
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="allergenicfree" value="1" checked>
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz allergén alapanyagokat</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="allergenicfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez a köret nem tartalmaz allergén alapanyagokat</span>
                                                                        </div>
                                                                    @endif
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Köret kalóriatartalma</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <select class="form-control" name="calorie" id="basicSelect">
                                                                                @if($side->calorie == NULL)
                                                                                    <option value="NULL">Nincs megadva</option>
                                                                                @else
                                                                                    <option value="{{$side->calorie}}" selected>{{$side->calorie}} Kalória</option>
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
                                                                @if($side->available_separately)
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
                                                                @if($side->available)
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
@endsection