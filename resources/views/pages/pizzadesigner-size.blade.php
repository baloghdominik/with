@extends('layouts/contentLayoutMaster')

@section('title', 'Pizza Designer - Sizes')

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
                    <h4 class="card-title">Méretek</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover-animation mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Méret</th>
                                                <th scope="col">Fogyasztói ár</th>
                                                <th scope="col">Árrés</th>
                                                <th scope="col">Beszerzési ár</th>
                                                <th scope="col">Elkészítési idő</th>
                                                <th scope="col">Max feltét</th>
                                                <th scope="col">Törlés</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pizzadesigner_sizes as $key => $size)
                                                <tr>
                                                    <th scope="row"><b>{{$size->size}} cm</b></th>
                                                    <td>{{number_format($size->price, 0)}} Ft</td>
                                                    <td>{{number_format(($size->price - $size->makeprice), 0)}} Ft</td>
                                                    <td>{{number_format($size->makeprice, 0)}} Ft</td>
                                                    <td>{{number_format($size->maketime, 0)}} Perc</td>
                                                    <td>{{number_format($size->toppingslimit, 0)}} db</td>
                                                    <td>
                                                        <form method="post" action="{{ url('pizzadesigner-remove-size') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$size->id}}">
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
        </div>

        <div class="col-md-8 col-12">
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Új Méret</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    <form class="form form-horizontal" method="post" action="{{ url('pizzadesigner-add-size') }}"  enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Méret</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="5" max="200" id="size" class="form-control" name="size" placeholder="Pizza mérete">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Fogyasztói ár</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="50000" class="form-control" name="price" placeholder="Pizza eladási ára">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Elkészítési ár</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="50000" class="form-control" name="makeprice" placeholder="Pizza elkészítési ára">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Elkészítési idő</span>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="maketime" id="basicSelect">
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
                                                <span>Maximum feltétek száma</span>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="toppingslimit" id="basicSelect2">
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5" selected>5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7 (ajánlott)</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
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