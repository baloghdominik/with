@extends('layouts/contentLayoutMaster')

@section('title', 'Category Settings')

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

        <div class="col-md-6 col-12">
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Új Kategória</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="post" action="/withadmin/public/add-category">
                            <div class="form-body">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Kategória neve</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="category" class="form-control" name="category" placeholder="Kategória megnevezése">
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


        @if(sizeof($categories) !== 0)
        <div class="col-md-6 col-12">
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Kategória törlés</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="post" action="/withadmin/public/delete-category">
                            <div class="form-body">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Kategória</span>
                                            </div>
                                            <div class="col-md-8">
                                                        <select class="form-control" name="id" id="basicSelect">
                                                            @foreach($categories as $key => $data)
                                                                <option value="{{ $data->id }}">{{ $data->category }}</option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Törlés</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

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