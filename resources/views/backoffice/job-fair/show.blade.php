<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ $jobFair->nama }}</h4>
                        <p class="text-muted mb-0">{{ $jobFair->lokasi }} &middot; {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}</p>
                    </div>
                    <div>
                        @if($jobFair->status === 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @elseif($jobFair->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-info">Completed</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($jobFair->deskripsi)
                        <p>{{ $jobFair->deskripsi }}</p>
                        <hr>
                    @endif

                    <h5>Peserta ({{ $jobFair->jobs->count() }} lowongan terdaftar)</h5>

                    @if($jobFair->jobs->isEmpty())
                        <div class="alert alert-info">Belum ada employer yang mendaftar.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Perusahaan</th>
                                        <th>Lowongan</th>
                                        <th>Posisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobFair->jobs as $job)
                                    <tr>
                                        <td>{{ $job->employer->nama_perusahaan ?? '-' }}</td>
                                        <td>{{ $job->nama_pekerjaan }}</td>
                                        <td>{{ $job->posisi?->nama_posisi }}</td>
                                        <td>
                                            @if($job->pivot->status === 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($job->pivot->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($job->pivot->status === 'pending')
                                                <form action="{{ route('backoffice.job-fair.participant.update', [$jobFair, $job->pivot->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('backoffice.job-fair.participant.update', [$jobFair, $job->pivot->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            @else
                                                <form action="{{ route('backoffice.job-fair.participant.update', [$jobFair, $job->pivot->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Reset</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <a href="{{ route('backoffice.job-fair.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
