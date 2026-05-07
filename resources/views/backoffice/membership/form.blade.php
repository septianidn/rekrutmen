<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $mode === 'create' ? 'Tambah Paket Membership' : 'Edit Paket Membership' }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ $mode === 'create' ? route('backoffice.membership.store') : route('backoffice.membership.update', $membership) }}">
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="nama_membership" class="form-control" value="{{ old('nama_membership', $membership->nama_membership) }}" required maxlength="50">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="{{ old('harga', $membership->harga) }}" required min="0" step="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Durasi (hari)</label>
                                <input type="number" name="durasi_hari" class="form-control" value="{{ old('durasi_hari', $membership->durasi_hari ?? 365) }}" required min="1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kapabilitas</label>
                            <div class="form-check">
                                <input type="checkbox" name="can_post_job" id="can_post_job" value="1" class="form-check-input"
                                    {{ old('can_post_job', $membership->can_post_job) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_post_job">Dapat memposting lowongan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="can_post_article" id="can_post_article" value="1" class="form-check-input"
                                    {{ old('can_post_article', $membership->can_post_article) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_post_article">Dapat memposting artikel</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" maxlength="1000">{{ old('deskripsi', $membership->deskripsi) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backoffice.membership.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
