<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Verifikasi Employer</h4>
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
                                href="{{ route('backoffice.employer-verification.index', ['status' => 'pending']) }}">
                                Pending <span class="badge bg-warning ms-1">{{ $counts['pending'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                                href="{{ route('backoffice.employer-verification.index', ['status' => 'approved']) }}">
                                Approved <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                                href="{{ route('backoffice.employer-verification.index', ['status' => 'rejected']) }}">
                                Rejected <span class="badge bg-danger ms-1">{{ $counts['rejected'] }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Email Pendaftar</th>
                                    <th>Industri</th>
                                    <th>Telepon</th>
                                    <th>Tgl Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employers as $emp)
                                    <tr>
                                        <td>{{ $emp->nama_perusahaan }}</td>
                                        <td>{{ $emp->user->email ?? '-' }}</td>
                                        <td>{{ $emp->industriType->nama_industri ?? '-' }}</td>
                                        <td>{{ $emp->telp_perusahaan ?? '-' }}</td>
                                        <td>{{ $emp->created_at?->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('backoffice.employer-verification.show', $emp) }}"
                                                class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $employers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
