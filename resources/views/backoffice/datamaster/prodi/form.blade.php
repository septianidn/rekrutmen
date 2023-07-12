<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['prodi.update', $data->kode_prodi], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['prodi.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
<div class="modal fade" id="addOrUpdateData{{$data->kode_prodi ?? null }}" tabindex="-1" aria-labelledby="addOrUpdateDataLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
                <h6 class="modal-title">{{$data !== null ? 'Update' : 'Tambah' }} Data Prodi </h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="form-label" for="fname">Kode Prodi <span class="text-danger">*</span></label>
                    {{ Form::text('kode_prodi', old('kode_prodi'), ['class' => 'form-control', 'placeholder' => 'Kodi Prodi', 'required']) }}
                 </div>
               <div class="form-group col-md-12">
                  <label class="form-label" for="fname">Nama Prodi <span class="text-danger">*</span></label>
                  {{ Form::text('nama_prodi', old('nama_prodi'), ['class' => 'form-control', 'placeholder' => 'Nama Prodi', 'required']) }}
               </div>

            </div>     
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
               <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Prodi</button>
           </div>
       </div>
   </div>
   {!! Form::close() !!}
   </div>