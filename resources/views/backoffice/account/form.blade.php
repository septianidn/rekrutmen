<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $mode === 'create' ? 'Tambah Rekening Bank' : 'Edit Rekening Bank' }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ $mode === 'create' ? route('backoffice.account.store') : route('backoffice.account.update', $account) }}">
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $account->nama_bank) }}" required maxlength="100" placeholder="contoh: Bank Nagari, BNI, Mandiri">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control" value="{{ old('nomor_rekening', $account->nomor_rekening) }}" required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik', $account->nama_pemilik) }}" required maxlength="150" placeholder="contoh: Pusat Karir Universitas Andalas">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
                                    {{ old('is_active', $account->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktifkan rekening ini (tampil ke employer saat checkout manual)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backoffice.account.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
