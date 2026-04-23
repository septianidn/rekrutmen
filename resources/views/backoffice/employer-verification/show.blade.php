<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Pengajuan Employer</h4>
                    <a href="{{ route('backoffice.employer-verification.index', ['status' => $employer->verification_status]) }}"
                        class="btn btn-secondary btn-sm">&larr; Kembali</a>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if ($employer->verification_status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($employer->verification_status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Nama Perusahaan</dt>
                        <dd class="col-sm-8">{{ $employer->nama_perusahaan }}</dd>

                        <dt class="col-sm-4">Email Akun</dt>
                        <dd class="col-sm-8">{{ $employer->user->email ?? '-' }}</dd>

                        <dt class="col-sm-4">Tipe Industri</dt>
                        <dd class="col-sm-8">{{ $employer->industriType->nama_industri ?? '-' }}</dd>

                        <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8">{{ $employer->alamat_perusahaan ?? '-' }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">{{ $employer->telp_perusahaan ?? '-' }}</dd>

                        <dt class="col-sm-4">Website</dt>
                        <dd class="col-sm-8">{{ $employer->website ?: '-' }}</dd>

                        <dt class="col-sm-4">Deskripsi</dt>
                        <dd class="col-sm-8">{{ $employer->deskripsi_perusahaan }}</dd>

                        <dt class="col-sm-4">Dokumen Legalitas</dt>
                        <dd class="col-sm-8">
                            @if($employer->dokumen_legalitas)
                                <a href="{{ route('backoffice.employer-verification.dokumen', $employer) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-file"></i> Buka Dokumen
                                </a>
                            @else
                                <span class="text-muted">Tidak ada dokumen</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Tgl Pengajuan</dt>
                        <dd class="col-sm-8">{{ $employer->created_at?->format('d M Y H:i') }}</dd>

                        @if ($employer->verified_at)
                            <dt class="col-sm-4">Diverifikasi pada</dt>
                            <dd class="col-sm-8">{{ $employer->verified_at->format('d M Y H:i') }}</dd>
                        @endif

                        @if ($employer->verifier)
                            <dt class="col-sm-4">Diverifikasi oleh</dt>
                            <dd class="col-sm-8">{{ $employer->verifier->email }}</dd>
                        @endif

                        @if ($employer->verification_note)
                            <dt class="col-sm-4">Catatan Admin</dt>
                            <dd class="col-sm-8">{{ $employer->verification_note }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if ($employer->verification_status === 'pending')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tindakan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backoffice.employer-verification.approve', $employer) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-3"
                                onclick="return confirm('Setujui pengajuan employer ini?')">
                                <i class="fa fa-check"></i> Setujui
                            </button>
                        </form>

                        <hr>

                        <form action="{{ route('backoffice.employer-verification.reject', $employer) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="verification_note">Alasan Penolakan*</label>
                                <textarea name="verification_note" id="verification_note" rows="4"
                                    class="form-control @error('verification_note') is-invalid @enderror" required>{{ old('verification_note') }}</textarea>
                                @error('verification_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Tolak pengajuan employer ini?')">
                                <i class="fa fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
