<?php
$data = $data ?? null;

use App\Models\FakultasProdi;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Jenjang;

$prodiOptions = Prodi::with('fakultas', 'jenjang')->get();

?>
@if (isset($data))
    {!! Form::model($data, [
        'route' => ['backoffice.databasealumni.update', $data->nim],
        'method' => 'patch',
        'enctype' => 'multipart/form-data',
        'id' => 'formAlumni',
    ]) !!}
@else
    {!! Form::open([
        'route' => ['backoffice.databasealumni.store'],
        'method' => 'post',
        'enctype' => 'multipart/form-data',
        'id' => 'formAlumni',
    ]) !!}
@endif

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-label" for="nim">NIM <span class="text-danger">*</span></label>
        {{ Form::number('nim', old('nim'), ['class' => 'form-control', 'placeholder' => 'Nim', 'id' => 'nim']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="nama">Nama <span class="text-danger">*</span></label>
        {{ Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Nama', 'id' => 'nama']) }}
    </div>

</div>
<div class="row">
    <div class="form-group col-6">
        <label class="form-label" for="tempat_lahir">Tempat Lahir</span></label>
        {{ Form::text('tempat_lahir', old('tempat_lahir'), ['class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'id' => 'tempat_lahir']) }}
    </div>

    <div class="form-group col-6">
        <label class="form-label" for="tanggal_lahir">Tanggal Lahir </label>
        {{ Form::date('tanggal_lahir', old('tanggal_lahir'), ['class' => 'form-control', 'placeholder' => 'Tanggal Lahir', 'id' => 'tanggal_lahir']) }}
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
        {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="nomor_handphone">Nomor Handphone</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">+62</span>
            </div>
            {{ Form::number('nomor_handphone', old('nomor_handphone'), ['class' => 'form-control', 'placeholder' => 'Nomor Handphone', 'id' => 'nomor_handphone']) }}
        </div>

    </div>
</div>
<div class="row">

    <div class="form-group col-md-4">
        <label class="form-label" for="pin">PIN </label>
        {{ Form::text('pin', old('pin'), ['class' => 'form-control', 'placeholder' => 'PIN', 'id' => 'pin']) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="thn_masuk">Tahun Masuk <span class="text-danger">*</span></label>
        {{ Form::number('thn_masuk', old('thn_masuk'), ['class' => 'form-control', 'min' => '1990', 'id' => 'thn_masuk', 'placeholder' => 'Tahun Masuk']) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="thn_lulus">Tahun Keluar <span class="text-danger">*</span></label>
        {{ Form::number('thn_lulus', old('thn_lulus'), ['class' => 'form-control', 'min' => '1990', 'placeholder' => 'Tahun Lulus', 'id' => 'thn_lulus']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label class="form-label" for="prodi">Prodi <span class="text-danger">*</span></label>
        {{ Form::select(
            'kode_prodi_id',
            $prodiOptions->map(function ($item) {
                    return [
                        'id' => $item->kode_prodi,
                        'text' => $item->nama_prodi . ' ' . $item->jenjang->nama_jenjang,
                    ];
                })->pluck('text', 'id'),
            old('kode_prodi_id'),
            ['class' => 'form-control', 'id' => 'kode_prodi_id', 'placeholder' => 'Pilih Prodi'],
        ) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="tipe_masuk">Jalur Masuk </label>
        {{ Form::select(
            'tipe_masuk',
            [
                'SNMPTN Jalur Undangan' => 'SNMPTN Jalur Undangan',
                'SNMPTN Jalur Ujian Tulis' => 'SNMPTN Jalur Ujian Tulis',
                'Reguler Mandiri' => 'Reguler Mandiri',
                'Program Internasional' => 'Program Internasional',
                'Pindahan' => 'Pindahan',
                'Transfer' => 'Transfer',
            ],
            old('tipe_masuk'),
            ['class' => 'form-control', 'placeholder' => 'Pilih Jalur Masuk', 'id' => 'tipe_masuk'],
        ) }}

    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="periode_wisuda">Periode Wisuda</label>
        {{ Form::select(
            'periode_wisuda',
            [
                '1' => 'Wisuda I',
                '2' => 'Wisuda II',
                '3' => 'Wisuda III',
                '4' => 'Wisuda IV',
                '5' => 'Wisuda V',
                '6' => 'Wisuda VI',
            ],
            old('periode_wisuda'),
            ['class' => 'form-control', 'placeholder' => 'Pilih Periode Wisuda', 'id' => 'periode_wisuda'],
        ) }}
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label class="form-label" for="nik">NIK</label>
        {{ Form::text('nik', old('nik'), ['class' => 'form-control', 'placeholder' => 'NIK', 'id' => 'nik']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="npwp">NPWP</label>
        {{ Form::text('npwp', old('npwp'), ['class' => 'form-control', 'placeholder' => 'NPWP', 'id' => 'npwp']) }}
    </div>
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="judul_tesis">Judul Tesis</label>
    {{ Form::textarea('judul_tesis', old('judul_tesis'), ['rows' => '2', 'class' => 'form-control', 'placeholder' => 'Judul Tesis', 'id' => 'judul_tesis']) }}
</div>


<div class="float-end">

    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{ $data !== null ? 'Update' : 'Tambah' }} Alumni</button>
</div>

{!! Form::close() !!}


    

<script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('#kode_prodi_id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Prodi'
            });
            $('#tipe_masuk').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Jalur Masuk'
            });
            $('#periode_wisuda').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Periode Wisuda'
            });
        });

        $('#formModal').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                data: $('#formAlumni').serialize(),
                @if (isset($data))
                    type: "PATCH",
                    url: "{{ route('backoffice.databasealumni.update', $data->nim) }}",
                @else
                    type: "POST",
                    url: "{{ route('backoffice.databasealumni.store') }}",
                @endif
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(data) {
                    if (data.success) {
                        $('#formAlumni').trigger("reset");
                        form.closest('.modal').modal('hide');
                        toastMixin.fire({
                            icon: 'success',
                            title: "Data Berhasil Disimpan",
                        });
                        console.log("Success: " + data.success);
                        var dataTable = $('#dataTable').DataTable();
                        dataTable.ajax.reload();
                    } else if (data.error) {
                        toastMixin.fire({
                            icon: 'error',
                            title: "Data Tidak Berhasil Disimpan" + data.error,
                        });


                        console.log("Error: " + data.error);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 422) {
                        var data = xhr.responseJSON;
                        console.log(data);
                        var errorMessage = '';

                        for (var key in data.all_message) {
                            if (data.all_message.hasOwnProperty(key)) {
                                errorMessage += data.all_message[key].join("\n") + "\n";
                            }
                        }
                        toastMixin.fire({
                            icon: 'error',
                            title: errorMessage,
                            willOpen: (toast) => {
                                toast.querySelector('.swal2-title').style
                                    .textAlign = 'left';
                            }
                        });
                        console.error(errorMessage);
                    } else if (xhr.status === 500) {
                        console.error("Internal Server Error:", xhr.responseText);
                        toastMixin.fire({
                            icon: 'error',
                            title: "Gagal Menyimpan Data. Internal Server Error",
                        });
                    }
                }
            });
        });

    });
</script>
