<x-front-office-layout :assets="$assets ?? []">
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
                            <div class="job-search-wrap-two mt-50 wow fadeInUp" data-wow-delay=".7s">
                                <!-- Single Field Item Start  -->
                                {{-- TODO CHANGE FROM ACTION --}}

                                <div class="job-search-form">
                                    {!! Form::open([
                                        'enctype' => 'multipart/form-data',
                                        'id' => 'formTC',
                                    ]) !!}
                                    <x-auth-validation-errors class="mb-2 mt-3" :errors="$errors" />
                                    <div class="single-field-item">
                                        <p>Lulusan</p>
                                    </div>

                                    <div class="single-field-item">
                                        {{ Form::select('untuk_lulusan', $optionTracerStudy->pluck('untuk_lulusan', 'alias_url'), null, [
                                            'class' => 'form-select',
                                            'id' => 'untuk_lulusan',
                                        ]) }}
                                    </div>

                                    <div class="submit-btn">
                                        <button class="btn" id="toLogin" type="button">Isi Kuesioner</button>
                                    </div>

                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TODO FETCH VIDEO AND THUMBNAIL FROM DB --}}
                    <div class="col-lg-6 co-12">
                        <div class="hero-video-head wow fadeInRight" data-wow-delay=".5s">
                            <div class="video-inner">

                                <img src="{{ asset('images/frontoffice/hero/tracerstudy/sambutan.png') }}"
                                    alt="#" />
                                <a href="https://www.youtube.com/watch?v=Lqf8k2eMF2k" class="glightbox hero-video"><i
                                        class="lni lni-play"></i></a>
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
                    <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0"
                            data-end-at="53" data-time="1000" data-delay="60" data-format="{}+"></span> </div>
                    <div class="counter-text">Lulusan D3</div>
                </div>
                <div class="col-lg-3 col-md-3 col-12 counter-col">
                    <div class="counter-RANDOM "> <span class="counter-value" data-vanilla-counter="" data-start-at="0"
                            data-end-at="20" data-time="1000" data-delay="60" data-format="{}K+"></span></div>
                    <div class="counter-text">Lulusan S1</div>
                </div>
                <div class="col-lg-3 col-md-3 col-12 counter-col">
                    <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0"
                            data-end-at="18" data-time="1000" data-delay="60" data-format="{}K+"></span> </div>
                    <div class="counter-text">Lulusan</div>
                </div>
                <div class="col-lg-3 col-md-3 col-12 counter-col">
                    <div class="counter-RANDOM"> <span class="counter-value" data-vanilla-counter="" data-start-at="0"
                            data-end-at="5" data-time="1000" data-delay="60" data-format="{}"></span> </div>
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
                                        <img class="single-img"
                                            src="{{ asset('images/frontoffice/about/xsmall1.jpg') }}" alt="#" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img mt-50"
                                            src="{{ asset('images/frontoffice/about/xsmall2.jpg') }}" alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div calss="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img minus-margin"
                                            src="{{ asset('images/frontoffice/about/xsmall3.jpg') }}" alt="#" />
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
                            Tentang Tracer Study <br />
                            Universitas Andalas
                        </h2>
                        <p class="about-text">
                            Tracer Study dapat juga dikatakan sebagai alumni survei atau graduate survey, yang merupakan
                            kegiatan yang dilakukan suatu institusi untuk melacak kembali alumninya. Pelacakan tersebut
                            bertujuan mendapatkan gambaran tentang kompetensi alumni dan melihat apakah ada perbedaan
                            kompetensi yang didapatkan selama menjalani pendidikan dengan kompetensi yang dituntut oleh
                            dunia kerja. Tracer Study penting dilaksanakan untuk kepentingan universitas dan semua
                            pihak, seperti berikut
                        </p>

                        <div class="single-list">
                            <i class="lni lni-grid-alt"></i>

                            <div class="list-bod">
                                <h5>Informasi Perkembangan Universitas</h5>
                                <p>
                                    Mendapatkan informasi yang berharga untuk perkembangan universitas.
                                </p>
                            </div>
                        </div>

                        <div class="single-list">
                            <i class="lni lni-search"></i>

                            <div class="list-bod">
                                <h5>Mengevaluasi Relevansi Pendidikan Tinggi</h5>
                                <p>
                                    Mengevaluasi relevansi pendidikan tinggi yang diselenggarakan, membantu
                                    untuk akreditasi universitas, dan memberikan informasi kepada mahasiswa,
                                    orang tua mahasiswa, dosen, dan tenaga kependidikan.

                                </p>
                            </div>
                        </div>

                        <div class="single-list">
                            <i class="lni lni-stats-up"></i>

                            <div class="list-bod">
                                <h5>Mengukur Pengembangan Karier</h5>
                                <p>
                                    Studi ini membantu alumni melihat sejauh mana mereka telah mencapai tujuan karier
                                    mereka dan membandingkannya dengan rekan-rekan mereka yang lulus dari institusi yang
                                    sama.
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
                            <a href="{{ route('tracerstudy-laporan') }}" class="btn">Selengkapnya</a>
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
                        <span class="wow fadeInDown" data-wow-delay=".2s">Publikasi</span>
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
                                        Laporan Tracer Study Tahun {{ $laporan->paket_soal->tahun_pelaksanaan }}
                                    </a>
                                </h4>
                                <p>
                                    {{ $laporan->deskripsi_laporan ?? 'Laporan ini ditujukan untuk melihat hasil akhir tracer study untuk lulusan ' . $laporan->paket_soal->untuk_lulusan }}
                                </p>
                                @php
                                    $fileLaporan = $laporan->getFirstMedia('laporants') ?? null;
                                @endphp
                                <div class="button buttontc">
                                    @if ($fileLaporan)
                                        <a href="{{ $fileLaporan->getUrl() ?? '' }}" target="_blank" class="btn">
                                            Selengkapnya <i class="lni lni-arrow-right"></i></a>
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
                        <a href="{{ route('tracerstudy-laporan') }}" class="btn">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal">
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
                                        <a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i>
                                            Log in with
                                            LinkedIn</a>
                                    </li>
                                    <li>
                                        <a class="google" href="#"><i class="lni lni-google"></i> Log in with
                                            Google</a>
                                    </li>
                                    <li>
                                        <a class="facebook" href="#"><i class="lni lni-facebook-original"></i>
                                            Log in with
                                            Facebook</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com"
                                        id="email" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value
                                            id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">Remember
                                            password</label>
                                    </div>
                                    <a href class="font-size-3 text-dodger line-height-reset">Forget Password</a>
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

    <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal">
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
                                        <a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i>
                                            Import from
                                            LinkedIn</a>
                                    </li>
                                    <li>
                                        <a class="google" href="#"><i class="lni lni-google"></i> Import from
                                            Google</a>
                                    </li>
                                    <li>
                                        <a class="facebook" href="#"><i class="lni lni-facebook-original"></i>
                                            Import from
                                            Facebook</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value />
                                        <label class="form-check-label" for="flexCheckDefault">Agree to the <a
                                                href="#">Terms & Conditions</a></label>
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
</x-front-office-layout>




<script type="text/javascript">
    function initializeCounterRANDOMID() {

        const options = {};

        const observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                VanillaCounter();
            });
        }, options);

        observer.observe(document.querySelector('.counter-RANDOM'));
    }

    document.addEventListener("DOMContentLoaded", function() {
        initializeCounterRANDOMID();
        $('#toLogin').click(function() {
            var selectedValue = $('#untuk_lulusan').val();

            if (selectedValue) {
                // Arahkan pengguna ke URL yang sesuai
                var redirectUrl = "{{ route('kuesioner.tracerstudy-login.create', ':alias_url') }}"
                    .replace(
                        ':alias_url', selectedValue);
                window.location.href = redirectUrl;
            }
        });

    });
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
