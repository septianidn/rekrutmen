<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>CDC Unand</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon"href="{{ asset('images/frontoffice/favicon.png') }}" />
    <!-- Place favicon.ico in the root directory -->
    <title>@yield('title')</title>
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('css/frontoffice/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/frontoffice/main.css') }}">
    <style>
        @media (max-width: 991.98px) {
            .content .bg {
                height: 500px;
            }
        }

        .content .contents,
        .content .bg {
            width: 50%;
        }

        @media (max-width: 1199.98px) {

            .content .contents,
            .content .bg {
                width: 100%;
            }
        }

        .content .bg {
            background-size: cover;
            background-position: center;
        }

        .content a {
            color: #888;
            text-decoration: underline;
        }

        .content .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .content .forgot-pass {
            position: relative;
            top: 2px;
            font-size: 14px;
        }


        .btn {
            background-color: #009A4B;
            color: white;

        }

        .btn:hover {
            background-color: #007538;
            color: white;
        }

        .content .btn {
            height: 48px;
            padding-left: 30px;
            padding-right: 30px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <div id="loading-area"></div>
    <!-- Start Header Area -->
    {{-- TODO : FETCH FROM DB --}}
    <header class="header style4">
        <div class="navbar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand logo" href="/">
                                <img class="logo1" src="{{ asset('images/frontoffice/logo/logo.svg') }}"
                                    alt="Logo CDC Unand">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('landingpage') }}"
                                            class="{{ request()->routeIs('landingpage') ? 'active' : '' }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Karir</a>
                                        <ul class="sub-menu">
                                            <li><a href="@auth @if(auth()->user()->hasRole('employer')){{ route('employer.job.index') }}@elseif(auth()->user()->hasRole('mahasiswa')){{ route('jobseeker.jobs') }}@else{{ route('vacancy') }}@endif @else{{ route('vacancy') }}@endauth">Vacancy</a></li>
                                            <li><a href="#">Test Call</a></li>
                                            <li><a href="#">Article</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href=""
                                            class="">Tracer
                                            Study</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Konseling </a>
                                    </li>
                                    <li class="nav-item">
                                        <a>Publikasi</a>
                                        <ul class="sub-menu">
                                            {{-- <li>
                                                <a href="{{ route('tracerstudy-laporan') }}"
                                                    class="{{ request()->routeIs('tracerstudy-laporan') ? 'active' : '' }}">Laporan
                                                    Tracer Study</a>
                                            </li> --}}
                                            <li><a href="">Laporan Pertanyaan Tracer Study</a></li>
                                            <li>
                                                <a href="#">Dashboard Progress</a>
                                            </li>
                                            <li>
                                                <a href="#">Laporan Pelaksanaan Konseling</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Tentang Kami</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Kontak </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- navbar collapse -->
                            @guest
                            <div class="button">
                                <a href="javacript:" data-toggle="modal" data-target="#login" class="login"><i
                                        class="lni lni-lock-alt"></i> Masuk</a>
                                <a href="javacript:" data-toggle="modal" data-target="#signup" class="btn">Daftar</a>
                            </div>
                            @endguest
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="section content">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <img src="@yield('image')" alt="#" class="img-fluid">
                </div>
                <div class="col-md-6 contents align-self-center">
                    <div class="row justify-content-center">
                        <div class="col-md-8 ">
                            <div class="mb-4">
                                <h2 class="mb-2">@yield('message')</h2>
                                <p class="mb-4">@yield('description')</p>
                            </div>

                            @yield('button')

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>



    <div class="client-logo-section">
        <div class="container">
            <div class="client-logo-wrapper">
                <div class="client-logo-carousel d-flex align-items-center justify-content-between">
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="#"" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="f-about single-footer">
                            <div class="logo">
                                <a href="/"><img src="{{ asset('images/frontoffice/logo/logo.svg') }}"
                                        alt="#" />

                                </a>
                            </div>
                            <p>
                                Start building your creative website with our awesome template
                                Massive.
                            </p>
                            <ul class="contact-address">
                                <li><span>Alamat:</span> UPT Pusat Karir dan Konseling Universitas Andalas</li>
                                <li>
                                    <span>Email:</span>
                                    <a href="mailto:karir@adm.unand.ac.id">karir@adm.unand.ac.id </a>
                                </li>
                                <li><span>Telpon:</span>+62 8516 1476 546</li>
                            </ul>
                            <div class="footer-social">
                                <ul>
                                    <li>
                                        <a href="#"><i class="lni lni-facebook-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-twitter-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-linkedin-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-pinterest"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-footer f-link">
                                    <h3>Untuk Jobseeker</h3>
                                    <ul>
                                        <li><a href="resume.html">User Dashboard</a></li>
                                        <li><a href="#">CV Packages</a></li>
                                        <li><a href="#">Jobs Featured</a></li>
                                        <li><a href="#">Jobs Urgent</a></li>
                                        <li><a href="#">Candidate List</a></li>
                                        <li><a href="#">Candidates Grid</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-footer f-link">
                                    <h3>Untuk Employers</h3>
                                    <ul>
                                        <li><a href="#">Post New</a></li>
                                        <li><a href="#">Employer List</a></li>
                                        <li><a href="#">Employers Grid</a></li>
                                        <li><a href="#">Job Packages</a></li>
                                        <li><a href="#">Jobs Listing</a></li>
                                        <li><a href="#">Jobs Featured</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-footer f-link">
                                    <h3>Navigasi</h3>
                                    <ul>
                                        <li><a href="#">Tentang Kami</a></li>
                                        <li><a href="#">Kontak</a></li>
                                    </ul>
                                    <h3 class="visitor">Visitor</h3><a href="https://info.flagcounter.com/tNou"><img
                                            src="https://s01.flagcounter.com/count2/tNou/bg_FFFFFF/txt_000000/border_FFFFFF/columns_3/maxflags_12/viewers_3/labels_0/pageviews_0/flags_0/percent_0/"
                                            alt="Flag Counter" border="0"></a>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="left">
                                <p>
                                    Designed and Developed by<a href="/" rel="nofollow" target="_blank">Sistem
                                        Informasi Unand</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="right">
                                <ul>
                                    <li><a href="#">Terms of use</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Faq</a></li>
                                    <li><a href="#">Kontak</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('js/frontoffice/wow.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/bootstrap.min.js') }}"></script>4
    <script src="{{ asset('js/frontoffice/main.js') }}"></script>


</body>

</html>
