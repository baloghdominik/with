@extends('layouts/contentLayoutMaster')

@section('title', 'Pizza Designer - Dough')

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

        @foreach($pizzadesigner_sizes as $key => $data)
        <div class="col-md-8 col-12">
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Pizza Tészta Fajták - {{ $data->size }} cm</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover-animation mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Név</th>
                                                <th scope="col">Felár</th>
                                                <th scope="col">Árrés</th>
                                                <th scope="col">Törlés</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pizzadesigner_dough as $key => $dough)
                                                @if($data->id == $dough->sizeid)
                                                <tr>
                                                    <th scope="row"><b>{{$dough->name}}</b></th>
                                                    <td>{{number_format($dough->price, 0)}} Ft</td>
                                                    @if($dough->price <= 0)
                                                    <td style="color: #e42728;">{{number_format(($dough->price), 0)}} Ft</td>
                                                    @else
                                                    <td>{{number_format($dough->price, 0)}} Ft</td>
                                                    @endif
                                                    <td>
                                                        <form method="post" action="{{ url('pizzadesigner-remove-dough') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$dough->id}}">
                                                        <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light"><i class="feather icon-x"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endif
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
        @endforeach

        <div class="col-md-8 col-12">
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Új Pizza Tészta</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    <form class="form form-horizontal" method="post" action="{{ url('pizzadesigner-add-dough') }}"  enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Méret</span>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="sizeid" id="basicSelect">
                                                    @foreach($pizzadesigner_sizes as $key => $data)
                                                            <option value="{{ $data->id }}">{{ $data->size }} cm</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Megnevezés</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="string" min="2" max="50" id="name" class="form-control" name="name" placeholder="A tészta megnevezése">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Felár</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" min="0" max="50000" class="form-control" name="price" placeholder="A tészta eladási ára">
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