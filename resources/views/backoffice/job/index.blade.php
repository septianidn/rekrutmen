<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="card-title mb-0">Kelola Lowongan</h4>
                    <form method="GET" action="{{ route('backoffice.job.index') }}" class="d-flex gap-2">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm"
                               placeholder="Cari pekerjaan, posisi, perusahaan..." style="min-width: 260px;">
                        <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
                    </form>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-3">
                        @foreach([
                            'all' => 'Semua',
                            'active' => 'Aktif',
                            'closed' => 'Ditutup',
                            'trashed' => 'Terhapus',
                        ] as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $filter === $key ? 'active' : '' }}"
                                   href="{{ route('backoffice.job.index', ['filter' => $key, 'q' => $search]) }}">
                                    {{ $label }}
                                    <span class="badge bg-secondary ms-1">{{ $counts[$key] ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Lowongan</th>
                                    <th>Perusahaan</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Pelamar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('backoffice.job.show', $job->id) }}"><strong>{{ $job->nama_pekerjaan }}</strong></a>
                                        <div class="text-muted small">{{ $job->posisi }}</div>
                                    </td>
                                    <td>{{ $job->employer->nama_perusahaan ?? '-' }}</td>
                                    <td>{{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($job->trashed())
                                            <span class="badge bg-dark">Terhapus</span>
                                        @elseif($job->status === 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Ditutup</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->applications_count }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('backoffice.job.show', $job->id) }}" class="btn btn-info btn-sm">Detail</a>
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
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada lowongan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
