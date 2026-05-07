<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $mode === 'create' ? 'Tambah Kontrak Mitra' : 'Edit Kontrak Mitra' }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ $mode === 'create' ? route('backoffice.employer-contract.store') : route('backoffice.employer-contract.update', $contract) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        @if($mode === 'create')
                            <div class="mb-3">
                                <label class="form-label">Perusahaan</label>
                                <select name="employer_id" class="form-select" required>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    @foreach($employers as $emp)
                                        <option value="{{ $emp->id }}" {{ old('employer_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->nama_perusahaan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Perusahaan</label>
                                <input type="text" class="form-control" value="{{ $contract->employer->nama_perusahaan }}" disabled>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control"
                                    value="{{ old('tanggal_mulai', optional($contract->tanggal_mulai)->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="form-control"
                                    value="{{ old('tanggal_berakhir', optional($contract->tanggal_berakhir)->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">File MoU (PDF, max 10 MB)</label>
                            <input type="file" name="mou_file" class="form-control" accept="application/pdf"
                                {{ $mode === 'create' ? 'required' : '' }}>
                            @if($mode === 'edit' && $contract->mou_file)
                                <small class="text-muted">
                                    File saat ini:
                                    <a href="{{ route('backoffice.employer-contract.mou', $contract) }}" target="_blank">unduh</a>.
                                    Kosongkan jika tidak ingin mengganti.
                                </small>
                            @endif
                        </div>

                        @if($mode === 'edit')
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $contract->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="expired" {{ $contract->status === 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                                    <option value="revoked" {{ $contract->status === 'revoked' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3" maxlength="1000">{{ old('catatan', $contract->catatan) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backoffice.employer-contract.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
