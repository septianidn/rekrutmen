<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Job Fair</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form action="{{ route('backoffice.job-fair.update', $jobFair) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nama Job Fair <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $jobFair->nama) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft" @selected($jobFair->status === 'draft')>Draft</option>
                                    <option value="active" @selected($jobFair->status === 'active')>Active</option>
                                    <option value="completed" @selected($jobFair->status === 'completed')>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $jobFair->deskripsi) }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $jobFair->lokasi) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $jobFair->tanggal_mulai->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $jobFair->tanggal_selesai->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kuota Lowongan</label>
                                <input type="number" name="kuota" min="1" class="form-control" value="{{ old('kuota', $jobFair->kuota) }}" placeholder="Kosongkan = tanpa batas">
                                <small class="text-muted">Maksimum jumlah lowongan (pending + disetujui) yang dapat terdaftar.</small>
                            </div>
                        </div>
                        <a href="{{ route('backoffice.job-fair.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
