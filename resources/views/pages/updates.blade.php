@extends('layouts/contentLayoutMaster')

@section('title', 'Video Repository')

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
    <div class="col-md-4 col-sm-12">
        <div class="row">

            <div class="col-12">
                <div class="updates-info">
                    <h4><i class="feather icon-alert-circle primary"></i> Fontos a véleménye!</h4>
                    Napról napra próbáljuk a <span class="with-logo">With</span>-et naprakészen tartani és jobbnál jobb funkciókkal ellátni, azonban ahhoz, hogy ez sikerüljön elengedhetetlen az ön véleménye.
                    Kérjük amennyiben hibát fedez fel, szüksége van valami új funkcióra, vagy támad egy jó ötlete, amivel még jobbá tehetjük a szolgáltatásunk, feltétlen vegye fel velünk a <a href="{{ url('help') }}">kapcsolat</a>-ot.
                </div>
            </div>

            <div class="col-12">
                <div class="updates-info">
                    <h4><i class="feather icon-git-branch primary"></i> 0.0.52es verzió <span class="date">2020/11/15</span></h4>
                    <ul>
                        <li>Pizzatervező</li>
                        <li>Ételek értékesítése menüként</li>
                        <li>Részletesebb statisztikák</li>
                        <li>Hibajavítások</li>
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <div class="updates-info">
                    <h4><i class="feather icon-git-branch primary"></i> 0.0.51-es verzió <span class="date">2020/11/14</span></h4>
                    <ul>
                        <li>Információs oldal a frissítésekről</li>
                        <li>Hibajavítások</li>
                    </ul>
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