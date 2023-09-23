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


    <!-- End Header Area -->
    <!-- Start Hero Area -->
    <section class="hero-area">
      <div class="hero-inner">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 co-12">
              <div class="inner-content">
                <div class="hero-text">
                  <h1 class="wow fadeInUp" data-wow-delay=".3s">
                    Tracer Study <br />Universitas Andalas
                  </h1>
                  <p class="wow fadeInUp" data-wow-delay=".5s">
                    Creating a beautiful job website is not easy <br />
                    always. To make your life easier, we are<br />
                    introducing Jobcamp template.
                  </p>
                </div>
                <div
                  class="job-search-wrap-two mt-50 wow fadeInUp"
                  data-wow-delay=".7s"
                >
                  <!-- Single Field Item Start  -->
                  {{-- TODO CHANGE FROM ACTION --}}
                  <div class="job-search-form">
                    <form action="#">
                      <div class="single-field-item">
                        <p>Tahun</p>
                          </div>
                      <!-- Single Field Item End  -->
                      <!-- Single Field Item Start  -->
                      {{-- TODO FETCH FROM DB --}}
                      <div class="single-field-item">
                        <select class="form-select">
                          <option selected>2022</option>
                          <option value="option1">Opsi 1</option>
                          <option value="option2">Opsi 2</option>
                          <option value="option3">Opsi 3</option>
                        </select>
                       
                      </div>

                      <div class="submit-btn">
                        <button class="btn" type="submit">Isi Kuesioner</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            {{-- TODO FETCH VIDEO AND THUMBNAIL FROM DB --}}
            <div class="col-lg-6 co-12">
              <div class="hero-video-head wow fadeInRight" data-wow-delay=".5s">
                <div class="video-inner">

                  <img src="{{ asset('images/frontoffice/hero/tracerstudy/sambutan.png') }}"  alt="#" />
                  <a
                    href="https://www.youtube.com/watch?v=Lqf8k2eMF2k"
                    class="glightbox hero-video"
                    ><i class="lni lni-play"></i
                  ></a>
                  <!-- Video Animation -->
                  <div class="promo-video">
                    <div class="waves-block">
                      <div class="waves wave-1"></div>
                      <div class="waves wave-2"></div>
                      <div class="waves wave-3"></div>
                    </div>
                  </div>
                  <!--/ End Video Animation -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ End Hero Area -->

    <!-- Start Counting Area -->
    <section class="counter-section section">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-12 counter-col">
            <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0" data-end-at="53" data-time="1000" data-delay="60" data-format="{}+"></span> </div>
            <div class="counter-text">Lulusan D3</div>
          </div>
          <div class="col-lg-3 col-md-3 col-12 counter-col">
            <div class="counter-RANDOM "> <span class="counter-value" data-vanilla-counter="" data-start-at="0" data-end-at="20" data-time="1000" data-delay="60" data-format="{}K+"></span></div>
            <div class="counter-text">Lulusan S1</div>
          </div>
          <div class="col-lg-3 col-md-3 col-12 counter-col">
            <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0" data-end-at="18" data-time="1000" data-delay="60" data-format="{}K+"></span> </div>
            <div class="counter-text">Lulusan</div>
          </div>
          <div class="col-lg-3 col-md-3 col-12 counter-col">
            <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0" data-end-at="5" data-time="1000" data-delay="60" data-format="{}"></span> </div>
            <div class="counter-text">Pelaksanaan Tracer Study</div>
          </div>
        </div>
      </div>
    </section>

     
  
    

	
 
  
    {{-- <section class="job-category section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Job Category</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Choose Your Desire Category
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".6s">
                There are many variations of passages of Lorem Ipsum available,
                but the majority have suffered alteration in some form.
              </p>
            </div>
          </div>
        </div>
        <div class="cat-head">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".2s"
              >
                <div class="icon">
                  <i class="lni lni-cog"></i>
                </div>
                <h3>
                  Technical<br />
                  Support
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".4s"
              >
                <div class="icon">
                  <i class="lni lni-layers"></i>
                </div>
                <h3>
                  Business<br />
                  Development
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".6s"
              >
                <div class="icon">
                  <i class="lni lni-home"></i>
                </div>
                <h3>
                  Real Estate<br />
                  Business
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".8s"
              >
                <div class="icon">
                  <i class="lni lni-search"></i>
                </div>
                <h3>
                  Share Maeket<br />
                  Analysis
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".2s"
              >
                <div class="icon">
                  <i class="lni lni-investment"></i>
                </div>
                <h3>
                  Finance & Banking <br />
                  Service
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".4s"
              >
                <div class="icon">
                  <i class="lni lni-cloud-network"></i>
                </div>
                <h3>
                  IT & Networing <br />
                  Sevices
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".6s"
              >
                <div class="icon">
                  <i class="lni lni-restaurant"></i>
                </div>
                <h3>
                  Restaurant <br />
                  Services
                </h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <a
                href="browse-jobs.html"
                class="single-cat wow fadeInUp"
                data-wow-delay=".8s"
              >
                <div class="icon">
                  <i class="lni lni-fireworks"></i>
                </div>
                <h3>
                  Defence & Fire <br />
                  Service
                </h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section> --}}

    <section class="about-us section">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-lg-6 col-md-10 col-12">
            <div class="content-left wow fadeInLeft" data-wow-delay=".3s">
              <div calss="row">
                <div calss="col-lg-6 col-12">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-6">
                      <img
                        class="single-img"
                        
                       src="{{ asset('images/frontoffice/about/xsmall1.jpg') }}"  alt="#"
                      />
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                      <img
                        class="single-img mt-50"
                        src="{{ asset('images/frontoffice/about/xsmall2.jpg') }}"  alt="#"
                       
                      />
                    </div>
                  </div>
                </div>
                <div calss="col-lg-6 col-12">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-6">
                      <img
                        class="single-img minus-margin"
                        src="{{ asset('images/frontoffice/about/xsmall3.jpg') }}"  alt="#"
                    
                      />
                    </div>
                    <div class="col-lg-6 col-md-6 col-6">
                      <div class="media-body">
                        <i class="lni lni-checkmark"></i>
                        <h6 class>Tracer Study!</h6>
                        <p class>Isi kuesioner mu sekarang juga!</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-10 col-12">
            <div class="content-right wow fadeInRight" data-wow-delay=".5s">
              <h2>
                Tentang Tracer Study  <br />
                Universitas Andalas
              </h2>
              <p class="about-text">
                Tracer Study dapat juga dikatakan sebagai alumni survei atau graduate survey, yang merupakan kegiatan yang dilakukan suatu institusi untuk melacak kembali alumninya. Pelacakan tersebut bertujuan mendapatkan gambaran tentang kompetensi alumni dan melihat apakah ada perbedaan kompetensi yang didapatkan selama menjalani pendidikan dengan kompetensi yang dituntut oleh dunia kerja. Tracer Study penting dilaksanakan untuk kepentingan universitas dan semua pihak, seperti berikut
              </p>

              <div class="single-list">
                <i class="lni lni-grid-alt"></i>

                <div class="list-bod">
                  <h5>#1 Jobs site in UK</h5>
                  <p>
                    Leverage agile frameworks to provide a robust synopsis for
                    high level overviews. Iterative
                  </p>
                </div>
              </div>

              <div class="single-list">
                <i class="lni lni-search"></i>

                <div class="list-bod">
                  <h5>Seamless searching</h5>
                  <p>
                    Capitalize on low hanging fruit to identify a ballpark value
                    added activity to beta test.
                  </p>
                </div>
              </div>

              <div class="single-list">
                <i class="lni lni-stats-up"></i>

                <div class="list-bod">
                  <h5>Hired in top companies</h5>
                  <p>
                    Podcasting operational change management inside of workflows
                    to establish.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

     <!-- Start Apply Process Area -->
     <section class="apply-process section">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-12">
            <div class="process-item">
              <i class="lni lni-user"></i>
              <h4>Kunjungi Halaman Pengisian</h4>
              <p>
                Kunjungi halaman pengisian tracer study sesuai tahun yang ditentukan
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-12">
            <div class="process-item">
              <i class="lni lni-book"></i>
              <h4>Masukan PIN</h4>
              <p>
                Masukan PIN yang telah dikirim tim tracer ke email masing-masing responden
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-12">
            <div class="process-item">
              <i class="lni lni-briefcase"></i>
              <h4>Isi Kuesioner</h4>
              <p>
                Isi kuesioner dengan tepat
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- <section class="call-action overlay section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 col-12">
            <div class="inner">
              <div class="section-title">
                <span class="wow fadeInDown" data-wow-delay=".2s"
                  >GETTING STARTED TO WORK</span
                >
                <h2 class="wow fadeInUp" data-wow-delay=".4s">
                  Don’t just find. Be found. Put your CV in front of great
                  employers
                </h2>
                <p class="wow fadeInUp" data-wow-delay=".6s">
                  It helps you to increase your chances of finding a suitable
                  job and let recruiters contact you about jobs that are not
                  needed to pay for advertising.
                </p>
                <div class="button wow fadeInUp" data-wow-delay=".8s">
                  <a href="add-resume.html" class="btn"
                    ><i class="lni lni-upload"></i> Upload Your Resume</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> --}}

    <section class="find-job section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s">Progress Tracer Study</span>
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Dashboard Progress Tracer Study
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".6s">
                There are many variations of passages of Lorem Ipsum available,
                but the majority have suffered alteration in some form.
              </p>
            </div>
          </div>
        </div>
        <div class="single-head">
          <div class="row">

            {{-- TC DASHBOARD --}}

          </div>

          <div class="row">
            <div class="col-12">
              <div class="button selengkapnya">
                <a href="{{route('tracerstudy-laporan')}}" class="btn">Selengkapnya</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- <section class="featured-job section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Featured Jobs</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Browse Featured Jobs
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".6s">
                There are many variations of passages of Lorem Ipsum available,
                but the majority have suffered alteration in some form.
              </p>
            </div>
          </div>
        </div>
        <div class="single-head">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".2s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                  
                </div>
                <div class="content">
                  <h4><a href="job-details.html">Graphics Design</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".4s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                </div>
                <div class="content">
                  <h4><a href="job-details.html">Restaurant Services</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".6s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                </div>
                <div class="content">
                  <h4><a href="job-details.html">Share Maeket Analysis</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".2s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                </div>
                <div class="content">
                  <h4><a href="job-details.html">Medical services</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".4s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                </div>
                <div class="content">
                  <h4><a href="job-details.html">Auto Mobile Services</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".6s">
                <div class="shape"></div>
                <div class="feature">Featured</div>
                <div class="image">
                    <img src="{{ asset('images/frontoffice/featured-job/ximg1.jpg') }}"  alt="#" />
                </div>
                <div class="content">
                  <h4><a href="job-details.html">IT & Networing Sevices</a></h4>
                  <ul>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                    <li><i class="lni lni-briefcase"></i> Full-time</li>
                    <li><i class="lni lni-dollar"></i> 80K-90K</li>
                  </ul>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <div class="button">
                    <a href="job-details.html" class="btn">Apply Now</a>
                    <a href="bookmarked.html" class="btn save"
                      ><i class="lni lni-bookmark"></i> Save It</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> --}}

    {{-- <section class="pricing-table section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Pricing Table</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Our Pricing Plan
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".6s">
                There are many variations of passages of Lorem Ipsum available,
                but the majority have suffered alteration in some form.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-table wow fadeInUp" data-wow-delay=".2s">
              <div class="table-head">
                <h4 class="title">BASIC PACK</h4>
                <div class="price">
                  <p class="amount">
                    $30<span class="duration">per month</span>
                  </p>
                </div>
              </div>

              <ul class="table-list">
                <li>5+ Listings</li>
                <li>Contact With Agent</li>
                <li>Contact With Agent</li>
                <li>7×24 Fully Support</li>
                <li>50GB Space</li>
              </ul>

              <div class="button">
                <a class="btn" href="#">Register Now</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-table wow fadeInUp" data-wow-delay=".4s">
              <div class="table-head">
                <h4 class="title">STANDARD PACK</h4>
                <div class="price">
                  <p class="amount">
                    $40<span class="duration">per month</span>
                  </p>
                </div>
              </div>

              <ul class="table-list">
                <li>5+ Listings</li>
                <li>Contact With Agent</li>
                <li>Contact With Agent</li>
                <li>7×24 Fully Support</li>
                <li>50GB Space</li>
              </ul>

              <div class="button">
                <a class="btn" href="#">Register Now</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-table wow fadeInUp" data-wow-delay=".6s">
              <div class="table-head">
                <h4 class="title">PREMIUM PACK</h4>
                <div class="price">
                  <p class="amount">
                    $60<span class="duration">per month</span>
                  </p>
                </div>
              </div>

              <ul class="table-list">
                <li>5+ Listings</li>
                <li>Contact With Agent</li>
                <li>Contact With Agent</li>
                <li>7×24 Fully Support</li>
                <li>50GB Space</li>
              </ul>

              <div class="button">
                <a class="btn" href="#">Register Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> --}}

    <div class="latest-news-area section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Publikasi</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Publikasi dan Laporan Tracer Study
              </h2>
              <p class="wow fadeInUp" data-wow-delay=".6s">
                Temukan laporan akhir mengenai tracer study
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          @foreach ($dataLaporan as $laporan)
              <div class="col-lg-4 col-md-6 col-12">
                  <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                      <div class="content-body">
                          <h4 class="title">
                              <a href="">
                                Laporan Tracer Study Tahun {{$laporan->paket_soal->tahun_pelaksanaan}}
                              </a>
                          </h4>
                          <p>
                            {{ $laporan->paket_soal->deskripsi ?? 'Laporan ini ditujukan untuk melihat hasil akhir tracer study untuk lulusan '. $laporan->untuk_lulusan}}
                          </p>
                          @php
                          $fileLaporan = $laporan->getFirstMedia('laporants') ?? null;
                      @endphp
                          <div class="button buttontc">
                            @if($fileLaporan)
                            <a href="{{$fileLaporan->getUrl() ?? ''}}"   target="_blank" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                         @endif
                          </div>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
      
        {{-- <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                  >Laporan Tracer Study Tahun 2022</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="blog-single.html" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                  >Laporan Tracer Study Tahun 2020</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="blog-single.html" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                    >Laporan Tracer Study Tahun 2020</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="blog-single.html" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                  >Laporan Tracer Study Tahun 2022</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="blog-single.html" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                  >Laporan Tracer Study Tahun 2020</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="blog-single.html" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                    >Laporan Tracer Study Tahun 2020</a
                  >
                </h4>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button buttontc">
                  <a href="{{route('tracerstudy-laporan')}}" class="btn"> Selengkapnya  <i class="lni lni-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        <div class="row">
          <div class="col-12">
            <div class="button selengkapnya">
              <a href="{{route('tracerstudy-laporan')}}" class="btn">Selengkapnya</a>
            </div>
          </div>
        </div>
      </div>
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
    <script defer="" src="https://unpkg.com/vanilla-counter" onload="initializeCounterRANDOMID()"></script>
<!-- check info at https://github.com/yunisdev/vanilla-counter -->
<!-- lc-needs-hard-refresh -->

<script>

	function initializeCounterRANDOMID(){
		
		const options = {};
		
		const observer = new IntersectionObserver(function
		(entries, observer){
		    entries.forEach(entry => {
		        console.log(entry);
		         VanillaCounter();
		    });
		}, options);
		
		observer.observe(document.querySelector('.counter-RANDOM'));
	}

</script>
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