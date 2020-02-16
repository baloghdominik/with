@extends('layouts/contentLayoutMaster')

@section('title', 'Menu Settings')

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

                        <div class="col-md-8 col-12">
                            <div class="card" style="">
                                <div class="card-header">
                                    <h4 class="card-title">Menü lista</h4>
                                </div>
                                <div class="card-content">
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