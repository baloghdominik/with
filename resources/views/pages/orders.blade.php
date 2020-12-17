@extends('layouts/contentLayoutMaster')

@section('title', 'Orders')

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
    </div>

        <div class="row">

            @php
            $n = 0;
            $s = 0;
            @endphp

            @foreach ($orders as $order)
            @php
            $n++;
            $s++;
            @endphp
            <div class="col-12 ">
                <div class="card ecommerce-card">
                    <div class="card-body" style="padding: 0px;">
                        <div class="row" style="margin: 0px;">

                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="t{{ $s }}" style="padding: 0px;" >

                                @if (count($order->ordermeal) > 0 || count($order->orderside) > 0 || count($order->orderdrink) > 0 || count($order->ordermenu) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus 1</th>
                                            <th scope="col">Étel</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Extrák</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($order->ordermeal) && count($order->ordermeal) > 0)
                                            @foreach ($order->ordermeal as $meals)
                                            @php
                                            $subtotal = $meals->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Étel</span></div></td>
                                                <td>{{ $meals->name }}</td>
                                                <td>{{ $meals->quantity }} adag</td>
                                                <td>
                                                    @foreach ($meals->ordermealextras as $extra)
                                                    @php
                                                    $subtotal = $subtotal + $extra->price
                                                    @endphp
                                                        +{{ $extra->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderside) > 0)
                                            @foreach ($order->orderside as $sides)
                                            @php
                                            $subtotal = $sides->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Köret</span></div></td>
                                                <td>{{ $sides->name }}</td>
                                                <td>{{ $sides->quantity }} adag</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderdrink) > 0)
                                            @foreach ($order->orderdrink as $drinks)
                                            @php
                                            $subtotal = $drinks->price;
                                            @endphp
                                            <tr>
                                            <td><div class="badge badge-secondary"><span>Ital</span></div></td>
                                                <td>{{ $drinks->name }}({{ $drinks->drink->size }}ml)</td>
                                                <td>{{ $drinks->quantity }} darab</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->ordermenu) > 0)
                                            @foreach ($order->ordermenu as $menus)
                                            @php
                                            $subtotal = $menus->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Menü</span></div></td>
                                                <td>{{ $menus->menu_name }} + {{ $menus->side_name }} + {{ $menus->drink_name }}</td>
                                                <td>{{ $menus->quantity }} adag</td>
                                                <td>
                                                    @foreach ($menus->ordermenuextras as $extras)
                                                    @php
                                                    $subtotal = $subtotal + $extras->price
                                                    @endphp
                                                        +{{ $extras->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                </table>
                                @endif

                                @if (count($order->orderpizza) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus</th>
                                            <th scope="col">Méret</th>
                                            <th scope="col">Tészta</th>
                                            <th scope="col">Alap</th>
                                            <th scope="col">Feltétek</th>
                                            <th scope="col">Szószok</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->orderpizza as $pizzas)
                                        @php
                                        $subtotal = $pizzas->price;
                                        @endphp
                                        <tr>
                                            <td><div class="badge badge-secondary"><span>Pizza</span></div></td>
                                            <td>{{ $pizzas->size_name }}</td>
                                            <td>{{ $pizzas->dough_name }}</td>
                                            <td>{{ $pizzas->base_name }}</td>
                                            <td>
                                                @foreach ($pizzas->toppings as $topping)
                                                @php
                                                $subtotal = $subtotal + $topping->price
                                                @endphp
                                                    {{ $topping->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($pizzas->sauces as $sauce)
                                                @php
                                                $subtotal = $subtotal + $sauce->price
                                                @endphp
                                                    {{ $sauce->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>{{ $pizzas->quantity }} darab</td>
                                            <td>{{ $subtotal }} Ft</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @endif

                                @if ($order->is_delivery == 1)
                                <div style="padding: 14px; color: #626262; font-size: 1rem; font-weight: 400p; text-align: center;">Házhozszállítás: {{ $order->delivery_price }} Ft</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                    @php 
                                    $x = 0;
                                    @endphp
                                    @foreach($order->customer->orders as $customer_order)
                                        @if($customer_order->restaurant_id == $order->restaurant_id) 
                                            @php
                                            $x++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @if ($x > 0)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="{{ $order->customer->firstname }} már {{ $x }} alkalommal rendelt önöktől!" data-trigger="hover" data-original-title="Visszatérő vendég!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle"></i>
                                    <span>Visszatérő vendég</span>
                                </div>
                                @elseif (count($order->customer->orders) < 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Új felhasználó</span>
                                </div>
                                @elseif (count($order->customer->orders) >= 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése önöktől!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>Új vendég</span>
                                </div>
                                @endif
                                <p><i class="fa fa-user" ></i> <b>{{ $order->customer->lastname }} {{ $order->customer->firstname }}</b></p>
                                <p><i class="fa fa-phone" ></i> {{ $order->customer->phone }}</p>
                                <p><i class="fa fa-envelope" ></i> {{ $order->customer->email }}</p>
                                <p><i class="fa fa-address-card" ></i> {{ $order->customer->zipcode }} {{ $order->customer->city }} {{ $order->customer->address }}</p>
                                @if (strlen($order->comment) > 2)
                                <p><i class="fas fa-comment" ></i> {{ $order->comment }}</p>
                                @endif
                                @if (isset($order->invoice))
                                <div class="invoice-alert">
                                <p><i class="fas fa-receipt" ></i> <b>Áfás számla igényelve!</b><br>
                                <b>Típus:</b> 
                                @if($order->invoice->invoice_is_company)
                                Cég
                                @else
                                Magánszemély
                                @endif
                                <b>Név:</b> {{ $order->invoice->invoice_name }} <b>Cím:</b> {{ $order->invoice->zipcode }} {{ $order->invoice->invoice_city }} {{ $order->invoice->invoice_address }} <b>Adószám:</b> {{ $order->invoice->invoice_tax_number }} </p>
                                </div>
                                @else
                                <p><i class="fas fa-receipt" ></i> Nem lett számla igényelve.</p>
                                @endif
                                <p><i class="fa fa-clock" ></i> {{ $order->created_at }}</p>
                                @if ($order->pickuptime != NULL && $order->is_delivery == 0)
                                <p><i class="fa fa-calendar" ></i> Várható átvétel: {{ $order->pickuptime }}</p>
                                @endif
                                @if ($order->is_refund == 0)
                                <p><i class="fa fa-trash" ></i> <a class="order-decline decline{{ $n }}">Rendelés elutasítása</a></p>
                                @else
                                    <style>
                                        #t{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-top-left-radius: 0.5rem;
                                        }
                                        #b{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-bottom-left-radius: 0.5rem;
                                        }
                                    </style>
                                @endif
                                    @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-credit-card"></i>
                                        <span style="padding-top:5px;">Visszautalásra vár</span>
                                    </div>
                                    @elseif ($order->is_refund_finished == 1)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-briefcase"></i>
                                        <span style="padding-top:5px;">Elutasítva!</span>
                                    </div>
                                    @elseif ($order->is_accepted == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-hourglass-o"></i>
                                        <span style="padding-top:5px;">Felvételre vár!</span>
                                    </div>
                                    @elseif ($order->is_done == 0)
                                    <div class="badge badge-warning mr-1 mb-1">
                                        <i class="fa fa-hourglass-start"></i>
                                        <span style="padding-top:5px;">Éppen készül!</span>
                                    </div>
                                    @else
                                        @if ($order->is_delivery == 1)
                                            @if($order->is_out_for_delivery == 0)
                                                <div class="badge badge-warning2 mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Futárra vár!</span>
                                                </div>
                                            @elseif ($order->is_delivered == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-end"></i>
                                                    <span style="padding-top:5px;">Szállítás alatt!</span>
                                                </div>
                                            @elseif ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Kiszállítva!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @else
                                            @if ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Átadásra vár!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                
                                @if ($order->is_finished)
                                    @php
                                        $interval = $order->created_at->diff($order->finished_at);
                                        $t = $interval->format("%H óra %I perc");
                                    @endphp
                                    <p><i class="fa fa-hourglass" ></i> Rendeléstől - Teljesítésig eltelt idő: {{ $t }}</p>
                                @endif
                                <p><i class="fa fa-circle" ></i> Azonosító: {{ $order->identifier }}</p>
                                <div id="warn{{ $n }}" style="display:none;">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">Figyelem!</h4>
                                        <p class="mb-0">
                                            Az előre fizetett rendeléseknél a pénzvisszatérítést manuálisan kell végrehajtani! Az elutasítás előtt ajánljuk a telefonos kapcsolatfelvételt a vásárlóval.<br><br>Utánvét esetén a vásárló email értesítést kap a rendelése elutasításáról, így nincs további teendő.<br><br>
                                            @if ($order->is_paid == 1)
                                                @php 
                                                $cancel_url = 'startrefund-order/'.$order->id;
                                                @endphp
                                            @else
                                                @php 
                                                $cancel_url = 'cancel-order/'.$order->id;
                                                @endphp
                                            @endif
                                            <a href="{{ url($cancel_url) }}" class="btn btn-danger btn-sm btn-block waves-effect waves-light">Rendelés elutasítása</a>
                                            <a style="color: #000;" class="btn btn-secondary btn-sm btn-block waves-effect waves-light cancel-decline{{ $n }}">Mégse</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row border-top-order noborder-sm" style="margin: 0px;">
                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="b{{ $s }}" style="padding: 0px;">
                                <div class="row" style="margin: 0px 0px 0px 0px;">
                                    <div class="col-md-6 col-sm-12">
                                        @if ($order->is_delivery == 1)
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Házhozszállítás</span>
                                        </div>
                                        @else
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Helyszíni átvétel</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>{{ $order->paying_method }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 14px; font-size: 12px; text-align: center; font-weight: 800;">Végösszeg: {{ $order->total_price }} Ft</div>
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                @if ($order->is_accepted == 0 && $order->is_refund == 0)
                                    @if ($order->is_delivery == 1)
                                        @php 
                                        $url = 'accept-order/'.$order->id;
                                        @endphp
                                        <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés felvétel</a>
                                    @else
                                        <form method="post" action="{{ url('accept-pickup-order') }}"  enctype="multipart/form-data">
                                        @csrf
                                        <input name="order_id" value="{{ $order->id}}" hidden />
                                        <fieldset class="form-group">
                                                    <select name="pickuptime" required class="form-control">
                                                        <option value="" selected disabled>Válasszon időpontot a helyszíni átvételhez!</option>
                                                        <option value="5">5 perc múlva</option>
                                                        <option value="10">10 perc múlva</option>
                                                        <option value="15">15 perc múlva</option>
                                                        <option value="20">20 perc múlva</option>
                                                        <option value="25">25 perc múlva</option>
                                                        <option value="30">30 perc múlva</option>
                                                        <option value="35">35 perc múlva</option>
                                                        <option value="40">40 perc múlva</option>
                                                        <option value="45">45 perc múlva</option>
                                                        <option value="50">50 perc múlva</option>
                                                        <option value="55">55 perc múlva</option>
                                                        <option value="60">1 óra múlva</option>
                                                        <option value="65">1 óra 5 perc múlva</option>
                                                        <option value="70">1 óra 10 perc múlva</option>
                                                        <option value="75">1 óra 15 perc múlva</option>
                                                        <option value="80">1 óra 20 perc múlva</option>
                                                        <option value="85">1 óra 25 perc múlva</option>
                                                        <option value="90">1 óra 30 perc múlva</option>
                                                        <option value="95">1 óra 35 perc múlva</option>
                                                        <option value="100">1 óra 40 perc múlva</option>
                                                        <option value="105">1 óra 45 perc múlva</option>
                                                        <option value="110">1 óra 50 perc múlva</option>
                                                        <option value="115">1 óra 55 perc múlva</option>
                                                        <option value="120">2 óra múlva</option>
                                                        <option value="125">2 óra 5 perc múlva</option>
                                                        <option value="130">2 óra 10 perc múlva</option>
                                                        <option value="135">2 óra 15 perc múlva</option>
                                                        <option value="140">2 óra 20 perc múlva</option>
                                                        <option value="145">2 óra 25 perc múlva</option>
                                                        <option value="150">2 óra 30 perc múlva</option>
                                                        <option value="155">2 óra 35 perc múlva</option>
                                                        <option value="160">2 óra 40 perc múlva</option>
                                                        <option value="165">2 óra 45 perc múlva</option>
                                                        <option value="170">2 óra 50 perc múlva</option>
                                                        <option value="175">2 óra 55 perc múlva</option>
                                                        <option value="180">3 óra múlva</option>
                                                    </select>
                                                </fieldset>
                                        <button type="submit" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés felvétel</button>
                                        </form>
                                    @endif
                                @elseif ($order->is_done == 0 && $order->is_refund == 0)
                                    @php 
                                    $url = 'done-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés elkészült</a>
                                @else
                                    @if ($order->is_delivery == 1)
                                        @if($order->is_out_for_delivery == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'outfordelivery-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Átadva a futárnak</a>
                                        @elseif ($order->is_delivered == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'delivered-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Kiszállítva, Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @else
                                        @if ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @endif
                                @endif

                                @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    @php 
                                    $url = 'finishrefund-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-danger waves-effect waves-light" style="margin-top: 0px;">Lezárás</a>
                                @elseif ($order->is_refund == 1 && $order->is_refund_finished == 1)
                                    <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Lezárva</div>

                                    <style>
                                        .order-{{ $n }} {
                                            opacity: 0.6;
                                        }
                                    </style>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $(".decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").show();
                });

                $(".cancel-decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").hide();
                });

            });
            </script>
            @endforeach

        </div>

        <div class="row">   

            @foreach ($acceptedorders as $order)
            @php
            $n++;
            $s++;
            @endphp
            <div class="col-12 ">
                <div class="card ecommerce-card">
                    <div class="card-body" style="padding: 0px;">
                        <div class="row" style="margin: 0px;">

                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="t{{ $s }}" style="padding: 0px;" >

                                @if (count($order->ordermeal) > 0 || count($order->orderside) > 0 || count($order->orderdrink) > 0 || count($order->ordermenu) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus 1</th>
                                            <th scope="col">Étel</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Extrák</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($order->ordermeal) && count($order->ordermeal) > 0)
                                            @foreach ($order->ordermeal as $meals)
                                            @php
                                            $subtotal = $meals->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Étel</span></div></td>
                                                <td>{{ $meals->name }}</td>
                                                <td>{{ $meals->quantity }} adag</td>
                                                <td>
                                                    @foreach ($meals->ordermealextras as $extra)
                                                    @php
                                                    $subtotal = $subtotal + $extra->price
                                                    @endphp
                                                        +{{ $extra->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderside) > 0)
                                            @foreach ($order->orderside as $sides)
                                            @php
                                            $subtotal = $sides->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Köret</span></div></td>
                                                <td>{{ $sides->name }}</td>
                                                <td>{{ $sides->quantity }} adag</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderdrink) > 0)
                                            @foreach ($order->orderdrink as $drinks)
                                            @php
                                            $subtotal = $drinks->price;
                                            @endphp
                                            <tr>
                                            <td><div class="badge badge-secondary"><span>Ital</span></div></td>
                                                <td>{{ $drinks->name }}({{ $drinks->drink->size }}ml)</td>
                                                <td>{{ $drinks->quantity }} darab</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->ordermenu) > 0)
                                            @foreach ($order->ordermenu as $menus)
                                            @php
                                            $subtotal = $menus->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Menü</span></div></td>
                                                <td>{{ $menus->menu_name }} + {{ $menus->side_name }} + {{ $menus->drink_name }}</td>
                                                <td>{{ $menus->quantity }} adag</td>
                                                <td>
                                                    @foreach ($menus->ordermenuextras as $extras)
                                                    @php
                                                    $subtotal = $subtotal + $extras->price
                                                    @endphp
                                                        +{{ $extras->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                </table>
                                @endif

                                @if (count($order->orderpizza) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus</th>
                                            <th scope="col">Méret</th>
                                            <th scope="col">Tészta</th>
                                            <th scope="col">Alap</th>
                                            <th scope="col">Feltétek</th>
                                            <th scope="col">Szószok</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->orderpizza as $pizzas)
                                        @php
                                        $subtotal = $pizzas->price;
                                        @endphp
                                        <tr>
                                            <td><div class="badge badge-secondary"><span>Pizza</span></div></td>
                                            <td>{{ $pizzas->size_name }}</td>
                                            <td>{{ $pizzas->dough_name }}</td>
                                            <td>{{ $pizzas->base_name }}</td>
                                            <td>
                                                @foreach ($pizzas->toppings as $topping)
                                                @php
                                                $subtotal = $subtotal + $topping->price
                                                @endphp
                                                    {{ $topping->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($pizzas->sauces as $sauce)
                                                @php
                                                $subtotal = $subtotal + $sauce->price
                                                @endphp
                                                    {{ $sauce->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>{{ $pizzas->quantity }} darab</td>
                                            <td>{{ $subtotal }} Ft</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @endif

                                @if ($order->is_delivery == 1)
                                <div style="padding: 14px; color: #626262; font-size: 1rem; font-weight: 400p; text-align: center;">Házhozszállítás: {{ $order->delivery_price }} Ft</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                    @php 
                                    $x = 0;
                                    @endphp
                                    @foreach($order->customer->orders as $customer_order)
                                        @if($customer_order->restaurant_id == $order->restaurant_id) 
                                            @php
                                            $x++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @if ($x > 0)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="{{ $order->customer->firstname }} már {{ $x }} alkalommal rendelt önöktől!" data-trigger="hover" data-original-title="Visszatérő vendég!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle"></i>
                                    <span>Visszatérő vendég</span>
                                </div>
                                @elseif (count($order->customer->orders) < 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Új felhasználó</span>
                                </div>
                                @elseif (count($order->customer->orders) >= 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése önöktől!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>Új vendég</span>
                                </div>
                                @endif
                                <p><i class="fa fa-user" ></i> <b>{{ $order->customer->lastname }} {{ $order->customer->firstname }}</b></p>
                                <p><i class="fa fa-phone" ></i> {{ $order->customer->phone }}</p>
                                <p><i class="fa fa-envelope" ></i> {{ $order->customer->email }}</p>
                                <p><i class="fa fa-address-card" ></i> {{ $order->customer->zipcode }} {{ $order->customer->city }} {{ $order->customer->address }}</p>
                                @if (strlen($order->comment) > 2)
                                <p><i class="fas fa-comment" ></i> {{ $order->comment }}</p>
                                @endif
                                @if (isset($order->invoice))
                                <div class="invoice-alert">
                                <p><i class="fas fa-receipt" ></i> <b>Áfás számla igényelve!</b><br>
                                <b>Típus:</b> 
                                @if($order->invoice->invoice_is_company)
                                Cég
                                @else
                                Magánszemély
                                @endif
                                <b>Név:</b> {{ $order->invoice->invoice_name }} <b>Cím:</b> {{ $order->invoice->zipcode }} {{ $order->invoice->invoice_city }} {{ $order->invoice->invoice_address }} <b>Adószám:</b> {{ $order->invoice->invoice_tax_number }} </p>
                                </div>
                                @else
                                <p><i class="fas fa-receipt" ></i> Nem lett számla igényelve.</p>
                                @endif
                                <p><i class="fa fa-clock" ></i> {{ $order->created_at }}</p>
                                @if ($order->pickuptime != NULL && $order->is_delivery == 0)
                                <p><i class="fa fa-calendar" ></i> Várható átvétel: {{ $order->pickuptime }}</p>
                                @endif
                                @if ($order->is_refund == 0)
                                <p><i class="fa fa-trash" ></i> <a class="order-decline decline{{ $n }}">Rendelés elutasítása</a></p>
                                @else
                                    <style>
                                        #t{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-top-left-radius: 0.5rem;
                                        }
                                        #b{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-bottom-left-radius: 0.5rem;
                                        }
                                    </style>
                                @endif
                                    @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-credit-card"></i>
                                        <span style="padding-top:5px;">Visszautalásra vár</span>
                                    </div>
                                    @elseif ($order->is_refund_finished == 1)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-briefcase"></i>
                                        <span style="padding-top:5px;">Elutasítva!</span>
                                    </div>
                                    @elseif ($order->is_accepted == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-hourglass-o"></i>
                                        <span style="padding-top:5px;">Felvételre vár!</span>
                                    </div>
                                    @elseif ($order->is_done == 0)
                                    <div class="badge badge-warning mr-1 mb-1">
                                        <i class="fa fa-hourglass-start"></i>
                                        <span style="padding-top:5px;">Éppen készül!</span>
                                    </div>
                                    @else
                                        @if ($order->is_delivery == 1)
                                            @if($order->is_out_for_delivery == 0)
                                                <div class="badge badge-warning2 mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Futárra vár!</span>
                                                </div>
                                            @elseif ($order->is_delivered == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-end"></i>
                                                    <span style="padding-top:5px;">Szállítás alatt!</span>
                                                </div>
                                            @elseif ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Kiszállítva!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @else
                                            @if ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Átadásra vár!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                
                                @if ($order->is_finished)
                                    @php
                                        $interval = $order->created_at->diff($order->finished_at);
                                        $t = $interval->format("%H óra %I perc");
                                    @endphp
                                    <p><i class="fa fa-hourglass" ></i> Rendeléstől - Teljesítésig eltelt idő: {{ $t }}</p>
                                @endif
                                    <p><i class="fa fa-circle" ></i> Azonosító: {{ $order->identifier }}</p>
                                <div id="warn{{ $n }}" style="display:none;">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">Figyelem!</h4>
                                        <p class="mb-0">
                                            Az előre fizetett rendeléseknél a pénzvisszatérítést manuálisan kell végrehajtani! Az elutasítás előtt ajánljuk a telefonos kapcsolatfelvételt a vásárlóval.<br><br>Utánvét esetén a vásárló email értesítést kap a rendelése elutasításáról, így nincs további teendő.<br><br>
                                            @if ($order->is_paid == 1)
                                                @php 
                                                $cancel_url = 'startrefund-order/'.$order->id;
                                                @endphp
                                            @else
                                                @php 
                                                $cancel_url = 'cancel-order/'.$order->id;
                                                @endphp
                                            @endif
                                            <a href="{{ url($cancel_url) }}" class="btn btn-danger btn-sm btn-block waves-effect waves-light">Rendelés elutasítása</a>
                                            <a style="color: #000;" class="btn btn-secondary btn-sm btn-block waves-effect waves-light cancel-decline{{ $n }}">Mégse</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row border-top-order noborder-sm" style="margin: 0px;">
                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="b{{ $s }}" style="padding: 0px;">
                                <div class="row" style="margin: 0px 0px 0px 0px;">
                                    <div class="col-md-6 col-sm-12">
                                        @if ($order->is_delivery == 1)
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Házhozszállítás</span>
                                        </div>
                                        @else
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Helyszíni átvétel</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>{{ $order->paying_method }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 14px; font-size: 12px; text-align: center; font-weight: 800;">Végösszeg: {{ $order->total_price }} Ft</div>
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                @if ($order->is_accepted == 0 && $order->is_refund == 0)
                                    @php 
                                    $url = 'accept-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés felvétel</a>
                                @elseif ($order->is_done == 0 && $order->is_refund == 0)
                                    @php 
                                    $url = 'done-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés elkészült</a>
                                @else
                                    @if ($order->is_delivery == 1)
                                        @if($order->is_out_for_delivery == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'outfordelivery-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Átadva a futárnak</a>
                                        @elseif ($order->is_delivered == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'delivered-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Kiszállítva, Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @else
                                        @if ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @endif
                                @endif

                                @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    @php 
                                    $url = 'finishrefund-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-danger waves-effect waves-light" style="margin-top: 0px;">Lezárás</a>
                                @elseif ($order->is_refund == 1 && $order->is_refund_finished == 1)
                                    <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Lezárva</div>

                                    <style>
                                        .order-{{ $n }} {
                                            opacity: 0.6;
                                        }
                                    </style>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $(".decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").show();
                });

                $(".cancel-decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").hide();
                });

            });
            </script>
            @endforeach

        </div>

        <div class="row">

            @foreach ($finishedorders as $order)
            @php
            $n++;
            $s++;
            @endphp
            <div class="col-12 ">
                <div class="card ecommerce-card" style="opacity: 0.5;">
                    <div class="card-body" style="padding: 0px;">
                        <div class="row" style="margin: 0px;">

                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="t{{ $s }}" style="padding: 0px;" >

                                @if (count($order->ordermeal) > 0 || count($order->orderside) > 0 || count($order->orderdrink) > 0 || count($order->ordermenu) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus 1</th>
                                            <th scope="col">Étel</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Extrák</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($order->ordermeal) && count($order->ordermeal) > 0)
                                            @foreach ($order->ordermeal as $meals)
                                            @php
                                            $subtotal = $meals->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Étel</span></div></td>
                                                <td>{{ $meals->name }}</td>
                                                <td>{{ $meals->quantity }} adag</td>
                                                <td>
                                                    @foreach ($meals->ordermealextras as $extra)
                                                    @php
                                                    $subtotal = $subtotal + $extra->price
                                                    @endphp
                                                        +{{ $extra->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderside) > 0)
                                            @foreach ($order->orderside as $sides)
                                            @php
                                            $subtotal = $sides->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Köret</span></div></td>
                                                <td>{{ $sides->name }}</td>
                                                <td>{{ $sides->quantity }} adag</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->orderdrink) > 0)
                                            @foreach ($order->orderdrink as $drinks)
                                            @php
                                            $subtotal = $drinks->price;
                                            @endphp
                                            <tr>
                                            <td><div class="badge badge-secondary"><span>Ital</span></div></td>
                                                <td>{{ $drinks->name }}({{ $drinks->drink->size }}ml)</td>
                                                <td>{{ $drinks->quantity }} darab</td>
                                                <td></td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                        @if (count($order->ordermenu) > 0)
                                            @foreach ($order->ordermenu as $menus)
                                            @php
                                            $subtotal = $menus->price;
                                            @endphp
                                            <tr>
                                                <td><div class="badge badge-secondary"><span>Menü</span></div></td>
                                                <td>{{ $menus->menu_name }} + {{ $menus->side_name }} + {{ $menus->drink_name }}</td>
                                                <td>{{ $menus->quantity }} adag</td>
                                                <td>
                                                    @foreach ($menus->ordermenuextras as $extras)
                                                    @php
                                                    $subtotal = $subtotal + $extras->price
                                                    @endphp
                                                        +{{ $extras->name }}<br/>
                                                    @endforeach
                                                </td>
                                                <td>{{ $subtotal }} Ft</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                </table>
                                @endif

                                @if (count($order->orderpizza) > 0)
                                <table class="table table-striped mb-0 table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th scope="col">Típus</th>
                                            <th scope="col">Méret</th>
                                            <th scope="col">Tészta</th>
                                            <th scope="col">Alap</th>
                                            <th scope="col">Feltétek</th>
                                            <th scope="col">Szószok</th>
                                            <th scope="col">Darab</th>
                                            <th scope="col">Ár</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->orderpizza as $pizzas)
                                        @php
                                        $subtotal = $pizzas->price;
                                        @endphp
                                        <tr>
                                            <td><div class="badge badge-secondary"><span>Pizza</span></div></td>
                                            <td>{{ $pizzas->size_name }}</td>
                                            <td>{{ $pizzas->dough_name }}</td>
                                            <td>{{ $pizzas->base_name }}</td>
                                            <td>
                                                @foreach ($pizzas->toppings as $topping)
                                                @php
                                                $subtotal = $subtotal + $topping->price
                                                @endphp
                                                    {{ $topping->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($pizzas->sauces as $sauce)
                                                @php
                                                $subtotal = $subtotal + $sauce->price
                                                @endphp
                                                    {{ $sauce->name }}<br/>
                                                @endforeach
                                            </td>
                                            <td>{{ $pizzas->quantity }} darab</td>
                                            <td>{{ $subtotal }} Ft</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @endif

                                @if ($order->is_delivery == 1)
                                <div style="padding: 14px; color: #626262; font-size: 1rem; font-weight: 400p; text-align: center;">Házhozszállítás: {{ $order->delivery_price }} Ft</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                    @php 
                                    $x = 0;
                                    @endphp
                                    @foreach($order->customer->orders as $customer_order)
                                        @if($customer_order->restaurant_id == $order->restaurant_id) 
                                            @php
                                            $x++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @if ($x > 0)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="{{ $order->customer->firstname }} már {{ $x }} alkalommal rendelt önöktől!" data-trigger="hover" data-original-title="Visszatérő vendég!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle"></i>
                                    <span>Visszatérő vendég</span>
                                </div>
                                @elseif (count($order->customer->orders) < 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Új felhasználó</span>
                                </div>
                                @elseif (count($order->customer->orders) >= 1)
                                <div class="badge badge-primary mb-1" data-toggle="popover" data-content="Ez {{ $order->customer->firstname }} első rendelése önöktől!" data-trigger="hover" data-original-title="Új felhasználó!" data-placement="top" style="cursor: pointer; float: right;">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>Új vendég</span>
                                </div>
                                @endif
                                <p><i class="fa fa-user" ></i> <b>{{ $order->customer->lastname }} {{ $order->customer->firstname }}</b></p>
                                <p><i class="fa fa-phone" ></i> {{ $order->customer->phone }}</p>
                                <p><i class="fa fa-envelope" ></i> {{ $order->customer->email }}</p>
                                <p><i class="fa fa-address-card" ></i> {{ $order->customer->zipcode }} {{ $order->customer->city }} {{ $order->customer->address }}</p>
                                @if (strlen($order->comment) > 2)
                                <p><i class="fas fa-comment" ></i> {{ $order->comment }}</p>
                                @endif
                                @if (isset($order->invoice))
                                <div class="invoice-alert-post">
                                <p><i class="fas fa-receipt" ></i> <b>Áfás számla igényelve!</b><br>
                                <b>Típus:</b> 
                                @if($order->invoice->invoice_is_company)
                                Cég
                                @else
                                Magánszemély
                                @endif
                                <b>Név:</b> {{ $order->invoice->invoice_name }} <b>Cím:</b> {{ $order->invoice->zipcode }} {{ $order->invoice->invoice_city }} {{ $order->invoice->invoice_address }} <b>Adószám:</b> {{ $order->invoice->invoice_tax_number }} </p>
                                </div>
                                @else
                                <p><i class="fas fa-receipt" ></i> Nem lett számla igényelve.</p>
                                @endif
                                <p><i class="fa fa-clock" ></i> {{ $order->created_at }}</p>
                                @if ($order->pickuptime != NULL && $order->is_delivery == 0)
                                <p><i class="fa fa-calendar" ></i> Várható átvétel: {{ $order->pickuptime }}</p>
                                @endif
                                @if ($order->is_refund == 0)
                                <p><i class="fa fa-trash" ></i> <a class="order-decline decline{{ $n }}">Rendelés elutasítása</a></p>
                                @else
                                    <style>
                                        #t{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-top-left-radius: 0.5rem;
                                        }
                                        #b{{ $s }} {
                                            border-left: 5px solid #ea5455;
                                            border-bottom-left-radius: 0.5rem;
                                        }
                                    </style>
                                @endif
                                    @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-credit-card"></i>
                                        <span style="padding-top:5px;">Visszautalásra vár</span>
                                    </div>
                                    @elseif ($order->is_refund_finished == 1)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-briefcase"></i>
                                        <span style="padding-top:5px;">Elutasítva!</span>
                                    </div>
                                    @elseif ($order->is_accepted == 0)
                                    <div class="badge badge-danger mr-1 mb-1">
                                        <i class="fa fa-hourglass-o"></i>
                                        <span style="padding-top:5px;">Felvételre vár!</span>
                                    </div>
                                    @elseif ($order->is_done == 0)
                                    <div class="badge badge-warning mr-1 mb-1">
                                        <i class="fa fa-hourglass-start"></i>
                                        <span style="padding-top:5px;">Éppen készül!</span>
                                    </div>
                                    @else
                                        @if ($order->is_delivery == 1)
                                            @if($order->is_out_for_delivery == 0)
                                                <div class="badge badge-warning2 mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Futárra vár!</span>
                                                </div>
                                            @elseif ($order->is_delivered == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-end"></i>
                                                    <span style="padding-top:5px;">Szállítás alatt!</span>
                                                </div>
                                            @elseif ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Kiszállítva!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @else
                                            @if ($order->is_finished == 0)
                                                <div class="badge badge-success mr-1 mb-1">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    <span style="padding-top:5px;">Átadásra vár!</span>
                                                </div>
                                            @elseif ($order->is_finished == 1)
                                                <div class="badge badge-secondary mr-1 mb-1">
                                                    <i class="fa fa-smile-o"></i>
                                                    <span style="padding-top:5px;">Teljesítve!</span>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                
                                @if ($order->is_finished)
                                    @php
                                        $interval = $order->created_at->diff($order->finished_at);
                                        $t = $interval->format("%H óra %I perc");
                                    @endphp
                                    <p><i class="fa fa-hourglass" ></i> Rendeléstől - Teljesítésig eltelt idő: {{ $t }}</p>
                                @endif
                                <p><i class="fa fa-circle" ></i> Azonosító: {{ $order->identifier }}</p>
                                <div id="warn{{ $n }}" style="display:none;">
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">Figyelem!</h4>
                                        <p class="mb-0">
                                            Az előre fizetett rendeléseknél a pénzvisszatérítést manuálisan kell végrehajtani! Az elutasítás előtt ajánljuk a telefonos kapcsolatfelvételt a vásárlóval.<br><br>Utánvét esetén a vásárló email értesítést kap a rendelése elutasításáról, így nincs további teendő.<br><br>
                                            @if ($order->is_paid == 1)
                                                @php 
                                                $cancel_url = 'startrefund-order/'.$order->id;
                                                @endphp
                                            @else
                                                @php 
                                                $cancel_url = 'cancel-order/'.$order->id;
                                                @endphp
                                            @endif
                                            <a href="{{ url($cancel_url) }}" class="btn btn-danger btn-sm btn-block waves-effect waves-light">Rendelés elutasítása</a>
                                            <a style="color: #000;" class="btn btn-secondary btn-sm btn-block waves-effect waves-light cancel-decline{{ $n }}">Mégse</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row border-top-order noborder-sm" style="margin: 0px;">
                            <div class="col-md-8 col-sm-12 border-right-order noborder-sm" id="b{{ $s }}" style="padding: 0px;">
                                <div class="row" style="margin: 0px 0px 0px 0px;">
                                    <div class="col-md-6 col-sm-12">
                                        @if ($order->is_delivery == 1)
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Házhozszállítás</span>
                                        </div>
                                        @else
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>Helyszíni átvétel</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="badge block badge-secondary bg-with-warning" style="font-weight: 600; width: 100%; margin: 8px 0px 7px 0px;">
                                            <span>{{ $order->paying_method }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 14px; font-size: 12px; text-align: center; font-weight: 800;">Végösszeg: {{ $order->total_price }} Ft</div>
                            </div>
                            <div class="col-md-4 col-sm-12"  style="padding: 21px;">
                                @if ($order->is_accepted == 0 && $order->is_refund == 0)
                                    @php 
                                    $url = 'accept-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés felvétel</a>
                                @elseif ($order->is_done == 0 && $order->is_refund == 0)
                                    @php 
                                    $url = 'done-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Rendelés elkészült</a>
                                @else
                                    @if ($order->is_delivery == 1)
                                        @if($order->is_out_for_delivery == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'outfordelivery-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Átadva a futárnak</a>
                                        @elseif ($order->is_delivered == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'delivered-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Kiszállítva, Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @else
                                        @if ($order->is_finished == 0 && $order->is_refund == 0)
                                            @php 
                                            $url = 'finished-order/'.$order->id;
                                            @endphp
                                            <a href="{{ url($url) }}" class="btn btn-block btn-primary waves-effect waves-light" style="margin-top: 0px;">Renelés teljesítve</a>
                                        @elseif ($order->is_finished == 1 && $order->is_refund == 0)
                                        <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Teljesítve</div>

                                            <style>
                                                .order-{{ $n }} {
                                                    opacity: 0.6;
                                                }
                                            </style>
                                        @endif
                                    @endif
                                @endif

                                @if ($order->is_refund == 1 && $order->is_refund_finished == 0)
                                    @php 
                                    $url = 'finishrefund-order/'.$order->id;
                                    @endphp
                                    <a href="{{ url($url) }}" class="btn btn-block btn-danger waves-effect waves-light" style="margin-top: 0px;">Lezárás</a>
                                @elseif ($order->is_refund == 1 && $order->is_refund_finished == 1)
                                    <div style="font-size: 14px; font-weight: 600; padding-top: 9px; padding-bottom: 9px; text-align: center;">Lezárva</div>

                                    <style>
                                        .order-{{ $n }} {
                                            opacity: 0.6;
                                        }
                                    </style>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $(".decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").show();
                });

                $(".cancel-decline{{ $n }}").click(function(){
                    $("#warn{{ $n }}").hide();
                });

            });
            </script>
            @endforeach

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