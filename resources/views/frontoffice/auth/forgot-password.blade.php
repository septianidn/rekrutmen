<x-front-office-layout :assets="$assets ?? []">

    <!-- Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Lupa Password</h1>
                        <p>Atur ulang kata sandi akun Anda.</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('landingpage') }}">Beranda</a></li>
                        <li>Lupa Password</li>
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

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
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
                        <h3 class="title">Lupa Password</h3>
                        <p class="text-muted mb-3">
                            Masukkan email akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang
                            kata sandi ke email tersebut.
                        </p>
                        <form action="{{ route('user.password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Kirim Tautan Reset</button>
                            </div>
                            <p class="mt-3 mb-0">
                                <a href="{{ route('landingpage') }}">&larr; Kembali ke Beranda</a>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('partials.frontoffice._auth_modals')
</x-front-office-layout>
