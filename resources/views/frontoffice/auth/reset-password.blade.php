<x-front-office-layout :assets="$assets ?? []">

    <!-- Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Atur Ulang Password</h1>
                        <p>Buat kata sandi baru untuk akun Anda.</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('landingpage') }}">Beranda</a></li>
                        <li>Atur Ulang Password</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="job-post section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="job-information">
                        <h3 class="title">Atur Ulang Password</h3>
                        <p class="text-muted mb-3">
                            Masukkan kata sandi baru untuk akun <strong>{{ $request->email }}</strong>.
                        </p>
                        <form action="{{ route('user.password.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{ $request->email }}">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Minimal 8 karakter" required minlength="8" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Ulangi kata sandi" required minlength="8">
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Simpan Password Baru</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('partials.frontoffice._auth_modals')
</x-front-office-layout>
