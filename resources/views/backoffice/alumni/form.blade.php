<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['fakultas.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['fakultas.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
<div class="modal fade" id="addOrUpdateData{{$data->id ?? null }}" tabindex="-1" aria-labelledby="addOrUpdateDataLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
                <h6 class="modal-title">{{$data !== null ? 'Update' : 'Tambah' }} Data fakultas </h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <div class="row">
               <div class="form-group col-md-12">
                  <label class="form-label" for="fname">Fakultas <span class="text-danger">*</span></label>
                  {{ Form::text('nama_fakultas', old('nama_fakultas'), ['class' => 'form-control', 'placeholder' => 'Nama fakultas', 'required']) }}
               </div>
            </div>     
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
               <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Fakultas</button>
           </div>
       </div>
   </div>
   {!! Form::close() !!}
   </div>