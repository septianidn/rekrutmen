<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Laporan Akhir Tracer Study</title>
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
                      <a class="active" >Publikasi</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="{{ route('tracerstudy-laporan') }}" class="{{ request()->routeIs('tracerstudy-laporan') ? 'active' : '' }}">Laporan Tracer Study</a>
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

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Laporan Akhir Tracer Study</h1>
                        <p>Laporan akhir ini adalah hasil dari penelitian yang mendalam tentang jejak karier alumni kami. Kami dengan bangga mempresentasikan temuan-temuan penting yang telah kami kumpulkan dalam studi pelacakan ini. Tracer study telah menjadi alat yang tak ternilai bagi institusi pendidikan kami untuk mengukur dampak pendidikan yang kami tawarkan terhadap kesuksesan karier alumni. Kami akan membahas berbagai aspek dari laporan ini, termasuk rincian statistik, pandangan alumni, dan bagaimana data ini dapat membantu kita meningkatkan program pendidikan kami di masa depan.</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="/tracerstudy">Home</a></li>
                        <li><a href="#">Publikasi</a></li>
                        <li>Laporan Tracer Study</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Blog Singel Area -->
    <section class="section latest-news-area blog-list">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
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
                              $fileLaporan = $laporan->getFirstMedia('laporants');
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
                        {{-- <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog1.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">The Internet Is A Job Seeker
                                            Most Crucial Success</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Job skills</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 12-09-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single News -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".5s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog2.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">Today From Connecting With
                                            Potential Employers</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Career advice</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 10-10-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single News -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog3.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">We’ve Weeded Through Hundreds
                                            Of Job Hunting</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Future plan</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 09-05-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single News -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".5s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog1.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">The Internet Is A Job Seeker
                                            Most Crucial Success</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Job skills</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 12-09-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single News -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog2.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">Today From Connecting With
                                            Potential Employers</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Career advice</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 10-10-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single News -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single News -->
                            <div class="single-news wow fadeInUp" data-wow-delay=".5s">
                                <div class="image">
                                    <img class="thumb" src="assets/images/blog/blog3.jpg" alt="#">
                                </div>
                                <div class="content-body">
                                    <h4 class="title"><a href="blog-single.html">We’ve Weeded Through Hundreds
                                            Of Job Hunting</a></h4>
                                    <div class="meta-details">
                                        <ul>
                                            <li><a href="#"><i class="lni lni-tag"></i> Future plan</a></li>
                                            <li><a href="#"><i class="lni lni-calendar"></i> 09-05-2023</a></li>
                                            <li><a href="#"><i class="lni lni-eye"></i> 55</a></li>
                                        </ul>
                                    </div>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum
                                        has been the standard.</p>
                                    <div class="button">
                                        <a href="blog-single.html" class="btn">Read More</a>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- End Single News -->
                        </div>

                    </div>
                    <!-- Pagination -->
                    <div class="pagination center">
                      <ul class="pagination-list">
                          @if ($dataLaporan->currentPage() > 1)
                              <li><a href="{{ $dataLaporan->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                          @else
                              <li class="disabled"><span><i class="lni lni-chevron-left"></i></span></li>
                          @endif
                  
                          @foreach ($dataLaporan->getUrlRange(1, $dataLaporan->lastPage()) as $page => $url)
                              <li class="{{ $page == $dataLaporan->currentPage() ? 'active' : '' }}">
                                  <a href="{{ $url }}">{{ $page }}</a>
                              </li>
                          @endforeach
                  
                          @if ($dataLaporan->hasMorePages())
                              <li><a href="{{ $dataLaporan->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
                          @else
                              <li class="disabled"><span><i class="lni lni-chevron-right"></i></span></li>
                          @endif
                      </ul>
                  </div>
                  
                  
                   
                  
                    <!--/ End Pagination -->
                </div>
                {{-- <aside class="col-lg-4 col-md-5 col-12">
                    <div class="sidebar">
                        <div class="widget search-widget">
                            <h5 class="widget-title"><span>Search This Site</span></h5>
                            <form action="#">
                                <input type="text" placeholder="Search Here...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <div class="widget popular-feeds">
                            <h5 class="widget-title"><span>Popular Feeds</span></h5>
                            <div class="popular-feed-loop">
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">Tips to write an impressive resume online for
                                                beginner</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 05th Nov 2023</span>
                                    </div>
                                </div>
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">10 most important SEO focus areas for
                                                colleges
                                                and universities</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 24th March 2023</span>
                                    </div>
                                </div>
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">7 things you should never say to your boss in
                                                your joblife</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 30th Jan 2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget categories-widget">
                            <h5 class="widget-title"><span>Categories</span></h5>
                            <ul class="custom">
                                <li>
                                    <a href="#">Announcement<span>26</span></a>
                                </li>
                                <li>
                                    <a href="#">Indeed Events<span>30</span></a>
                                </li>
                                <li>
                                    <a href="#">Tips & Tricks<span>71</span></a>
                                </li>
                                <li>
                                    <a href="#">Experiences<span>56</span></a>
                                </li>
                                <li>
                                    <a href="#">Case Studies<span>15</span></a>
                                </li>
                                <li>
                                    <a href="#">Labor Market News<span>12</span></a>
                                </li>
                                <li>
                                    <a href="#">HR Best Practices<span>17</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget popular-tag-widget">
                            <h5 class="widget-title"><span>Popular Tags</span></h5>
                            <div class="tags">
                                <a href="#">Jobpress</a>
                                <a href="#">Design</a>
                                <a href="#">HR</a>
                                <a href="#">Recruiter</a>
                                <a href="#">Interview</a>
                                <a href="#">Employee</a>
                                <a href="#">Labor</a>
                                <a href="#">Salary</a>
                                <a href="#">Consult</a>
                                <a href="#">Business</a>
                                <a href="#">Candidates</a>
                            </div>
                        </div>
                    </div>
                </aside> --}}
            </div>
        </div>
    </section>
    <!-- End Blog Singel Area -->

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
</body>

</html>