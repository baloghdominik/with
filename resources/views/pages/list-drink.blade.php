@extends('layouts/contentLayoutMaster')

@section('title', 'List Drinks')

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
        <a href="add-drink" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">Új ital</a>
        </div>
    </div>
<div class="row" id="table-responsive">
                    <div class="col-lg-10 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ital lista</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>Itt látható az összes feltöltött ital.<br/>
                                    A könnyebb átláthatóság kedvéért a mai nap nem rendelhető italokat <span class="badge badge-warning">sárga</span> színnel, az egyáltalán nem rendelhető italokat pedig <span class="badge badge-danger">piros</span> színnel jelöltük. </p>
                                </div>
                                <table class="table table-responsive table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th width="400px">Kép</th>
                                            <th scope="col">Név</th>
                                            <th scope="col">Ár</th>
                                            <th scope="col">Akciós ár</th>
                                            <th scope="col">Akció</th>
                                            <th scope="col">Profit</th>
                                            <th scope="col">Elkészítési idő</th>
                                            @if($day == 1)
                                                <th style="background: #c3efd7;" scope="col">Hétfő</th>
                                            @else
                                                <th scope="col">Hétfő</th>
                                            @endif

                                            @if($day == 2)
                                                <th style="background: #c3efd7;" scope="col">Kedd</th>
                                            @else
                                                <th scope="col">Kedd</th>
                                            @endif

                                            @if($day == 3)
                                                <th style="background: #c3efd7;" scope="col">Szerda</th>
                                            @else
                                                <th scope="col">Szerda</th>
                                            @endif

                                            @if($day == 4)
                                                <th style="background: #c3efd7;" scope="col">Csütörtök</th>
                                            @else
                                                <th scope="col">Csütörtök</th>
                                            @endif

                                            @if($day == 5)
                                                <th style="background: #c3efd7;" scope="col">Péntek</th>
                                            @else
                                                <th scope="col">Péntek</th>
                                            @endif

                                            @if($day == 6)
                                                <th style="background: #c3efd7;" scope="col">Szombat</th>
                                            @else
                                                <th scope="col">Szombat</th>
                                            @endif

                                            @if($day == 7)
                                                <th style="background: #c3efd7;" scope="col">Vasárnap</th>
                                            @else
                                                <th scope="col">Vasárnap</th>
                                            @endif
                                            <th scope="col">Szerkesztés</th>
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
                                            <td><img src="images/drinks/{{$data->picid}}.jpg" width="100%" height="auto" style="border-radius: 0.5rem;"></td>
                                            <td><b>{{$data->name}}</b></td>
                                            <td>{{number_format($data->price, 0)}} Ft</td>
                                            @php
                                                $p1 = $data->saleprice - $data->makeprice;
                                                $p2 = $data->price - $data->makeprice;
                                            @endphp
                                            <td>{{number_format($data->saleprice, 0)}} Ft</td>

                                            @if($data->sale)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif
                                            
                                            @if($data->sale)
                                            <td>{{number_format($p1, 0)}} Ft</td>
                                            @else
                                            <td>{{number_format($p2, 0)}} Ft</td>
                                            @endif
                                            <td>{{$data->maketime}} perc</td>

                                            @if($data->monday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->tuesday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->wednesday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->thirsday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->friday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->saturday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            @if($data->sunday)
                                            <td><i class="fa fa-check"></i></td>
                                            @else
                                            <td><i class="fa fa-close"></i></td>
                                            @endif

                                            <td><a href="edit-drink/{{$data->id}}" class="btn btn-icon btn-outline-primary mr-1 mb-1 waves-effect waves-light"><i class="feather icon-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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