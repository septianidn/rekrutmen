<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Kelola Job Fair</h4>
                    <a href="{{ route('backoffice.job-fair.create') }}" class="btn btn-primary btn-sm">+ Tambah Job Fair</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobFairs as $fair)
                                <tr>
                                    <td>{{ $fair->nama }}</td>
                                    <td>{{ $fair->lokasi }}</td>
                                    <td>{{ $fair->tanggal_mulai->format('d/m/Y') }} - {{ $fair->tanggal_selesai->format('d/m/Y') }}</td>
                                    <td>
                                        @if($fair->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($fair->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-info">Completed</span>
                                        @endif
                                    </td>
                                    <td>{{ $fair->jobs()->count() }}</td>
                                    <td>
                                        <a href="{{ route('backoffice.job-fair.show', $fair) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('backoffice.job-fair.edit', $fair) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('backoffice.job-fair.destroy', $fair) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus job fair ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted">Belum ada job fair.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
