@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Menu')

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
                                    <h4 class="card-title">Menü szerkesztése</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form form-horizontal" method="post" action="/withadmin/public/update-meal/{{$meal->id}}"  enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf 
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Menü fotója</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <img src="{{ asset('images/meals/'.$meal->picid.'.jpg') }}" width="100%" height="auto" style="margin-bottom: 25px; border-radius: 1rem;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Menü neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="food-name" class="form-control" name="name" value="{{$meal->name}}" disabled>
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
                                                                <span>Választható köretek</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <p>Itt látható az összes feltöltött köret.<br/>
                                                                A könnyebb átláthatóság kedvéért a mai nap nem rendelhető köreteket <span class="badge badge-warning">sárga</span> színnel, az egyáltalán nem rendelhető köreteket pedig <span class="badge badge-danger">piros</span> színnel jelöltük. </p>
                                                            </div>
                                                            <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover-animation mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Név</th>
                                                                            <th scope="col">Menü <a style="color: #47b272;" data-toggle="popover" data-placement="top" data-content="A kizárólag menüben rendelhető tételeket pipával, míg a külön is elérhetőeket x-el jelöltük." data-trigger="hover" data-original-title="Segítség" ><i class="feather icon-alert-octagon"></i></a></th>
                                                                            <th scope="col">Ár</th>
                                                                            <th scope="col">Akciós ár</th>
                                                                            <th scope="col">Művelet</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($side as $key => $data)
                                                                        @if($data->available)
                                                                            @if($day == 1 && !$data->monday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 2 && !$data->tuesday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 3 && !$data->wednesday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 4 && !$data->thirsday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 5 && !$data->friday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 6 && !$data->saturday)
                                                                            <tr class="table-warning">
                                                                            @elseif($day == 7 && !$data->sunday)
                                                                            <tr class="table-warning">
                                                                            @else
                                                                            <tr>
                                                                            @endif
                                                                        @else
                                                                            <tr class="table-danger">
                                                                        @endif
                                                                                <th scope="row"><b>{{$data->name}}</b></th>
                                                                                @if($data->available_separately)
                                                                                    <td><i class="fa fa-check"></i></td>
                                                                                @else
                                                                                    <td><i class="fa fa-close"></i></td>
                                                                                @endif
                                                                                <td>{{number_format($data->price, 0)}} Ft</td>
                                                                                <td>{{number_format($data->saleprice, 0)}} Ft</td>
                                                                                <td><a href="add-side-to-menu" class="btn btn-icon btn-primary waves-effect waves-light"><i class="feather icon-plus"></i></a></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
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
        /*=========================================================================================
    File Name: popover.js
    Description: Popovers are an updated version, which don’t rely on images,
                use CSS3 for animations, and data-attributes for local title storage.
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
'use strict';
    $('[data-toggle="popover"]').popover();


    /******************/
    // Popover events //
    /******************/

    // onShow event
    $('#show-popover').popover({
        title: 'Popover Show Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'right'
        }).on('show.bs.popover', function() {
            alert('Show event fired.');
    });

    // onShown event
    $('#shown-popover').popover({
        title: 'Popover Shown Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'bottom'
    }).on('shown.bs.popover', function() {
        alert('Shown event fired.');
    });

    // onHide event
    $('#hide-popover').popover({
        title: 'Popover Hide Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'bottom'
    }).on('hide.bs.popover', function() {
        alert('Hide event fired.');
    });

    // onHidden event
    $('#hidden-popover').popover({
        title: 'Popover Hidden Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'left'
    }).on('hidden.bs.popover', function() {
        alert('Hidden event fired.');
    });

    /*******************/
    // Tooltip methods //
    /*******************/

    // Show method
    $('#show-method').on('click', function() {
        $(this).popover('show');
    });
    // Hide method
    $('#hide-method').on('mouseenter', function() {
        $(this).popover('show');
    });
    $('#hide-method').on('click', function() {
        $(this).popover('hide');
    });
    // Toggle method
    $('#toggle-method').on('click', function() {
        $(this).popover('toggle');
    });
    // Dispose method
    $('#dispose').on('click', function() {
        $('#dispose-method').popover('dispose');
    });


    /* Trigger*/
    $('.manual').on('click', function() {
        $(this).popover('show');
    });
    $('.manual').on('mouseout', function() {
        $(this).popover('hide');
    });

    /****************/
    // Custom color //
    /****************/
    $('[data-popup=popover-color]').popover({
        template: '<div class="popover"><div class="bg-teal"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
    });

    /**********************/
    // Custom borer color //
    /**********************/
    $('[data-popup=popover-border]').popover({
        template: '<div class="popover"><div class="border-orange"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
    });

})(window, document, jQuery);
        </script>

@endsection