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
                  @php
                    $karirActive = request()->routeIs('vacancy') ||
                                   request()->routeIs('artikel.*') ||
                                   request()->routeIs('employer.job.index') ||
                                   request()->routeIs('jobseeker.jobs');
                  @endphp
                  <li class="nav-item">
                    <a href="#" class="{{ $karirActive ? 'active' : '' }}">Karir</a>
                    <ul class="sub-menu">
                      <li><a href="@auth @if(auth()->user()->hasRole('employer')){{ route('employer.job.index') }}@elseif(auth()->user()->hasRole('mahasiswa')){{ route('jobseeker.jobs') }}@else{{ route('vacancy') }}@endif @else{{ route('vacancy') }}@endauth" class="{{ $karirActive ? 'active' : '' }}">Vacancy</a></li>
                      <li><a href="#">Test Call</a></li>
                      <li><a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel.*') ? 'active' : '' }}">Article</a></li>
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
                    <a href="#">Kontak</a>
                  </li>

                  {{-- Auth items — inside the ul so they share the same padding:30px 0 and avoid hover bleed --}}
                  @if (!Auth::check())
                    <li class="nav-item nav-auth-item">
                      <a href="javascript:" data-toggle="modal" data-target="#login" class="nav-masuk">
                        <i class="lni lni-lock-alt"></i> Masuk
                      </a>
                    </li>
                    <li class="nav-item nav-auth-item">
                      <a href="javascript:" data-toggle="modal" data-target="#signup" class="nav-daftar">
                        Daftar
                      </a>
                    </li>
                  @else
                    <li class="nav-item nav-auth-item nav-auth-loggedin">
                      {{-- Notification Bell --}}
                      <div class="dropdown nav-notif-wrap">
                        <a href="#" class="position-relative nav-notif-trigger" id="frontNotifDrop" data-bs-toggle="dropdown">
                          <i class="lni lni-alarm"></i>
                          @if($notifCount > 0)
                            <span class="position-absolute translate-middle badge rounded-pill bg-danger border border-light" style="top: 18px; left: 90%; font-size: 11px;">{{ $notifCount }}</span>
                          @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0 shadow" style="width: min(340px, calc(100vw - 30px)); max-height: 400px;" aria-labelledby="frontNotifDrop">
                          <div class="d-flex justify-content-between align-items-center bg-primary text-white p-3">
                            <strong>Notifikasi ({{ $notifCount }})</strong>
                            @if($notifCount > 0)
                              <form action="{{ route('notification.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light py-0 px-2">Tandai dibaca</button>
                              </form>
                            @endif
                          </div>
                          <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($notifications as $notif)
                              <a href="{{ route('notification.read', $notif->id) }}" class="dropdown-item py-2 border-bottom {{ !$notif->is_read ? 'bg-light' : '' }}" style="white-space: normal;">
                                <strong class="d-block" style="font-size: 13px;">{{ $notif->title }}</strong>
                                <small class="text-muted">{{ Str::limit($notif->message, 60) }}</small>
                                <small class="text-muted d-block">{{ $notif->created_at->diffForHumans() }}</small>
                              </a>
                            @empty
                              <div class="p-3 text-center text-muted">Tidak ada notifikasi.</div>
                            @endforelse
                          </div>
                        </div>
                      </div>

                      <form action="{{ auth()->user()->hasRole('employer') ? route('employer.logout') : route('.user.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm nav-logout-btn">Logout</button>
                      </form>
                    </li>
                  @endif

                </ul>
              </div>
              <!-- navbar collapse -->

            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>
