@php
$variant = getPendingVariant();
$master = getPendingProduct();
@endphp
<div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item d-block m-auto">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img class="brand-logo img-fluid" alt="{{ $settings->SITE_NAME  ?? 'DEMO WEBSITE'}}" title="{{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}" src="{{ asset($settings->LOGIN_LOGO ?? '') }}">
            </a>
        </li>
        <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
        <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
    </ul>
</div>
<div class="navbar-container content">
    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>

          </ul>
        <ul class="nav navbar-nav float-right">
            @if(Auth::user()->F_MERCHANT_NO == 0 )
            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-danger badge-up badge-glow">{{ $master+$variant }}</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6>
                  </li>
                  <li class="scrollable-container media-list w-100 ps" style="top: 0px;">
                      @if($master > 0 )
                      <a href="{{ route('admin.product.pending') }}">
                      <div class="media">
                        <div class="media-left align-self-center">{{ $master }}</div>
                        <div class="media-body">
                          <h6 class="media-heading">Pending Master Index</h6>
                        </div>
                      </div>
                    </a>
                    @endif
                    @if($variant > 0 )
                    <a href="{{ route('admin.varint.pending') }}">
                      <div class="media">
                        <div class="media-left align-self-center">{{ $variant }}</div>
                        <div class="media-body">
                          <h6 class="media-heading red darken-1">Pending Variant</h6>
                        </div>
                      </div>
                    </a>
                    @endif
                  </li>

                </ul>
              </li>
              @endif
            <li class="dropdown dropdown-user nav-item">
                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"> {{ Auth::user()->NAME }}</span><span class="avatar avatar-online">
                    @if(Auth::user()->PROFILE_PIC_URL)
                        <img src="{{ asset(Auth::user()->PROFILE_PIC_URL) }}" alt="{{ Auth::user()->NAME }}">
                    @else
                        <img src="{{  asset('assets/images/avatar.png')  }}" alt="{{ Auth::user()->NAME }}">
                    @endif
                    <i></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.user.loggedin.edit',Auth::user()->PK_NO) }}"><i class="ft-user"></i> Edit Profile</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i class="ft-power"></i>Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
