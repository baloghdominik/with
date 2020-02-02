@extends('layouts/contentLayoutMaster')

@section('title', 'Add Drink')

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
                                    <h4 class="card-title">Új ital felvétele</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="/withadmin/public/add-side"  enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    @csrf 
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital fotója</span>
                                                            </div>
                                                            <div class="col-md-8">
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
                                                                <span>Ital neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="food-name" class="form-control" name="name" placeholder="Köret megnevezése">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital fogyasztói ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="price" placeholder="Köret eladási ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital akciós ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="saleprice" placeholder="Köret kedvezményes ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Akció bekapcsolása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                            <div class="custom-control custom-switch custom-control-inline">
                                                                <input type="checkbox" name="sale" value="0" class="custom-control-input" id="customSwitch1">
                                                                <label class="custom-control-label" for="customSwitch1">
                                                                </label>
                                                                <span class="switch-label">Akció állapota</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital beszerzési ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="makeprice" placeholder="Köret elkszítési költsége">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital árrése</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>~0 ft</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital elérhetősége</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="monday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Hétfő</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="tuesday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Kedd</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="wednesday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Szerda</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="thirsday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Csütörtök</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="friday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Péntek</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="saturday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Szombat</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="sunday" value="1" checked="">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                                <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                        </span>
                                                                        <span class="">Vasárnap</span>
                                                                </div>
                                                             </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital mérete (ml)</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" id="drink-name" class="form-control" name="size" placeholder="Ital mérete mililiterben">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital specifikációi</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="lactosefree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az ital laktóz mentes</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sugarfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az ital cukor mentes</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="alcoholfree" value="0">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az ital alkohol mentes</span>
                                                                        </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Ital kalóriatartalma</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <select class="form-control" name="calorie" id="basicSelect">
                                                                                <option value="NULL">Nincs megadva</option>
                                                                                <option value="0-200">0-200 Kalória</option>
                                                                                <option value="200-400">200-400 Kalória</option>
                                                                                <option value="400-600">400-600 Kalória</option>
                                                                                <option value="600-800">600-800 Kalória</option>
                                                                                <option value="800-1000">800-1000 Kalória</option>
                                                                                <option value="1000-1200">1000-1200 Kalória</option>
                                                                                <option value="1200-1400">1200-1400 Kalória</option>
                                                                                <option value="1400-1600">1400-1600 Kalória</option>
                                                                                <option value="1600-1800">1600-1800 Kalória</option>
                                                                                <option value="1800-2000">1800-2000 Kalória</option>
                                                                                <option value="2000+">2000+ Kalória</option>
                                                                        </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Mentés</button>
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