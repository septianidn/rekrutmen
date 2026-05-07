<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">Total</small>
                                    <h5 class="mb-0">{{ $counts['total'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning bg-opacity-10">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">Pending</small>
                                    <h5 class="mb-0">{{ $counts['pending'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-10">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">Lunas</small>
                                    <h5 class="mb-0">{{ $counts['lunas'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger bg-opacity-10">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">Gagal</small>
                                    <h5 class="mb-0">{{ $counts['gagal'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" class="row g-2 mb-3">
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                @foreach(['pending', 'lunas', 'gagal', 'expired'] as $s)
                                    <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                <option value="membership" {{ $kategori === 'membership' ? 'selected' : '' }}>Membership</option>
                                <option value="event" {{ $kategori === 'event' ? 'selected' : '' }}>Event</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm">Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Order ID</th>
                                    <th>Perusahaan</th>
                                    <th>Kategori</th>
                                    <th>Paket</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayarans as $p)
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                                        <td><code>{{ $p->midtrans_order_id }}</code></td>
                                        <td>{{ $p->employer->nama_perusahaan ?? '-' }}</td>
                                        <td>{{ ucfirst($p->kategori) }}</td>
                                        <td>{{ $p->membership->nama_membership ?? '-' }}</td>
                                        <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $cls = match($p->status) {
                                                    'lunas'   => 'success',
                                                    'pending' => 'warning',
                                                    'gagal'   => 'danger',
                                                    'expired' => 'secondary',
                                                    default   => 'light',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $cls }}">{{ ucfirst($p->status) }}</span>
                                        </td>
                                        <td>
                                            @if($p->tgl_mulai && $p->tgl_berakhir)
                                                <small>{{ $p->tgl_mulai->format('d M Y') }} &mdash; {{ $p->tgl_berakhir->format('d M Y') }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $pembayarans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
