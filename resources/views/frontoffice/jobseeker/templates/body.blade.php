

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
                        <li><a href="{{ route('jobseeker.index') }}">Home</a></li>
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

    <!-- Login Modal -->
    <div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal"><i class="lni lni-close"></i></button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>Login From Here</h3>
                                <p>Log in to continue your account <br> and explore new jobs.</p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li><a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i> Log in
                                            with LinkedIn</a></li>
                                    <li><a class="google" href="#"><i class="lni lni-google"></i> Log in with
                                            Google</a></li>
                                    <li><a class="facebook" href="#"><i class="lni lni-facebook-original"></i> Log in
                                            with Facebook</a></li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">Remember password</label>
                                    </div>
                                    <a href="" class="font-size-3 text-dodger line-height-reset">Forget Password</a>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn ">Log in
                                    </button>
                                </div>
                                <p class="text-center create-new-account">Don’t have an account? <a href="#">Create a free account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Login Modal -->

    <!-- Signup Modal -->
    <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal"><i class="lni lni-close"></i></button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>Create a free Account <br> Today</h3>
                                <p>Create your account to continue <br> and explore new jobs.</p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li><a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i> Import from LinkedIn</a></li>
                                    <li><a class="google" href="#"><i class="lni lni-google"></i> Import from
                                            Google</a></li>
                                    <li><a class="facebook" href="#"><i class="lni lni-facebook-original"></i> Import from Facebook</a></li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="flexCheckDefault">Agree to the <a
                                                href="#">Terms & Conditions</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn ">Sign Up
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Signup Modal -->

    <!-- Start Footer Area -->
    
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    @stack('scripts')
    </x-front-office-layout>
