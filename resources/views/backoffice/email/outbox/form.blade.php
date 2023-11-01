@php
 $data = $data ?? null   
@endphp
<x-app-layout :assets="$assets ?? []">
   <div>
      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Email Terkirim</h4>
                  </div>
               </div>
               <div class="card-body">
                        <div class="row">
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="tujuan">Tujuan</label>
                              <div class="col-sm-10">
                                 <input type="text" name="tujuan" value="{{$data->tujuan }}" class="form-control" readonly  id="tujuan">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="tglkirim">Tanggal Kirim</label>
                              <div class="col-sm-10">
                                 <input type="text" name="tujuan" value="{{$data->tanggal_kirim }}" class="form-control" readonly  id="tglkirim">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="status">Status Kirim</label>
                              <div class="col-sm-10">
                                 <input type="text" name="tujuan" value="{{$data->status }}" class="form-control" readonly  id="status">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="subjek">Subjek</label>
                              <div class="col-sm-10">
                                 <input type="text" name="subjek" value="{{ $data->subjek }}" class="form-control"  readonly  id="subjek">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-sm-2 col-form-label" for="isi">isi</label>
                              <div class="col-sm-10">
                                 <textarea name="isi" class="form-control" required id="isi" readonly >{{ $data->isi }}</textarea>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <a type="button" class="btn btn-sm btn-danger" href="{{ route('backoffice.outbox.index')}}"> Kembali</a>
                           </div>
             
         </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>

<script>
   tinymce.init({
       selector: '#isi',
       menubar: false,
       toolbar: false,
       statusbar: false,
       height: '800',
       tinycomments_mode: 'embedded',
       noneditable_noneditable_class: 'nonedit', // Menambahkan class CSS 'nonedit' untuk membuat isi tidak dapat diubah
   });
</script>
