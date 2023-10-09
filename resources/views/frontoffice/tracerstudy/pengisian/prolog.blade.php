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

    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('css/frontoffice/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontoffice/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontoffice/tiny-slider.css') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/frontoffice/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontoffice/main.css') }}">

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
                    <img class="logo1" src="{{ asset('images/frontoffice/logo/logo.svg') }}" alt="Logo CDC Unand" >
                </a>
                <button
                  class="navbar-toggler"
                  type="button"
                  data-toggle="collapse"
                  data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent"
                  aria-expanded="false"
                  aria-label="Toggle navigation"
                >
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                  <span class="toggler-icon"></span>
                </button>
                <div
                  class="collapse navbar-collapse sub-menu-bar"
                  id="navbarSupportedContent"
                >
                  <ul id="nav" class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a href="{{ route('landingpage') }}" class="{{ request()->routeIs('landingpage') ? 'active' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                      <a href="#">Karir</a>
                      <ul class="sub-menu">
                        <li><a href="#">Vacancy</a></li>
                        <li><a href="#">Test Call</a></li>
                        <li><a href="#">Article</a></li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('tracerstudy') }}" class="{{ request()->routeIs('tracerstudy') ? 'active' : '' }}">Tracer Study</a>
                    </li>
                    <li class="nav-item">
                      <a href="#">Konseling </a>
                    </li>
                    <li class="nav-item">
                      <a >Publikasi</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="{{ route('tracerstudy-laporan') }}" class="{{ request()->routeIs('tracerstudy-laporan') ? 'active' : '' }}">Laporan Tracer Study</a>
                        </li>
                        <li><a href="">Laporan Pertanyaan Tracer Study</a></li>
                        <li>
                          <a href="#"
                            >Dashboard Progress</a
                          >
                        </li>
                        <li>
                          <a href="#"
                            >Laporan Pelaksanaan Konseling</a
                          >
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
                <div class="button">
                  <a
                    href="javacript:"
                    data-toggle="modal"
                    data-target="#login"
                    class="login"
                    ><i class="lni lni-lock-alt"></i> Masuk</a
                  >
                  <a
                    href="javacript:"
                    data-toggle="modal"
                    data-target="#signup"
                    class="btn"
                    >Daftar</a
                  >
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="section">
      <p>Nama : {{Auth::guard('alumni')->user()->nim}}</p>
    </div>

    <div class="client-logo-section">
      <div class="container">
        <div class="client-logo-wrapper">
          <div
            class="client-logo-carousel d-flex align-items-center justify-content-between"
          >
            <div class="client-logo">
              <img
                 src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#""
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade form-modal"
      id="login"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog max-width-px-840 position-relative">
        <button
          type="button"
          class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
          data-dismiss="modal"
        >
          <i class="lni lni-close"></i>
        </button>
        <div class="login-modal-main">
          <div class="row no-gutters">
            <div class="col-12">
              <div class="row">
                <div class="heading">
                  <h3>Login From Here</h3>
                  <p>
                    Log in to continue your account <br />
                    and explore new jobs.
                  </p>
                </div>
                <div class="social-login">
                  <ul>
                    <li>
                      <a class="linkedin" href="#"
                        ><i class="lni lni-linkedin-original"></i> Log in with
                        LinkedIn</a
                      >
                    </li>
                    <li>
                      <a class="google" href="#"
                        ><i class="lni lni-google"></i> Log in with Google</a
                      >
                    </li>
                    <li>
                      <a class="facebook" href="#"
                        ><i class="lni lni-facebook-original"></i> Log in with
                        Facebook</a
                      >
                    </li>
                  </ul>
                </div>
                <div class="or-devider">
                  <span>Or</span>
                </div>
                <form action="/">
                  <div class="form-group">
                    <label for="email" class="label">E-mail</label>
                    <input
                      type="email"
                      class="form-control"
                      placeholder="example@gmail.com"
                      id="email"
                    />
                  </div>
                  <div class="form-group">
                    <label for="password" class="label">Password</label>
                    <div class="position-relative">
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Enter password"
                      />
                    </div>
                  </div>
                  <div
                    class="form-group d-flex flex-wrap justify-content-between"
                  >
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value
                        id="flexCheckDefault"
                      />
                      <label class="form-check-label" for="flexCheckDefault"
                        >Remember password</label
                      >
                    </div>
                    <a href class="font-size-3 text-dodger line-height-reset"
                      >Forget Password</a
                    >
                  </div>
                  <div class="form-group mb-8 button">
                    <button class="btn">Log in</button>
                  </div>
                  <p class="text-center create-new-account">
                    Don’t have an account? <a href="#">Create a free account</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade form-modal"
      id="signup"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog max-width-px-840 position-relative">
        <button
          type="button"
          class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
          data-dismiss="modal"
        >
          <i class="lni lni-close"></i>
        </button>
        <div class="login-modal-main">
          <div class="row no-gutters">
            <div class="col-12">
              <div class="row">
                <div class="heading">
                  <h3>
                    Create a free Account <br />
                    Today
                  </h3>
                  <p>
                    Create your account to continue <br />
                    and explore new jobs.
                  </p>
                </div>
                <div class="social-login">
                  <ul>
                    <li>
                      <a class="linkedin" href="#"
                        ><i class="lni lni-linkedin-original"></i> Import from
                        LinkedIn</a
                      >
                    </li>
                    <li>
                      <a class="google" href="#"
                        ><i class="lni lni-google"></i> Import from Google</a
                      >
                    </li>
                    <li>
                      <a class="facebook" href="#"
                        ><i class="lni lni-facebook-original"></i> Import from
                        Facebook</a
                      >
                    </li>
                  </ul>
                </div>
                <div class="or-devider">
                  <span>Or</span>
                </div>
                <form action="/">
                  <div class="form-group">
                    <label for="email" class="label">E-mail</label>
                    <input
                      type="email"
                      class="form-control"
                      placeholder="example@gmail.com"
                    />
                  </div>
                  <div class="form-group">
                    <label for="password" class="label">Password</label>
                    <div class="position-relative">
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Enter password"
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="label">Confirm Password</label>
                    <div class="position-relative">
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Enter password"
                      />
                    </div>
                  </div>
                  <div
                    class="form-group d-flex flex-wrap justify-content-between"
                  >
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value />
                      <label class="form-check-label" for="flexCheckDefault"
                        >Agree to the <a href="#">Terms & Conditions</a></label
                      >
                    </div>
                  </div>
                  <div class="form-group mb-8 button">
                    <button class="btn">Sign Up</button>
                  </div>
                </form>
              </div>
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
                  <a href="/"
                    ><img
                     src="{{ asset('images/frontoffice/logo/logo.svg') }}"  alt="#" />
                
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
                    <a
                      href="mailto:karir@adm.unand.ac.id">karir@adm.unand.ac.id </a>
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
                    <h3 class="visitor">Visitor</h3><a href="https://info.flagcounter.com/tNou"><img src="https://s01.flagcounter.com/count2/tNou/bg_FFFFFF/txt_000000/border_FFFFFF/columns_3/maxflags_12/viewers_3/labels_0/pageviews_0/flags_0/percent_0/" alt="Flag Counter" border="0"></a>
                      
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
                    Designed and Developed by<a
                      href="/"
                      rel="nofollow"
                      target="_blank"
                      >Sistem Informasi Unand</a
                    >
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

    <script src="{{ asset('js/frontoffice/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/wow.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/tiny-slider.js') }}"></script>
    <script src="{{ asset('js/frontoffice/glightbox.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/main.js') }}"></script>

<!-- check info at https://github.com/yunisdev/vanilla-counter -->
<!-- lc-needs-hard-refresh -->


    <script type="text/javascript">
        //========= glightbox
        GLightbox({
            'href': 'https://www.youtube.com/watch?v=cz4z8CyvDas',
            'type': 'video',
            'source': 'youtube', //vimeo, youtube or local
            'width': 900,
            'autoplayVideos': true,
        });
    </script>
  </body>
</html>