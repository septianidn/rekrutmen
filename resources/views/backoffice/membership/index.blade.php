<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Paket Membership</h4>
                    <a href="{{ route('backoffice.membership.create') }}" class="btn btn-primary btn-sm">Tambah Paket</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Paket</th>
                                    <th>Harga</th>
                                    <th>Durasi</th>
                                    <th>Lowongan</th>
                                    <th>Artikel</th>
                                    <th>Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($memberships as $m)
                                    <tr>
                                        <td>{{ $m->nama_membership }}</td>
                                        <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                                        <td>{{ $m->durasi_hari }} hari</td>
                                        <td>
                                            @if($m->can_post_job)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($m->can_post_article)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td>{{ $m->pembayarans_count }}</td>
                                        <td>
                                            <a href="{{ route('backoffice.membership.edit', $m) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('backoffice.membership.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">Belum ada paket.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $memberships->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
