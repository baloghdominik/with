@if($configData["mainLayoutType"] == 'horizontal')
  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarColor'] }} navbar-fixed">
      <div class="navbar-header d-xl-block d-none">
          <ul class="nav navbar-nav flex-row">
              <li class="nav-item"><a class="navbar-brand" href="{{ url('home') }}">
                  <div class="brand-logo"></div></a></li>
          </ul>
      </div>
  @else
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
  @endif
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="" data-toggle="tooltip" data-placement="top" title="Admin menü"><i class="ficon fas fa-user-cog primary"></i></a></li>
                    </ul>
                    <!--<ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="" data-toggle="tooltip" data-placement="top" title="Futár menü"><i class="ficon fas fa-car-side"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="" data-toggle="tooltip" data-placement="top" title="Séf menü"><i class="ficon fas fa-blender"></i></a></li>
                    </ul>-->
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-hu"></i><span class="selected-language">Magyar</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="hu"><i class="flag-icon flag-icon-hu"></i> Magyar</a></div>
                    </li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>

                    <!--<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">3</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white">5 Új</h3><span class="grey darken-2">Értessítés</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">-->
                                <!-- a(href='javascript:void(0)').d-flex.justify-content-between-->
                                <!--   .d-flex.align-items-start-->
                                <!--       i.feather.icon-plus-square-->
                                <!--       .mx-1-->
                                <!--         .font-medium.block.notification-title New Message-->
                                <!--         small Are your going to meet me tonight?-->
                                <!--   small 62 Days ago-->
                                <!--<a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                                        <div class="media-body">
                                            <h6 class="primary media-heading">Új rendelés!</h6><small class="notification-text"> Tekintse meg a rendelést!</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">2 perce</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
                                        <div class="media-body">
                                            <h6 class="success media-heading red darken-1">Új frissítés várható</h6><small class="notification-text">Hamarosan új funkciók érkeznek a MyRestaurant felületre.</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">1 órája</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-alert-triangle font-medium-5 danger"></i></div>
                                        <div class="media-body">
                                            <h6 class="danger media-heading yellow darken-3">Hamarosan lejár az előfizetése!</h6><small class="notification-text">Újítsa meg  WITH előfizetését Január 25-ig!</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Tegnap</time></small>
                                    </div>
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">Értesítések megtekintése</a></li>
                        </ul>
                    </li>-->
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ Auth::user()->name }}</span><span class="user-status">
                            @if(Auth::user()->role == 1)         
                                Admin
                            @elseif(Auth::user()->role == 2)
                                Chef
                            @elseif(Auth::user()->role == 3)
                                Courier
                            @endif
                            </span></div><span><img class="round" src="{{asset('images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="40" width="40" /></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="{{ url('user-settings') }}"><i class="feather icon-user"></i> Profil</a><a class="dropdown-item" href="javascript:void(0)"><i class="feather icon-shopping-cart"></i> Étterem</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="feather icon-power"></i> Kilépés</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- END: Header-->
