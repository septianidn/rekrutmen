<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Rekening Bank Pusat Karir</h4>
                        <small class="text-muted">Rekening tujuan transfer untuk pembayaran membership secara manual.</small>
                    </div>
                    <a href="{{ route('backoffice.account.create') }}" class="btn btn-primary btn-sm">Tambah Rekening</a>
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
                                    <th>Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Atas Nama</th>
                                    <th>Status</th>
                                    <th>Dipakai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($accounts as $a)
                                    <tr>
                                        <td>{{ $a->nama_bank }}</td>
                                        <td><code>{{ $a->nomor_rekening }}</code></td>
                                        <td>{{ $a->nama_pemilik }}</td>
                                        <td>
                                            @if($a->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $a->pembayarans_count }} pembayaran</td>
                                        <td>
                                            <a href="{{ route('backoffice.account.edit', $a) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('backoffice.account.destroy', $a) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rekening ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">Belum ada rekening terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $accounts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
