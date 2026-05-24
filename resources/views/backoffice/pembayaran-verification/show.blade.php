<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Pembayaran</h4>
                    <a href="{{ route('backoffice.pembayaran-verification.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <table class="table table-borderless">
                        <tr><th width="200">Order ID</th><td><code>{{ $pembayaran->midtrans_order_id }}</code></td></tr>
                        <tr><th>Status</th>
                            <td>
                                @php
                                    [$bg, $label] = match($pembayaran->status) {
                                        'awaiting_verification' => ['warning', 'Menunggu Verifikasi'],
                                        'lunas'                 => ['success', 'Lunas'],
                                        'gagal'                 => ['danger',  'Ditolak'],
                                        default                 => ['secondary', ucfirst($pembayaran->status)],
                                    };
                                @endphp
                                <span class="badge bg-{{ $bg }}">{{ $label }}</span>
                            </td>
                        </tr>
                        <tr><th>Tanggal Submit</th><td>{{ $pembayaran->created_at->format('d M Y H:i') }}</td></tr>
                        <tr><th>Employer</th>
                            <td>
                                <strong>{{ $pembayaran->employer->nama_perusahaan ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $pembayaran->employer->user->email ?? '-' }}</small>
                            </td>
                        </tr>
                        <tr><th>Paket Membership</th><td>{{ $pembayaran->membership->nama_membership ?? '-' }} ({{ $pembayaran->membership->durasi_hari ?? '-' }} hari)</td></tr>
                        <tr><th>Jumlah</th><td><strong>Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</strong></td></tr>
                        <tr><th>Rekening Tujuan</th>
                            <td>
                                @if($pembayaran->account)
                                    {{ $pembayaran->account->nama_bank }} —
                                    <code>{{ $pembayaran->account->nomor_rekening }}</code>
                                    <br><small>a.n. {{ $pembayaran->account->nama_pemilik }}</small>
                                @else
                                    <small class="text-muted">—</small>
                                @endif
                            </td>
                        </tr>
                        @if($pembayaran->verified_at)
                            <tr><th>Diproses</th>
                                <td>
                                    {{ $pembayaran->verified_at->format('d M Y H:i') }}
                                    @if($pembayaran->verifier)
                                        <br><small class="text-muted">oleh {{ $pembayaran->verifier->name ?? $pembayaran->verifier->email }}</small>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if($pembayaran->admin_note)
                            <tr><th>Catatan Admin</th><td>{{ $pembayaran->admin_note }}</td></tr>
                        @endif
                        @if($pembayaran->tgl_mulai && $pembayaran->tgl_berakhir)
                            <tr><th>Masa Berlaku</th><td>{{ $pembayaran->tgl_mulai->format('d M Y') }} — {{ $pembayaran->tgl_berakhir->format('d M Y') }}</td></tr>
                        @endif
                    </table>

                    @if($pembayaran->isAwaitingVerification())
                        <hr>
                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST" action="{{ route('backoffice.pembayaran-verification.approve', $pembayaran) }}"
                                  onsubmit="return confirm('Setujui pembayaran ini? Membership akan langsung aktif.')">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="lni lni-checkmark-circle me-1"></i> Setujui & Aktifkan Membership
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#reject-form">
                                <i class="lni lni-close me-1"></i> Tolak Pembayaran
                            </button>
                        </div>

                        <div class="collapse mt-3" id="reject-form">
                            <form method="POST" action="{{ route('backoffice.pembayaran-verification.reject', $pembayaran) }}">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Alasan Penolakan</label>
                                    <textarea name="admin_note" class="form-control" rows="3" required maxlength="1000" placeholder="contoh: Nominal transfer tidak sesuai, bukti tidak terbaca, dll."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm">Konfirmasi Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bukti Transfer</h5>
                </div>
                <div class="card-body text-center">
                    @if($pembayaran->bukti_transfer)
                        @php $ext = strtolower(pathinfo($pembayaran->bukti_transfer, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                            <img src="{{ route('backoffice.pembayaran-verification.bukti', $pembayaran) }}"
                                 alt="Bukti transfer" class="img-fluid border rounded" style="max-height: 600px;">
                        @else
                            <p class="text-muted">Bukti berupa file {{ strtoupper($ext) }}.</p>
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('backoffice.pembayaran-verification.bukti', $pembayaran) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="lni lni-eye me-1"></i> Buka di Tab Baru
                            </a>
                        </div>
                    @else
                        <p class="text-muted mb-0">Bukti sudah dihapus.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
