<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Kontrak Mitra Kerja</h4>
                    <div>
                        <a href="{{ route('backoffice.employer-contract.edit', $contract) }}" class="btn btn-warning btn-sm">Edit</a>
                        @if($contract->status === 'active')
                            <form method="POST" action="{{ route('backoffice.employer-contract.revoke', $contract) }}" class="d-inline"
                                onsubmit="return confirm('Batalkan status mitra kerja perusahaan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Perusahaan</th>
                            <td>{{ $contract->employer->nama_perusahaan }}</td>
                        </tr>
                        <tr>
                            <th>Email Pendaftar</th>
                            <td>{{ $contract->employer->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>{{ $contract->tanggal_mulai->format('d M Y') }} &mdash; {{ $contract->tanggal_berakhir->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $cls = match($contract->status) {
                                        'active' => 'success',
                                        'expired' => 'secondary',
                                        'revoked' => 'danger',
                                    };
                                @endphp
                                <span class="badge bg-{{ $cls }}">{{ ucfirst($contract->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>MoU</th>
                            <td>
                                @if($contract->mou_file)
                                    <a href="{{ route('backoffice.employer-contract.mou', $contract) }}" target="_blank" class="btn btn-info btn-sm">Unduh PDF</a>
                                @else
                                    <em class="text-muted">Tidak ada file</em>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $contract->catatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $contract->created_at->format('d M Y H:i') }} oleh {{ $contract->creator->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
