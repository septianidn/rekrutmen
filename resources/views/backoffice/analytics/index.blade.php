<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">Analitik Rekrutmen — Mahasiswa/Alumni Unand</h4>
                <span class="badge bg-primary">Data real-time</span>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <p class="text-muted mb-1 small">Total Lamaran</p>
                    <h2 class="fw-bold mb-0">{{ $total }}</h2>
                    <small class="text-muted">Mahasiswa/Alumni Unand</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-center h-100 border-success border-opacity-50">
                <div class="card-body">
                    <p class="text-muted mb-1 small">Diterima</p>
                    <h2 class="fw-bold text-success mb-0">{{ $accepted }}</h2>
                    <small class="text-success">{{ $passRate }}% dari total lamaran</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-center h-100 border-warning border-opacity-50">
                <div class="card-body">
                    <p class="text-muted mb-1 small">Dalam Proses</p>
                    <h2 class="fw-bold text-warning mb-0">{{ $pending }}</h2>
                    <small class="text-muted">Sedang berjalan</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-center h-100 border-danger border-opacity-50">
                <div class="card-body">
                    <p class="text-muted mb-1 small">Tidak Diterima</p>
                    <h2 class="fw-bold text-danger mb-0">{{ $rejected }}</h2>
                    <small class="text-muted">Gugur di proses seleksi</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Pass Rate Bar --}}
    @if ($total > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-semibold">Tingkat Kelulusan Keseluruhan</span>
                        <span class="small text-muted">{{ $accepted }}/{{ $total }} diterima</span>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $passRate }}%"
                            aria-valuenow="{{ $passRate }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $total > 0 ? round($pending / $total * 100, 1) : 0 }}%">
                        </div>
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: {{ $total > 0 ? round($rejected / $total * 100, 1) : 0 }}%">
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-2">
                        <span class="small"><span class="badge bg-success">&nbsp;</span> Diterima {{ $passRate }}%</span>
                        <span class="small"><span class="badge bg-warning">&nbsp;</span> Proses {{ $total > 0 ? round($pending / $total * 100, 1) : 0 }}%</span>
                        <span class="small"><span class="badge bg-danger">&nbsp;</span> Ditolak {{ $total > 0 ? round($rejected / $total * 100, 1) : 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Per-Step Analytics --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Analitik Per Tahap Seleksi</h5>
                    <span class="text-muted small">Diurutkan berdasarkan tingkat kegagalan tertinggi</span>
                </div>
                <div class="card-body p-0">
                    @if (empty($prosesStats))
                        <div class="p-4 text-center text-muted">
                            Belum ada data seleksi untuk mahasiswa/alumni Unand.
                        </div>
                    @else
                        @php
                            $maxReached = collect($prosesStats)->max('total_reached') ?: 1;
                            $topFailedNama = collect($prosesStats)->sortByDesc('failed')->first()['nama'] ?? null;
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Tahap Seleksi</th>
                                        <th class="text-center">Total Peserta</th>
                                        <th class="text-center">
                                            <span class="text-success">Lulus</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="text-danger">Tidak Lulus</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="text-warning">Sedang Aktif</span>
                                        </th>
                                        <th class="text-center">Tingkat Kelulusan</th>
                                        <th class="pe-4" style="min-width:120px;">Proporsi Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prosesStats as $stat)
                                        @php
                                            $evaluated = $stat['passed'] + $stat['failed'];
                                            $stepPassRate = $evaluated > 0
                                                ? round($stat['passed'] / $evaluated * 100, 1)
                                                : null;
                                            $barWidth = round($stat['total_reached'] / $maxReached * 100);
                                            $isWorstStep = $topFailedNama && $stat['nama'] === $topFailedNama && $stat['failed'] > 0;
                                        @endphp
                                        <tr @if($isWorstStep) class="table-danger bg-opacity-25" @endif>
                                            <td class="ps-4">
                                                <span class="fw-semibold">{{ $stat['nama'] }}</span>
                                                @if ($isWorstStep)
                                                    <span class="badge bg-danger ms-2 small">Kegagalan tertinggi</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-semibold">{{ $stat['total_reached'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($stat['passed'] > 0)
                                                    <span class="badge bg-success">{{ $stat['passed'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($stat['failed'] > 0)
                                                    <span class="badge bg-danger">{{ $stat['failed'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($stat['currently_active'] > 0)
                                                    <span class="badge bg-warning text-dark">{{ $stat['currently_active'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($stepPassRate !== null)
                                                    @php
                                                        $rateColor = $stepPassRate >= 70 ? 'success' : ($stepPassRate >= 40 ? 'warning' : 'danger');
                                                    @endphp
                                                    <span class="badge bg-{{ $rateColor }}">{{ $stepPassRate }}%</span>
                                                @else
                                                    <span class="text-muted small">Belum dievaluasi</span>
                                                @endif
                                            </td>
                                            <td class="pe-4">
                                                <div class="progress" style="height: 8px;" title="{{ $stat['total_reached'] }} peserta">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                        style="width: {{ $barWidth }}%">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Legend / Notes --}}
                        <div class="px-4 py-3 border-top bg-light rounded-bottom">
                            <p class="small text-muted mb-0">
                                <strong>Total Peserta</strong> = jumlah pelamar yang pernah melewati tahap ini (sudah dievaluasi + sedang aktif).
                                <strong>Sedang Aktif</strong> = pelamar yang saat ini menunggu evaluasi di tahap tersebut.
                                <strong>Tingkat Kelulusan</strong> dihitung dari peserta yang sudah dievaluasi saja.
                                Data hanya mencakup mahasiswa/alumni <strong>Unand</strong>.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
