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
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/frontoffice/main.css') }}">
    <style>
    
    
@media (max-width: 991.98px) {
  .content .bg {
    height: 500px; } 
}

.content .contents, .content .bg {
  width: 50%; }
  @media (max-width: 1199.98px) {
    .content .contents, .content .bg {
      width: 100%; 
    } 
    }

.content .bg {
  background-size: cover;
  background-position: center; }

.content a {
  color: #888;
  text-decoration: underline; }

  .text-14{
    font-size: 12px;
  }
.content .btn {
  height: 54px;
  padding-left: 30px;
  padding-right: 30px; }

.content .forgot-pass {
  position: relative;
  top: 2px;
  font-size: 14px; }


  .btn{
    background-color: #009A4B;
    color: white;
    
  }
  .btn:hover{
    background-color: #007538;
    color: white;
  }
.content .btn {
  height: 48px;
  padding-left: 30px;
  padding-right: 30px; 
  font-size: 14px;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #8a92a6;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #eee;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    box-shadow: 0 0 0 0;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }


.form-control:focus {
    color: #8a92a6;
    background-color: #ffffff;
    border-color: #0db960;
    outline: 0;
    box-shadow: 0 0 0 0, 0 0.125rem 0.25rem 0rem rgba(20, 233, 109, 0.585);
}
.form-control::-webkit-date-and-time-value {
    height: 1.5em;
}
.form-control::-moz-placeholder {
    color: #6c757d;
    opacity: 1;
}
.form-control::placeholder {
    color: #6c757d;
    opacity: 1;
}

.form-control-lg {
    min-height: calc(1.5em + 1rem + 2px);
    padding: 0.5rem 1.5rem;
    font-size: 1.25rem;
    border-radius: 0.25rem;
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

    <section class="hero-area style3">
        <!-- Single Slider -->
        <div class="hero-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 co-12">
                        <div class="inner-content">
                            <img  src="{{ asset('images/frontoffice/tracerstudy/hero.jpg') }}"  alt="#"  class="img-fluid mt-4">
                           
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-0 col-md-8 offset-md-2 co-12">
                        {{ Form::open(['class' => 'home-search wow fadeInRight', 'data-wow-delay' => '.5s', 'method' => 'POST']) }}
                            <h3 class="mb-2">Login Tracer Study Lulusan 2021</h3>
                                    <p class="mb-2">Silahkan login pada form dibawah ini untuk dapat mengakses survey tracer study. Apabila anda mengalami kesulitan dalam login, silahkan hubungi Administrator Tracer Study</p>            
                              
                                    <div class="form-group">
                                    <label class="font-weight-bold text-dark">PIN</label>
                                    <div class=" form-location">
                                        {{ Form::text('pin', '', ['class' => 'form-control', 'placeholder' => 'Masukkan PIN']) }}
                                        <small class="mt-2">Gunakan PIN yang telah dikirimkan lewat email untuk masuk.</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Captcha</label>
                                    <div class="form-location">
                                      {!! NoCaptcha::renderJs() !!}
                                      {!! NoCaptcha::display() !!}
                                    </div>
                                </div>
                                <label class="control control--checkbox mb-0"><span class="caption">Ingat Saya</span>
                                    <input type="checkbox" checked="checked"/>
                                    <div class="control__indicator"></div>
                                  </label>
                                <div class="button">
                                    <a class="btn" href="#"> Masuk </a>
                                </div>
                                {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section>

   
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
    <script src="{{ asset('js/frontoffice/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/wow.min.js') }}"></script>
    <script src="{{ asset('js/frontoffice/main.js') }}"></script>

    <script type="text/javascript">
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
  </body>
</html>