
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                {{-- <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="20">
                    </span>
                </a> --}}

                <h6 class="logo logo-light fs-5 text-center text-white m-0">
                    {{-- <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="" width="100%" height="22">

                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo.png')}}" alt="" class="img-fluid p-2" height="24">
                    </span> --}}
                    STOCK
                </h6>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
            {{-- <div class="">
                <h5 class="page-title">
                  <span class="d-md-block d-none ms-2">
                    @yield('title')
                  </span>
                  <span class="d-md-none d-block">
                    stock
                  </span>
                </h5>
            </div> --}}
        </div>


        <div class="d-flex">



            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>



            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user p-1 border border-solid border-success border-1" src="{{asset('assets/images/logo-profil.png')}}"
                        alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profil.show',Auth::user()) }}">
                        <i class="mdi mdi-account-circle-outline font-size-16 align-middle me-2"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('profil.edit',Auth::user()) }}">
                        <i class="mdi mdi-cog-outline font-size-16 align-middle me-2"></i>
                        Préférence
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="dripicons-exit font-size-16 align-middle me-2"></i>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <span>Déconnexion</span>
                    </a>

                </div>
            </div>

        </div>
    </div>
</header>