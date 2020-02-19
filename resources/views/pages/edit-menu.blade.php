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
                                    <h4 class="card-title">Menü szerkesztése</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
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
                                                            <div class="col-md-4 mb-1">
                                                                <span>Választható köretek</span>
                                                            </div>
                                                            <div class="col-md-8 mb-1">
                                                            <p>Itt látható az összes feltöltött köret.<br/>
                                                                A könnyebb átláthatóság kedvéért a mai nap nem tételeket köreteket <span class="badge badge-warning">sárga</span> színnel, az egyáltalán nem rendelhető tételeket pedig <span class="badge badge-danger">piros</span> színnel jelöltük. </p>
                                                            </div>
                                                            <div class="col-12">
                                                            <div class="table-responsive mb-2">
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
                                                                                <td>
                                                                                @php
                                                                                    $btn = false;
                                                                                @endphp
                                                                                @foreach($menusides as $key => $menuside)
                                                                                    @if($menuside->sideid == $data->id)
                                                                                    @php
                                                                                    $btn = true;
                                                                                    @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($btn)
                                                                                <form method="post" action="/withadmin/public/remove-side-from-menu">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="sideid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                                                </form>
                                                                                @else
                                                                                <form method="post" action="/withadmin/public/add-side-to-menu">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="sideid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-primary waves-effect waves-light"><i class="feather icon-plus"></i></button>
                                                                                </form>
                                                                                @endif
                                                                                </td>
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
                                                            <div class="col-md-4 mb-1">
                                                                <span>Választható italok</span>
                                                            </div>
                                                            <div class="col-md-8 mb-1">
                                                            <p>Itt látható az összes feltöltött ital.<br/>
                                                                A könnyebb átláthatóság kedvéért a mai nap nem rendelhető tételeket <span class="badge badge-warning">sárga</span> színnel, az egyáltalán nem rendelhető tételeket pedig <span class="badge badge-danger">piros</span> színnel jelöltük. </p>
                                                            </div>
                                                            <div class="col-12">
                                                            <div class="table-responsive mb-2">
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
                                                                    @foreach($drink as $key => $data)
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
                                                                                <td>
                                                                                @php
                                                                                    $btn = false;
                                                                                @endphp
                                                                                @foreach($menudrinks as $key => $menudrink)
                                                                                    @if($menudrink->drinkid == $data->id)
                                                                                    @php
                                                                                    $btn = true;
                                                                                    @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($btn)
                                                                                <form method="post" action="/withadmin/public/remove-drink-from-menu">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="drinkid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                                                </form>
                                                                                @else
                                                                                <form method="post" action="/withadmin/public/add-drink-to-menu">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="drinkid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-primary waves-effect waves-light"><i class="feather icon-plus"></i></button>
                                                                                </form>
                                                                                @endif
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