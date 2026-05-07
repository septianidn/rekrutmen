<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permintaan Perubahan Profil Employer</h4>
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
                            <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                                href="{{ route('backoffice.employer-change-request.index', ['status' => 'pending']) }}">
                                Pending <span class="badge bg-warning ms-1">{{ $counts['pending'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                                href="{{ route('backoffice.employer-change-request.index', ['status' => 'approved']) }}">
                                Approved <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'declined' ? 'active' : '' }}"
                                href="{{ route('backoffice.employer-change-request.index', ['status' => 'declined']) }}">
                                Declined <span class="badge bg-danger ms-1">{{ $counts['declined'] }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Email Pendaftar</th>
                                    <th>Field yang Diubah</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $req)
                                    <tr>
                                        <td>{{ $req->employer->nama_perusahaan ?? '-' }}</td>
                                        <td>{{ $req->employer->user->email ?? '-' }}</td>
                                        <td>
                                            @foreach (array_keys($req->payload ?? []) as $key)
                                                <span class="badge bg-secondary">{{ $key }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $req->created_at?->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('backoffice.employer-change-request.show', $req) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
