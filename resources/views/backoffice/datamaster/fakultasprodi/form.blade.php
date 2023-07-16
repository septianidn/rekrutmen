@php
$data = $data ?? null;
$prodiOptions = \App\Models\Prodi::all() ?? null;
$fakultasOptions = \App\Models\Fakultas::all() ?? null;
@endphp

@if(isset($data))
{!! Form::model($data, ['route' => ['fakultasprodi.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['fakultasprodi.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
<div class="modal fade" id="addOrUpdateData{{$data->id ?? null }}" tabindex="-1" aria-labelledby="addOrUpdateDataLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
                <h6 class="modal-title">{{$data !== null ? 'Update' : 'Tambah' }} Data Fakultas Prodi</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <div class="row">
   
                <div class="form-group col-md-12">
                    <label class="form-label" for="prodi">Fakultas <span class="text-danger">*</span></label>
                    <select class="form-control" name="kode_prodi_id" id="fakultas">
                        <option value="">Pilih Fakultas</option>
                        @foreach($fakultasOptions as $fakultas)
                            <option value="{{ $fakultas->id }}" {{ old('nama_fakultas') == $fakultas->nama_fakultas ? 'selected' : '' }}> {{$fakultas->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
            <div class="form-group col-md-12">
                <label class="form-label" for="prodi">Prodi <span class="text-danger">*</span></label>
                <select class="form-control" name="kode_prodi_id" id="prodi">
                    <option value="">Pilih Prodi</option>
                    @foreach($prodiOptions as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ old('nama_prodi') == $prodi->nama_prodi ? 'selected' : '' }}>{{ $prodi->kode_prodi}} | {{$prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
            </div>     
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
               <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Fakultas Prodi</button>
           </div>
       </div>
   </div>
   {!! Form::close() !!}
   </div>

   @push('scripts')
    <script>
             var dataId = {{$data->id ?? 'null'}};
            //  console.log(dataId);
           $(document).ready(function() {
  $("#prodi").select2({
    dropdownParent: $("#addOrUpdateData"),
    theme: "bootstrap"
  });
  $("#fakultas").select2({
    dropdownParent: $("#addOrUpdateData"),
    theme: "bootstrap"
  });

  if (dataId !== null) {
    $('#prodi').select2({
      dropdownParent: $('#addOrUpdateData[data-id="' + dataId + '"]'),
      theme: 'bootstrap'
    });

    $('#fakultas').select2({
      dropdownParent: $('#addOrUpdateData[data-id="' + dataId + '"]'),
      theme: 'bootstrap'
    });
  }
});
        </script>
       
   @endpush