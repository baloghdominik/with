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

    <section class="users-edit">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                                            <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Áttekintés</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="jelszo-tab" data-toggle="tab" href="#jelszo" aria-controls="jelszo" role="tab" aria-selected="false">
                                            <i class="feather icon-lock mr-25"></i><span class="d-none d-sm-block">Jelszó</span>
                                        </a>
                                    </li>
                                    <!--<li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="email-tab" data-toggle="tab" href="#email" aria-controls="email" role="tab" aria-selected="false">
                                            <i class="feather icon-mail mr-25"></i><span class="d-none d-sm-block">Email</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="profil-tab" data-toggle="tab" href="#profil" aria-controls="profil" role="tab" aria-selected="false">
                                            <i class="feather icon-image mr-25"></i><span class="d-none d-sm-block">Profilkép</span>
                                        </a>
                                    </li>-->
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                        <form novalidate="">
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Név</th>
                                                                    <td>{{ $user->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Email</th>
                                                                    <td>{{ $user->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Ellenőrizve</th>
                                                                    <td>
                                                                    @if( $user->email_verified_at == NULL )
                                                                    Nem
                                                                    @else
                                                                    {{ $user->email_verified_at }}
                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Regisztráció</th>
                                                                    <td>{{ $user->created_at }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Módosítás</th>
                                                                    <td>
                                                                    @if( $user->updated_at == $user->created_at )
                                                                    Még nem történt módosítás
                                                                    @else
                                                                    {{ $user->updated_at }}
                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="jelszo" aria-labelledby="jelszo-tab" role="tabpanel">
                                        <form method="post" action="{{ url('change-password') }}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label>Jelenlegi jelszó</label>
                                                            <input type="password" class="form-control" name="current_password" placeholder="Jelszó" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label>Új jelszó</label>
                                                            <input type="password" class="form-control" name="new_password" minlength="8" placeholder="Jelszó" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label>Új jelszó megerősítése</label>
                                                            <input type="password" class="form-control" name="new_password_conf" minlength="8" placeholder="Jelszó" required="">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">
                                                        Mentés</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!--<div class="tab-pane" id="email" aria-labelledby="email-tab" role="tabpanel">
                                        <form >
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label>Jelenlegi jelszó</label>
                                                            <input type="password" class="form-control" placeholder="Jelszó" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label>Új Email</label>
                                                            <input type="email" class="form-control" placeholder="email@domain.com" required="">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-light">
                                                        Mentés</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="profil" aria-labelledby="profil-tab" role="tabpanel">
                                        <div class="media mb-2">
                                            <form novalidate="">
                                                <a class="mr-2 my-25" href="#">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-18.jpg" alt="users avatar" class="users-avatar-shadow rounded" height="90" width="90">
                                                </a>
                                                <div class="media-body mt-50">
                                                    <div class="custom-file">
                                                            <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Válasszon fotót</label>
                                                    </div>
                                                    <div class="col-12 d-flex mt-1 px-0">
                                                        <a href="#" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Feltöltés</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
       

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
@endsection