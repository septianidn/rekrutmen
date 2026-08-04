<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Kontrak Mitra Kerja</h4>
                    <a href="{{ route('backoffice.employer-contract.create') }}" class="btn btn-primary btn-sm">Tambah Kontrak</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'active' ? 'active' : '' }}" href="{{ route('backoffice.employer-contract.index', ['status' => 'active']) }}">
                                Aktif <span class="badge bg-success ms-1">{{ $counts['active'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'expired' ? 'active' : '' }}" href="{{ route('backoffice.employer-contract.index', ['status' => 'expired']) }}">
                                Kedaluwarsa <span class="badge bg-secondary ms-1">{{ $counts['expired'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'revoked' ? 'active' : '' }}" href="{{ route('backoffice.employer-contract.index', ['status' => 'revoked']) }}">
                                Dibatalkan <span class="badge bg-danger ms-1">{{ $counts['revoked'] }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Hak Kontrak</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Dibuat oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contracts as $c)
                                    <tr>
                                        <td>{{ $c->employer->nama_perusahaan ?? '-' }}</td>
                                        <td>
                                            @if($c->can_post_job)
                                                <span class="badge bg-primary">Lowongan</span>
                                            @endif
                                            @if($c->can_post_article)
                                                <span class="badge bg-info">Artikel</span>
                                            @endif
                                        </td>
                                        <td>{{ $c->tanggal_mulai->format('d M Y') }}</td>
                                        <td>{{ $c->tanggal_berakhir->format('d M Y') }}</td>
                                        <td>{{ $c->creator->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('backoffice.employer-contract.show', $c) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $contracts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
