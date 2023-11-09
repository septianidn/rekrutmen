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
                    {{-- <a href="{{ route('tracerstudy') }}" class="{{ request()->routeIs('tracerstudy') ? 'active' : '' }}">Tracer Study</a> --}}
                    <a href="">Tracer Study</a>
                </li>
                  <li class="nav-item">
                    <a href="#">Konseling </a>
                  </li>
                  <li class="nav-item">
                    <a href="#">Publikasi</a>
                    <ul class="sub-menu">
                      {{-- <li>
                        <a href="{{ route('tracerstudy-laporan') }}" class="{{ request()->routeIs('tracerstudy-laporan') ? 'active' : '' }}">Laporan Tracer Study</a>
                      </li> --}}
                     
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
