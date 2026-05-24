<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Verifikasi Pembayaran Manual</h4>
                    <small class="text-muted">Pembayaran membership via transfer bank yang menunggu persetujuan.</small>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-3">
                        @php
                            $tabs = [
                                'awaiting_verification' => ['label' => 'Menunggu', 'badge' => 'warning'],
                                'lunas'                 => ['label' => 'Disetujui', 'badge' => 'success'],
                                'gagal'                 => ['label' => 'Ditolak',  'badge' => 'danger'],
                            ];
                        @endphp
                        @foreach($tabs as $key => $meta)
                            <li class="nav-item">
                                <a class="nav-link {{ $status === $key ? 'active' : '' }}"
                                   href="{{ route('backoffice.pembayaran-verification.index', ['status' => $key]) }}">
                                    {{ $meta['label'] }}
                                    <span class="badge bg-{{ $meta['badge'] }} ms-1">{{ $counts[$key] ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Employer</th>
                                    <th>Paket</th>
                                    <th>Jumlah</th>
                                    <th>Rekening Tujuan</th>
                                    <th>Bukti</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayarans as $p)
                                    <tr>
                                        <td>
                                            <small>{{ $p->created_at->format('d M Y H:i') }}</small>
                                            @if($p->verified_at)
                                                <br><small class="text-muted">diproses {{ $p->verified_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $p->employer->nama_perusahaan ?? '-' }}
                                            <br><small class="text-muted">{{ $p->employer->user->email ?? '-' }}</small>
                                        </td>
                                        <td>{{ $p->membership->nama_membership ?? '-' }}</td>
                                        <td><strong>Rp {{ number_format($p->amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            @if($p->account)
                                                <small>{{ $p->account->nama_bank }}<br>{{ $p->account->nomor_rekening }}</small>
                                            @else
                                                <small class="text-muted">—</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->bukti_transfer)
                                                <a href="{{ route('backoffice.pembayaran-verification.bukti', $p) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="lni lni-eye"></i> Lihat
                                                </a>
                                            @else
                                                <small class="text-muted">—</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('backoffice.pembayaran-verification.show', $p) }}" class="btn btn-primary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">Tidak ada data.</td></tr>
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
