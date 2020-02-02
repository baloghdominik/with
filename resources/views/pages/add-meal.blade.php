@extends('layouts/contentLayoutMaster')

@section('title', 'Add Meal')

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
                                    <h4 class="card-title">Új étel felvétele</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel fotója</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="custom-file">
                                                                        <input type="file" name="" class="custom-file-input" id="inputGroupFile01">
                                                                        <label class="custom-file-label" for="inputGroupFile01">Válasszon fotót</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel neve</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="food-name" class="form-control" name="" placeholder="Étel megnevezése">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel fogyasztói ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="" placeholder="Étel eladási ára">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel akciós ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="" placeholder="Étel kedvezményes ára">
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
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
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
                                                                <span>Étel elkészítési ára</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="" class="form-control" name="" placeholder="Étel elkszítési költsége">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel árrése</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>~0 ft</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel elérhetősége</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <fieldset>
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                        <input type="checkbox" value="false">
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
                                                                <span>Étel leírása</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                              <fieldset class="form-group">
                                                                <textarea class="form-control" id="basicTextarea" rows="5" placeholder="Étel leírás"></textarea>
                                                              </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel specifikációi</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegán</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Vegetáriánus</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Glutén mentes</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel Laktóz mentes</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott zsírt</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz hozzá adott cukrot</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz étel színezéket</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz tartósítószereket</span>
                                                                        </div>
                                                                </fieldset>
                                                                <fieldset class="form-group">
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" value="false">
                                                                                <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                                </span>
                                                                                <span class="">Ez az étel nem tartalmaz allergén alapanyagokat</span>
                                                                        </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Étel kalóriatartalma</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <fieldset class="form-group">
                                                                        <select class="form-control" id="basicSelect">
                                                                                <option>0-200 Kalória</option>
                                                                                <option>200-400 Kalória</option>
                                                                                <option>400-600 Kalória</option>
                                                                                <option>600-800 Kalória</option>
                                                                                <option>800-1000 Kalória</option>
                                                                                <option>1000-1200 Kalória</option>
                                                                                <option>1200-1400 Kalória</option>
                                                                                <option>1400-1600 Kalória</option>
                                                                                <option>1600-1800 Kalória</option>
                                                                                <option>1800-2000 Kalória</option>
                                                                                <option>2000+ Kalória</option>
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