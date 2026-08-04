<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Permintaan Perubahan</h4>
                    <a href="{{ route('backoffice.employer-change-request.index', ['status' => $changeRequest->status]) }}"
                        class="btn btn-secondary btn-sm">&larr; Kembali</a>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if ($changeRequest->status === 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($changeRequest->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Declined</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Perusahaan</dt>
                        <dd class="col-sm-8">{{ $changeRequest->employer->nama_perusahaan }}</dd>

                        <dt class="col-sm-4">Email Akun</dt>
                        <dd class="col-sm-8">{{ $changeRequest->employer->user->email ?? '-' }}</dd>

                        <dt class="col-sm-4">Alasan Pengajuan</dt>
                        <dd class="col-sm-8">{{ $changeRequest->reason }}</dd>

                        <dt class="col-sm-4">Tgl Pengajuan</dt>
                        <dd class="col-sm-8">{{ $changeRequest->created_at?->format('d M Y H:i') }}</dd>

                        @if ($changeRequest->reviewed_at)
                            <dt class="col-sm-4">Ditinjau pada</dt>
                            <dd class="col-sm-8">{{ $changeRequest->reviewed_at->format('d M Y H:i') }}</dd>
                        @endif

                        @if ($changeRequest->reviewer)
                            <dt class="col-sm-4">Ditinjau oleh</dt>
                            <dd class="col-sm-8">{{ $changeRequest->reviewer->email }}</dd>
                        @endif

                        @if ($changeRequest->admin_note)
                            <dt class="col-sm-4">Catatan Admin</dt>
                            <dd class="col-sm-8">{{ $changeRequest->admin_note }}</dd>
                        @endif
                    </dl>

                    <hr>
                    <h5 class="mb-3">Perubahan yang Diajukan</h5>

                    @if (empty($diff))
                        <p class="text-muted">Tidak ada perubahan pada field yang membutuhkan persetujuan.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Field</th>
                                        <th style="width: 40%">Saat Ini</th>
                                        <th style="width: 40%">Diajukan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diff as $field => $values)
                                        <tr>
                                            <td><code>{{ $field }}</code></td>
                                            <td>
                                                @if ($field === 'logo')
                                                    @if ($values['current'])
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($values['current']) }}"
                                                            alt="Logo saat ini" style="max-height: 80px;">
                                                    @else
                                                        <span class="text-muted">Tidak ada</span>
                                                    @endif
                                                @elseif ($field === 'dokumen_legalitas')
                                                    @if ($values['current'])
                                                        <a href="{{ route('backoffice.employer-verification.dokumen', $changeRequest->employer) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fa fa-file"></i> Buka Dokumen Saat Ini
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada</span>
                                                    @endif
                                                @else
                                                    {{ $values['current'] ?: '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($field === 'logo')
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($values['proposed']) }}"
                                                        alt="Logo diajukan" style="max-height: 80px;">
                                                @elseif ($field === 'dokumen_legalitas')
                                                    <a href="{{ route('backoffice.employer-change-request.dokumen', $changeRequest) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-file"></i> Buka Dokumen Diajukan
                                                    </a>
                                                @else
                                                    <strong>{{ $values['proposed'] }}</strong>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if ($changeRequest->isPending())
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tindakan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backoffice.employer-change-request.approve', $changeRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-3"
                                onclick="return confirm('Setujui dan terapkan perubahan ini?')">
                                <i class="fa fa-check"></i> Setujui
                            </button>
                        </form>

                        <hr>

                        <form action="{{ route('backoffice.employer-change-request.decline', $changeRequest) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="admin_note">Alasan Penolakan*</label>
                                <textarea name="admin_note" id="admin_note" rows="4"
                                    class="form-control @error('admin_note') is-invalid @enderror" required>{{ old('admin_note') }}</textarea>
                                @error('admin_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Tolak permintaan perubahan ini?')">
                                <i class="fa fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
