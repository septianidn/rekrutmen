<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>CDC Unand</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/frontoffice/favicon.png') }}" />
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
                      <a href="#">Publikasi</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="#">Laporan Tracer Study</a>
                        </li>
                        <li><a href="#">Laporan Pertanyaan Tracer Study</a></li>
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
    {{-- TODO : FETCH FROM DB --}}
    <section class="hero-area style2">
        <div class="hero-inner">
          <div class="home-slider">
            <div class="single-slider">
              <img
              class="slider-background"   
             src="{{ asset('images/frontoffice/hero/unand.jpg') }}"  alt="#"
            />
              <div class="container">
                <div class="row">
                  <div class="col-lg-6 co-12">
                    <div class="inner-content">
                      <div class="hero-text">
                        <h1 class="wow fadeInUp text-white" data-wow-delay=".3s">
                          Career Development Center <br />Andalas University
                        </h1>
                        <p class="wow fadeInUp text-white" data-wow-delay=".5s">
                          Lorem ipsum dolor sit amet consectetur. Sit est porttitor platea tellus luctus sagittis. Eget eget sit quam nam. Netus condimentum pretium nulla nisi est purus lorem nec. Nulla malesuada lorem urna est. Diam consectetur vel vestibulum leo amet gravida in aliquam. Nulla turpis sit turpis aliquet. Tincidunt tempor odio proin erat pellentesque. Risus massa leo habitant nisl enim mus sed. Eget mauris tristique tempor lectus lectus massa ac nec morbi. 
                        </p>
                        <div class="button wow fadeInUp " data-wow-delay=".7s">
                          <a href="#" class="btn">Selengkapnya</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="single-slider">
              <img
              class="slider-background"   
             src="{{ asset('images/frontoffice/hero/unand.jpg') }}"  alt="#"
            />
              <div class="container">
                <div class="row">
                  <div class="col-lg-6 co-12">
                    <div class="inner-content">
                      <div class="hero-text">
                        <h1 class="wow fadeInUp text-white" data-wow-delay=".3s">
                          Find Your Career <br />to Make a Better Life
                        </h1>
                        <p class="wow fadeInUp text-white" data-wow-delay=".5s">
                          Creating a beautiful job website is not easy always. To
                          make your life easier we are introducing Jobcamp
                          template, Leverage agile frameworks to high level
                          overviews.
                        </p>
                        <div class="button wow fadeInUp" data-wow-delay=".7s">
                          <a href="#" class="btn">Post a Job</a>
                          <a href="#" class="btn btn-alt">See Our Jobs</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--/ End Hero Area -->

   

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
                        <h6 class>Job alert!</h6>
                        <p class>104 new jobs are available in this week!</p>
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
                Membantu Pengembangan Karir  <br/> Yang Adaptif Dan Responsif <br />
                Terhadap Dunia Kerja
              </h2>

              <div class="single-list">
                <i class="lni lni-grid-alt"></i>

                <div class="list-bod">
                  <h5>Informasi Ketenagakerjaan</h5>
                  <p>
                    Leverage agile frameworks to provide a robust synopsis for
                    high level overviews. Iterative
                  </p>
                </div>
              </div>

              <div class="single-list">
                <i class="lni lni-search"></i>

                <div class="list-bod">
                  <h5>Tracer Study</h5>
                  <p>
                    Capitalize on low hanging fruit to identify a ballpark value
                    added activity to beta test.
                  </p>
                </div>
              </div>

              <div class="single-list">
                <i class="lni lni-stats-up"></i>

                <div class="list-bod">
                  <h5>Konseling Karir</h5>
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

    <section class="call-action overlay section">
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
    </section>

        {{-- TODO : FETCH FROM DB --}}
    <section class="find-job section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s">Lowongan Kerja</span>
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Temukan Lowongan
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
            <div class="col-lg-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".3s">
                <div class="job-image">
                  <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Software Engineer</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> winbrans.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> New York</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>full time</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".3s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Graphics Design</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> designhub.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> Washington, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>Intern</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".3s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Ui/Ux Design</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> uddesign.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> Cupertino, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>Part Time</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".3s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Web Developer</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> webinner.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> Delaware, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>Intern</span></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-12">
              <div class="single-job wow fadeInUp" data-wow-delay=".5s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Digital Marketer</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> marketers.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> New York, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>Part Time</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".5s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Sales Manager</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> winbrans.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> Delaware, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>full time</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".5s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Product Designer</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> winbrans.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> New York, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>full time</span></li>
                  </ul>
                </div>
              </div>

              <div class="single-job wow fadeInUp" data-wow-delay=".5s">
                <div class="job-image">
                    <img src="{{ asset('images/frontoffice/jobs/job-logo.png') }}"  alt="#" />
                </div>
                <div class="job-content">
                  <h4><a href="job-details.html">Android Developer</a></h4>
                  <p>
                    We are looking for Enrollment Advisors who are looking to
                    take 30-35 appointments per week. All leads are
                    pre-scheduled.
                  </p>
                  <ul>
                    <li>
                      <i class="lni lni-website"></i
                      ><a href="#"> androidplex.com</a>
                    </li>
                    <li><i class="lni lni-dollar"></i> $20k - $25k</li>
                    <li><i class="lni lni-map-marker"></i> Cupertino, USA</li>
                  </ul>
                </div>
                <div class="job-button">
                  <ul>
                    <li><a href="job-details.html">Apply</a></li>
                    <li><span>Part Time</span></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="pagination center wow fadeInUp" data-wow-delay=".3s">
                <ul class="pagination-list">
                  <li>
                    <a href="#"><i class="lni lni-arrow-left"></i></a>
                  </li>
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li>
                    <a href="#"><i class="lni lni-arrow-right"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- TODO : FETCH FROM DB --}}
     <div class="latest-news-area section">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <span class="wow fadeInDown" data-wow-delay=".2s"
                >Publikasi Terkini</span
              >
              <h2 class="wow fadeInUp" data-wow-delay=".4s">
                Artikel dan Berita
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
            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
              <div class="image">
                <img src="{{ asset('images/frontoffice/blog/ximg1.jpg') }}"  alt="#" />
              </div>
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                    >The Internet Is A Job Seeker Most Crucial Success</a
                  >
                </h4>
                <div class="meta-details">
                  <ul>
                    <li>
                      <a href="#"><i class="lni lni-tag"></i> Job skills</a>
                    </li>
                    <li>
                      <a href="#"
                        ><i class="lni lni-calendar"></i> 12-09-2023</a
                      >
                    </li>
                    <li>
                      <a href="#"><i class="lni lni-eye"></i> 55</a>
                    </li>
                  </ul>
                </div>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button">
                  <a href="blog-single.html" class="btn">Selengkapnya</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".5s">
              <div class="image">
                <img src="{{ asset('images/frontoffice/blog/ximg1.jpg') }}"  alt="#" />
              </div>
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                    >Today From Connecting With Potential Employers</a
                  >
                </h4>
                <div class="meta-details">
                  <ul>
                    <li>
                      <a href="#"><i class="lni lni-tag"></i> Career advice</a>
                    </li>
                    <li>
                      <a href="#"
                        ><i class="lni lni-calendar"></i> 10-10-2023</a
                      >
                    </li>
                    <li>
                      <a href="#"><i class="lni lni-eye"></i> 55</a>
                    </li>
                  </ul>
                </div>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button">
                  <a href="blog-single.html" class="btn">Selengkapnya</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-news wow fadeInUp" data-wow-delay=".7s">
              <div class="image">
                <img src="{{ asset('images/frontoffice/blog/ximg1.jpg') }}"  alt="#" />
              </div>
              <div class="content-body">
                <h4 class="title">
                  <a href="blog-single.html"
                    >We’ve Weeded Through Hundreds Of Job Hunting</a
                  >
                </h4>
                <div class="meta-details">
                  <ul>
                    <li>
                      <a href="#"><i class="lni lni-tag"></i> Future plan</a>
                    </li>
                    <li>
                      <a href="#"
                        ><i class="lni lni-calendar"></i> 09-05-2023</a
                      >
                    </li>
                    <li>
                      <a href="#"><i class="lni lni-eye"></i> 55</a>
                    </li>
                  </ul>
                </div>
                <p>
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the standard.
                </p>
                <div class="button">
                  <a href="blog-single.html" class="btn">Selengkapnya</a>
                </div>
              </div>
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
                 src="{{ asset('images/frontoffice/clients/client1.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client2.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client2.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client2.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client2.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client1.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client1.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client1.png') }}"  alt="#"
              />
            </div>
            <div class="client-logo">
              <img
              src="{{ asset('images/frontoffice/clients/client2.png') }}"  alt="#"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- TODO : LOGIN MODAL JOBSEEKER AND Employer --}}
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
                  <h3>Masuk Disini</h3>
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
                        placeholder="Masukkan password"
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
                      >Lupa Password?</a
                    >
                  </div>
                  <div class="form-group mb-8 button">
                    <button class="btn">Masuk</button>
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
    <script type="text/javascript">
        //====== Clients Logo Slider
        tns({
            container: '.client-logo-carousel',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1170: {
                    items: 6,
                }
            }
        });
        var slider = new tns({
            container: '.home-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-arrow-left prev"></i>', '<i class="lni lni-arrow-right next"></i>'],
            responsive: {
                1200: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
                0: {
                    items: 1,
                }
            }
            });
        
    </script>
  </body>
</html>