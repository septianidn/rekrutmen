@php
$data = $data ?? null;
$prodiOptions = \App\Models\Prodi::all() ?? null;
$fakultasOptions = \App\Models\Fakultas::all() ?? null;
$jenjangOptions = \App\Models\Jenjang::all() ?? null;
@endphp

<div class="modal fade" id="addOrUpdateData{{$data->id}}" tabindex="-1" aria-labelledby="addOrUpdateDataLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
                <h6 class="modal-title">{{$data !== null ? 'Update' : 'Tambah' }} Data Fakultas Prodi</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="form-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                    {{ Form::select('fakultas_id', $fakultasOptions->pluck('nama_fakultas', 'id'), old('fakultas_id'), ['class' => 'form-control', 'id' => 'fakultass', 'placeholder' => 'Pilih Fakultas', 'required']) }}
                </div>
                <div class="form-group col-md-12">
                  <label class="form-label" for="prodi">Prodi <span class="text-danger">*</span></label>
                  {{ Form::select('kode_prodi_id', $prodiOptions->pluck('nama_prodi', 'kode_prodi'), old('nama_prodi'), ['class' => 'form-control', 'id' => 'prodis', 'placeholder' => 'Pilih Prodi', 'required']) }}
              </div>
              <div class="form-group col-md-12">
                  <label class="form-label text-left" for="jenjang">Jenjang <span class="text-danger">*</span></label>
                  {{ Form::select('jenjang_id', $jenjangOptions->pluck('nama_jenjang', 'id'), old('jenjang_id'), ['class' => 'form-control', 'id' => 'jenjangs', 'placeholder' => 'Pilih Jenjang', 'required']) }}
              </div>
              
            </div>     
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
               <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Fakultas Prodi</button>
           </div>
       </div>
   </div>
   </div>

@push('scripts')
<script type="text/javascript">

      </script>   
@endpush