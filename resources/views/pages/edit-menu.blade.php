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
                                                <form class="form form-horizontal" method="post" action="{{ url('update-menu') }}"  enctype="multipart/form-data">
                                                    @csrf 
                                                    <input type="hidden" id="id" class="form-control" name="id" value="{{$menu->id}}">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Menü fotója*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            @php 
                                                                if (file_exists("images/menus/".$menu->picid.".jpg")) {
                                                                    $img = "images/menus/".$menu->picid.".jpg";
                                                                } else {
                                                                    $img = "images/notfound/product_default.jpg";
                                                                }
                                                            @endphp
                                                            <img src="{{ asset($img) }}" width="100%" height="auto" style="margin-bottom: 25px; border-radius: 1rem;">
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
                                                                <span>Menü neve*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="food-name" class="form-control" name="name" value="{{$menu->name}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Kategória*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control" name="category" id="basicSelect" required>
                                                                    @foreach($categories as $key => $data)
                                                                        @if($data->id == $menu->category)
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
                                                                <span data-toggle="popover" data-content="A menü kedvezménynél megadhatja, hogy az adott ételre hány százalék kedvezményt ad a vásárlónak amennyiben az köretet és/vagy italt is vásárol hozzá. A kedvezmény kizárólag a menü fő ételére vonatkozik, a köretekre és italokra nem! További kérdések esetén keresse az ügyfélszolgálatunkat." data-trigger="hover" data-original-title="Mi az a Menü kedvezmény?" data-placement="top" style="cursor: pointer;">Menü kedvezmény* (%) <i class="fa fa-info-circle" style="color: #47b272; cursor: pointer;"></i></span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input min="0" max="90" type="number" id="menusalepercent" class="form-control" name="menusalepercent" value="{{$menu->menusalepercent}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Menü bekapcsolása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            @if($menu->enable)
                                                            <div class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" name="enable" value="1" class="custom-control-input" id="customSwitch1" checked>
                                                                <label class="custom-control-label" for="customSwitch1">
                                                                </label>
                                                                <span class="switch-label">Bekapcsolás</span>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <div class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" name="enable" value="0" class="custom-control-input" id="customSwitch1">
                                                                <label class="custom-control-label" for="customSwitch1">
                                                                </label>
                                                                <span class="switch-label">bekapcsolás</span>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Mentés</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>


                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4 mb-1">
                                                                <span>Választható köretek*</span>
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
                                                                            <th scope="col">Menü <a style="color: #47b272;" data-toggle="popover" data-placement="top" data-content="A kizárólag menüben rendelhető tételeket pipával, míg a külön is elérhetőeket x-el jelöltük." data-trigger="hover" data-original-title="Segítség" ><i class="fa fa-info-circle"></i></a></th>
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
                                                                            @elseif($day == 0 && !$data->sunday)
                                                                            <tr class="table-warning">
                                                                            @else
                                                                            <tr>
                                                                            @endif
                                                                        @else
                                                                            <tr class="table-danger">
                                                                        @endif
                                                                                <th scope="row"><b>{{$data->name}}</b></th>
                                                                                @if($data->available_separately)
                                                                                    <td><i class="fa fa-close"></i></td>
                                                                                @else
                                                                                    <td><i class="fa fa-check"></i></td>
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
                                                                                <form method="post" action="{{ url('remove-side-from-menu') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="menuid" value="{{$menu->id}}">
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="sideid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                                                </form>
                                                                                @else
                                                                                <form method="post" action="{{ url('add-side-to-menu') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="menuid" value="{{$menu->id}}">
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
                                                                <span>Választható italok*</span>
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
                                                                            <th scope="col">Menü <a style="color: #47b272;" data-toggle="popover" data-placement="top" data-content="A kizárólag menüben rendelhető tételeket pipával, míg a külön is elérhetőeket x-el jelöltük." data-trigger="hover" data-original-title="Segítség" ><i class="fa fa-info-circle"></i></a></th>
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
                                                                            @elseif($day == 0 && !$data->sunday)
                                                                            <tr class="table-warning">
                                                                            @else
                                                                            <tr>
                                                                            @endif
                                                                        @else
                                                                            <tr class="table-danger">
                                                                        @endif
                                                                                <th scope="row"><b>{{$data->name}}</b></th>
                                                                                @if($data->available_separately)
                                                                                    <td><i class="fa fa-close"></i></td>
                                                                                @else
                                                                                    <td><i class="fa fa-check"></i></td>
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
                                                                                <form method="post" action="{{ url('remove-drink-from-menu') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="menuid" value="{{$menu->id}}">
                                                                                <input type="hidden" name="drinkid" value="{{$data->id}}">
                                                                                <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                                                </form>
                                                                                @else
                                                                                <form method="post" action="{{ url('add-drink-to-menu') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="mealid" value="{{$meal->id}}">
                                                                                <input type="hidden" name="menuid" value="{{$menu->id}}">
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

@endsection