@extends('layouts/contentLayoutMaster')

@section('title', 'Table Reservations')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">

        <style>
        .modal {
            background-color: rgba(71, 178, 114, 0.9) !important;
        }
        </style>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
@endsection

@section('content')
<section id="basic-horizontal-layouts">

<audio id="notification">
  <source src="{{ asset('sounds/notification15.ogg') }}" type="audio/ogg">
  <source src="{{ asset('sounds/notification15.mp3') }}" type="audio/mpeg">
  A bőngésződ nem támogatja a hangos értesítést!
</audio><br>



<div class="row">
    <div class="col-lg-3 col-md-5 col-sm-12">
        <div class="card">
            <div class="card-content">
                <img class="card-img img-fluid" src="{{ asset('images/elements/clock2.jpg') }}" alt="Card image">
                <div class="card-img-overlay overflow-hidden overlay-primary overlay-lighten-2">
                    @php
                    date_default_timezone_set('Europe/Budapest');

                    $datenow = new DateTime(date("Y/m/d"));
                    $datenow = date_format($datenow, 'Y/m/d');

                    $timenow = new DateTime(date("H:i:s"));
                    $timenow = date_format($timenow, 'H:i:s');
                    @endphp
                    <h1 class="text-white"><div id="txt"></div></h1>
                    <p class="card-text text-white">{{ $datenow }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade text-left" id="onshow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel21">Értesítés</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h1><i class="fa fa-check" style="color: #47b272 !important;"></i></h1>
                    <h4 style="color: #47b272 !important;">Új foglalás!</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Megtekintés</button>
                </div>
            </div>
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

        @php 
        $n = 1;
        @endphp
        @foreach($reservations as $key => $data)
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-2">
            <div class="card">
                <div class="card-header mx-auto pb-0">
                    <div class="row m-0">
                        <div class="col-sm-12 text-center">
                            <h4>Asztal foglalás - {{ $n++ }}</h4>
                        </div>
                        <div class="col-sm-12 text-center">
                            @php
                            $reserved = new DateTime($data->created_at);
                            $reserved = date_format($reserved, 'Y/m/d H:i');
                            @endphp
                            <p class="mb-0">{{$reserved}}</p>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body mx-auto">
                        <div class="mb-3 mt-1">
                            <h4 style="margin: 0px !important;"><i class="fa fa-user"></i> {{ $data->lastname}} {{ $data->firstname }}</h4>
                            <p style="margin: 0px !important;"><i class="fa fa-envelope"></i> {{ $data->email }}</p>
                            <p style="margin: 0px !important;"><i class="fa fa-phone"></i> {{ $data->phone }}</p>
                            <p style="margin: 0px !important;"><i class="fa fa-comment"></i> {{ $data->comment }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="uploads">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $data->person }}</p>
                                <span class="">Fő</span>
                            </div>
                            @php
                            $date = new DateTime($data->date);
                            $date = date_format($date, 'Y/m/d');
                            @endphp
                            <div class="followers">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $date }}</p>
                                <span class="">Dátum</span>
                            </div>
                            @php
                            $time = new DateTime($data->time);
                            $time = date_format($time, 'H:i');
                            @endphp
                            <div class="following">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $time }}</p>
                                <span class="">Időpont</span>
                            </div>
                        </div>
                        <form method="post" action="{{ url('update-reservation') }}">
                        @csrf 
                        <div class="form-group mt-2">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <input type="text" class="form-control" name="comment" placeholder="Megjegyzés">
                        </div>
                        <div class="card-btns d-flex justify-content-between">
                            <button name="confirm" class="btn btn-primary waves-effect waves-light">Elfogadás</button> 
                            <button name="delete" class="btn btn-danger waves-effect waves-light">Elutasítás</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="row match-height">


        @foreach($confirmedreservations as $key => $data)
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-2">
            @php
                date_default_timezone_set('Europe/Budapest');

                $today = new DateTime(date("Y/m/d"));
                $today = date_format($today, 'Y/m/d');

                $date = new DateTime($data->date);
                $date = date_format($date, 'Y/m/d');

                $now = new DateTime(date("H:i"));
                $now = date_format($now, 'H:i');

                $time = new DateTime($data->time);
                $time = date_format($time, 'H:i');

                $before = new DateTime(date("H:i",  strtotime($time) - 60 * 60 * 1));
                $before = date_format($before, 'H:i');

                $after = new DateTime(date("H:i",  strtotime($time) + 60 * 60 * 1));
                $after = date_format($after, 'H:i');
            @endphp
            @if($today == $date && $now > $before && $now < $after)
            <div class="card" style="border-color: #47b272; border-size: 5px; border-style: solid;">
            @else
            <div class="card" style="border-color: #fff; border-size: 5px; border-style: solid;">
            @endif
                <div class="card-header mx-auto pb-0">
                    <div class="row m-0">
                        <div class="col-sm-12 text-center">
                            <h1><i style="color: #47b272;" class="fa fa-check-circle"></i></h1>
                        </div>
                        <div class="col-sm-12 text-center">
                            <p class="mb-0" style="color: #47b272;"><b>Elfogadva</b></p>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body mx-auto">
                        <div class="mb-3 mt-1">
                            <h4>{{ $data->lastname}} {{ $data->firstname }}</h4>
                            <p>{{ $data->email }}</p>
                            <p class="mt-1">{{ $data->comment }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="uploads">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $data->person }}</p>
                                <span class="">Fő</span>
                            </div>
                            @php
                            $date = new DateTime($data->date);
                            $date = date_format($date, 'Y/m/d');
                            @endphp
                            <div class="followers">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $date }}</p>
                                <span class="">Dátum</span>
                            </div>
                            @php
                            $time = new DateTime($data->time);
                            $time = date_format($time, 'H:i');
                            @endphp
                            <div class="following">
                                <p class="font-weight-bold font-medium-2 mb-0">{{ $time }}</p>
                                <span class="">Időpont</span>
                            </div>
                        </div> 
                        <form method="post" action="{{ url('delete-reservation') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-danger btn-block mt-2 waves-effect waves-light">Sztornó</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        

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
    var x = document.getElementById("notification");
    x.loop = true;
    x.load();

    
    function playNotification() {
        var x = document.getElementById("notification");
        x.loop = true;
        x.load();
        x.play();
    }

    function stopNotification() {
        var x = document.getElementById("notification");
        x.loop = true;
        x.load();
        x.stop();
    }
</script>
<script>
(function(window, document, $) {
	'use strict';

     // onShow event
    $('#onshowbtn').on('click', function() {
        $('#onshow').on('show.bs.modal', function() {
            playNotification();
        });
    });

    // onHidden event
    $('#onshowbtn').on('click', function() {
        $('#onshow').on('hidden.bs.modal', function() {
            stopNotification();
        });
    });

})(window, document, jQuery);
</script>
<script>
startTime();
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>
@endsection