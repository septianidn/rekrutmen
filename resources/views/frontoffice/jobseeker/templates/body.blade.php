

    <x-front-office-layout :assets="$assets ?? []">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

   

    <!-- Start Header Area -->
    
    <!-- End Header Area -->

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                        <p>@yield('page-subtitle', 'Kelola profil dan lamaran Anda di Pusat Karir.')</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('jobseeker.index') }}">Beranda</a></li>
                        <li>@yield('page-title', 'Dashboard')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Main Content Start -->
    <div class="manage-jobs section">
        <div class="container">
            <div class="alerts-inner">
                <div class="row">
                    <!-- Start Main Content -->
                    <div class="col-lg-3 col-12">
                        @include('frontoffice.jobseeker.templates.sidebar')
                    </div>
                    <!-- End Main Content -->
                    <div class="col-lg-9 col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content end -->

    {{-- Modal login & daftar (partial bersama) --}}
    @include('partials.frontoffice._auth_modals')

    <!-- Start Footer Area -->
    
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    @stack('scripts')
    </x-front-office-layout>
