<x-front-office-layout :assets="$assets ?? []">

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Verifikasi Perusahaan</h1>
                        <p>Lengkapi data perusahaan Anda. Tim admin akan melakukan verifikasi<br>
                            sebelum Anda dapat memposting lowongan.</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('landingpage') }}">Home</a></li>
                        <li>Verifikasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="job-post section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-12">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (isset($employer) && $employer && $employer->isPending())
                        <div class="job-information">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading mb-2"><i class="lni lni-timer"></i> Menunggu Verifikasi Admin</h4>
                                <p class="mb-1">Terima kasih, data perusahaan <strong>{{ $employer->nama_perusahaan }}</strong> sudah kami terima.</p>
                                <p class="mb-0">Admin akan meninjau data Anda. Anda akan dinotifikasi begitu verifikasi selesai. Anda belum dapat memposting lowongan sampai disetujui.</p>
                            </div>
                            <dl class="row mt-4">
                                <dt class="col-sm-3">Nama Perusahaan</dt>
                                <dd class="col-sm-9">{{ $employer->nama_perusahaan }}</dd>
                                <dt class="col-sm-3">Alamat</dt>
                                <dd class="col-sm-9">{{ $employer->alamat_perusahaan }}</dd>
                                <dt class="col-sm-3">Telepon</dt>
                                <dd class="col-sm-9">{{ $employer->telp_perusahaan }}</dd>
                                <dt class="col-sm-3">Website</dt>
                                <dd class="col-sm-9">{{ $employer->website ?: '-' }}</dd>
                                <dt class="col-sm-3">Dikirim pada</dt>
                                <dd class="col-sm-9">{{ optional($employer->created_at)->format('d M Y H:i') }}</dd>
                            </dl>
                        </div>
                    @else
                        @if (isset($employer) && $employer && $employer->isRejected())
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading mb-2"><i class="lni lni-close"></i> Verifikasi Ditolak</h4>
                                <p class="mb-1">Pengajuan sebelumnya ditolak admin. Silakan perbaiki data di bawah ini dan kirim ulang.</p>
                                @if ($employer->verification_note)
                                    <hr>
                                    <p class="mb-0"><strong>Catatan admin:</strong> {{ $employer->verification_note }}</p>
                                @endif
                            </div>
                        @endif

                        <div class="job-information">
                            <h3 class="title">Lengkapi Informasi Perusahaan</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('employer.verifikasi') }}">
                                @csrf
                                <input type="hidden" value="{{ $user->id }}" name="id_user">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nama_perusahaan">Nama Perusahaan*</label>
                                            <input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan"
                                                value="{{ old('nama_perusahaan', $employer->nama_perusahaan ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Perusahaan*</label>
                                            <input type="text" name="alamat" id="alamat"
                                                value="{{ old('alamat', $employer->alamat_perusahaan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="telp">No.Telp Perusahaan*</label>
                                            <input type="text" name="telp" id="telp"
                                                value="{{ old('telp', $employer->telp_perusahaan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="id_industri_type">Tipe Industri*</label>
                                            <select class="select" name="id_industri_type" id="id_industri_type">
                                                @foreach ($industriTypes as $it)
                                                    <option value="{{ $it->id }}"
                                                        @selected(old('id_industri_type', $employer->industriType_id ?? null) == $it->id)>
                                                        {{ $it->nama_industri ?? $it->name ?? ('Industri #'.$it->id) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Perusahaan*</label>
                                            <input type="text" name="email" id="email"
                                                value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="deskripsi_perusahaan">Deskripsi Perusahaan*</label>
                                            <textarea name="deskripsi_perusahaan" class="form-control" rows="5" id="deskripsi_perusahaan">{{ old('deskripsi_perusahaan', $employer->deskripsi_perusahaan ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            Website<input type="text" name="website" id="website"
                                                value="{{ old('website', $employer->website ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 button">
                                    <button class="btn" type="submit" name="verifikasi">
                                        Kirim untuk Verifikasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

</x-front-office-layout>
