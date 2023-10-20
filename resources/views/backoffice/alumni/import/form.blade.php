{!! Form::open([
    'route' => ['importdatabasealumni.store'],
    'method' => 'post',
    'enctype' => 'multipart/form-data',
    'id' => 'formModalImportDBAlumni',
]) !!}

<div class="row">
    <div class="form-group col-md-12">
        <label class="form-label" for="paket_soal_id">File Import <span class="text-danger">*</span></label>
        {{ Form::file('file_import', ['class' => 'form-control', 'id' => 'file_import', 'accept' => '.csv .xlsx']) }}
        <span class="m-0 mt-2" id="blasting-text">
            <small>Format file harus bertipe *.csv atau *xlsx, download format file import alumni <a
                    href="{{ asset('format/format_alumni_import.csv') }}" download> disini </a></small>
        </span>
    </div>
</div>

<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">Import</button>
</div>

{!! Form::close() !!}
