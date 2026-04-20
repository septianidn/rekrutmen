<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mb-1">{{ $job->nama_pekerjaan }}</h4>
                        <p class="text-muted mb-0">
                            {{ $job->posisi }} &middot; {{ $job->employer->nama_perusahaan ?? '-' }}
                        </p>
                    </div>
                    <div>
                        @if($job->trashed())
                            <span class="badge bg-dark">Terhapus</span>
                        @elseif($job->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Ditutup</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Lokasi:</strong> {{ $job->alamat }}</div>
                        <div class="col-md-4"><strong>Tipe:</strong> {{ $job->worktime }}</div>
                        <div class="col-md-4"><strong>Gaji:</strong> {{ $job->ekspektasi_gaji }}</div>
                        <div class="col-md-4 mt-2"><strong>Deadline:</strong>
                            {{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') : '-' }}
                        </div>
                        @if($job->trashed())
                            <div class="col-md-4 mt-2"><strong>Dihapus pada:</strong>
                                {{ $job->deleted_at->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>

                    <h6>Deskripsi</h6>
                    <p>{{ $job->deskripsi_pekerjaan }}</p>

                    <h6>Requirement</h6>
                    <p>{{ $job->requirement }}</p>

                    @if($job->steps->isNotEmpty())
                        <h6>Tahap Seleksi</h6>
                        <ol>
                            @foreach($job->steps as $step)
                                <li>{{ $step->proses->nama ?? '-' }} @if($step->deskripsi)<span class="text-muted">— {{ $step->deskripsi }}</span>@endif</li>
                            @endforeach
                        </ol>
                    @endif

                    <h6 class="mt-3">Pelamar ({{ $job->applications->count() }})</h6>
                    @if($job->applications->isEmpty())
                        <p class="text-muted">Belum ada pelamar.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Apply</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job->applications as $app)
                                    <tr>
                                        <td>{{ $app->jobseeker ? trim(($app->jobseeker->first_name ?? '').' '.($app->jobseeker->last_name ?? '')) ?: '-' : '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($app->tanggal_apply)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($app->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif($app->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('backoffice.job.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        @if($job->trashed())
                            <form action="{{ route('backoffice.job.restore', $job->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm">Pulihkan</button>
                            </form>
                        @else
                            <form action="{{ route('backoffice.job.destroy', $job->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus lowongan ini? Riwayat lamaran tetap tersimpan (soft delete).')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
