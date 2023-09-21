<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
         $id = $id ?? null;
         $data = $data ?? null;
      ?>
      @if(isset($id))
      {!! Form::model($data, ['route' => ['users.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
      @else
      {!! Form::open(['route' => ['users.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif
      <div class="row">
         <div class="col-xl-3 col-lg-4">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{$id !== null ? 'Update' : 'Tambah' }} Pengguna</h4>
                  </div>
               </div>
               <div class="card-body">
                     <div class="form-group">
                        <div class="profile-img-edit position-relative w-50">
                           <label class="form-label">Foto Profi:</label>
                         
                              <input type="file" 
                              class="profile_image"
                              name="profile_image"
                              accept="image/png, image/jpeg, image/gif"/>
                           
         
                        </div>
                        <div class="img-extension mt-3">
                           <div class="d-inline-block align-items-center">
                              <span>Only</span>
                              <a href="javascript:void();">.jpg</a>
                              <a href="javascript:void();">.png</a>
                              <a href="javascript:void();">.jpeg</a>
                              <span>allowed</span>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="form-label">Status:</label>
                        <div class="grid" style="--bs-gap: 1rem">
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'active',old('status') || true, ['class' => 'form-check-input', 'id' => 'status-active']); }}
                                <label class="form-check-label" for="status-active">
                                    Active
                                </label>
                            </div>
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'pending',old('status'), ['class' => 'form-check-input', 'id' => 'status-pending']); }}
                                <label class="form-check-label" for="status-pending">
                                    Pending
                                </label>
                            </div>
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'blocked',old('status'), ['class' => 'form-check-input', 'id' => 'status-banned']); }}
                                <label class="form-check-label" for="status-banned">
                                    Banned
                                </label>
                            </div>
                            <div class="form-check g-col-6">
                                {{ Form::radio('status', 'inactive',old('status'), ['class' => 'form-check-input', 'id' => 'status-inactive']); }}
                                <label class="form-check-label" for="status-inactive">
                                    Inactive
                                </label>
                            </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="form-label">User Role: <span class="text-danger">*</span></label>
                        {{Form::select('user_role', $roles , old('user_role') ? old('user_role') : $data->user_type ?? 'admin', ['class' => 'form-control', 'id' => 'user_role', 'placeholder' => 'Select User Role'])}}

                     </div>
                     <div class="form-group" id="prodi_div" style="display: none;">
                        <label class="form-label">Prodi: <span class="text-danger">*</span></label>
                        {{ Form::select('adminprodi[kode_prodi_id]', $prodi->pluck('nama_prodi', 'kode_prodi'), old('adminprodi.kode_prodi_id'), ['class' => 'form-control prodi', 'placeholder' => 'Pilih Prodi']) }}
                    </div>
                    

               </div>
            </div>
         </div>
         <div class="col-xl-9 col-lg-8">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{$id !== null ? 'Update' : 'New' }} Informasi Pengguna</h4>
                  </div>
                  <div class="card-action">
                        <a href="{{route('users.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-user-info">
                        <div class="row">
                           <div class="form-group col-md-6">
                              <label class="form-label" for="fname">Nama Depan: <span class="text-danger">*</span></label>
                              {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'Masukan Nama Depan', 'required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="lname">Nama Belakang: <span class="text-danger">*</span></label>
                              {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Masukan Nama Belakang' ,'required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="add1">Alamat:</label>
                              {{ Form::text('street_addr', old('street_addr'), ['class' => 'form-control', 'id' => 'add1', 'placeholder' => 'Masukan Alamat']) }}
                           </div>
                          
                           <div class="form-group col-md-6">
                              <label class="form-label" for="mobno">Nomor Telepon:</label>
                              {{ Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'id' => 'mobno', 'placeholder' => 'Masukan Nomor Telepon']) }}
                           </div>
                          
                           <div class="form-group col-md-6">
                              <label class="form-label" for="email">Email: <span class="text-danger">*</span></label>
                              {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Masukan e-mail', 'required']) }}
                           </div>
                          
                        </div>
                        <hr>
                        <h5 class="mb-3">Informasi Akun</h5>
                        <div class="row">
                           <div class="form-group col-md-6">
                              <label class="form-label" for="pass">Password:<span class="text-danger">*</span></label>
                              {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan Password']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="rpass">Ulangi Password: <span class="text-danger">*</span></label>
                              {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Silahkan Ulangi Password']) }}
                           </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">{{$id !== null ? 'Update' : 'Tambah' }} Pengguna</button>
                  </div>
               </div>
            </div>
         </div>
        </div>
        {!! Form::close() !!}
   </div>
</x-app-layout>


@php 
$profileImage = optional($data)->getFirstMedia('profile_image');
$urlPhoto = $profileImage ? $profileImage->getUrl() : 'http://127.0.0.1:8000/storage/profile-none.png';

@endphp

<script type="module">


console.log('{{$urlPhoto}}')


  FilePond.registerPlugin(FilePondPluginFileValidateType,
       FilePondPluginImageEditor,
       FilePondPluginFilePoster);

var pond = FilePond.create(document.querySelector('.profile_image'), {
       // FilePond generic properties

      labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
      imagePreviewHeight: 50,
      imageCropAspectRatio: '1:1',
      imageResizeTargetWidth: 100,
      imageResizeTargetHeight: 100,
      stylePanelLayout: 'compact circle',
      styleLoadIndicatorPosition: 'center bottom',
      styleProgressIndicatorPosition: 'right bottom',
      styleButtonRemoveItemPosition: 'left bottom',
      styleButtonProcessItemPosition: 'right bottom',
      acceptedFileTypes: ['image/*'],
      labelFileTypeNotAllowed: 'File of invalid type',
      allowRevert: true,
      allowReorder: true,
      filePosterMaxHeight: 256,
      allowProcess: true,
         files: [
            {
               source: '{{$urlPhoto}}',
               options: {
               type: 'local'
               }
            }
         ],
         server: {
            process: {
               url : "{{ route('upload-profile-image.store')}}",
               method: 'POST', // Tambahkan metode POST di sini
               headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
               },
               onerror: (response) => {
                     // Tangani kesalahan di sini dan cetak pesan kesalahan
                     console.error('Kesalahan saat memproses unggahan:', response);
               },
            },
            revert: {
               url : "{{ route('upload-profile-image.destroy')}}",
               method: 'DELETE', 
               headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
               },
               onerror: (response) => {
                     // Tangani kesalahan di sini dan cetak pesan kesalahan
                     console.error('Kesalahan saat menghapus unggahan:', response);
               },
            },
            load: (uniqueFileId, load, error, progress, abort, headers) => {
               fetch('{{$urlPhoto}}') 
                  .then((res) => {
                        if (!res.ok) {
                           throw new Error(`Network response was not ok: ${res.status}`);
                        }
                        return res.blob();
                  })
            .then(load)
            .catch(error);
            },
                        
                     },
       // FilePond Image Editor plugin properties
       imageEditor: {
           // Maps legacy data objects to new imageState objects (optional)
           legacyDataToImageState: legacyDataToImageState,

           // Used to create the editor (required)
           createEditor: openEditor,

           // Used for reading the image data. See JavaScript installation for details on the `imageReader` property (required)
           imageReader: [
               createDefaultImageReader,
               {
                   // createDefaultImageReader options here
               },
           ],

           // Required when generating a preview thumbnail and/or output image
           imageWriter: [
               createDefaultImageWriter,
               {
                   // We'll resize images to fit a 512 × 512 square
                   targetSize: {
                       width: 512,
                       height: 512,
                   },
               },
           ],

           // Used to create poster and output images, runs an invisible "headless" editor instance
           imageProcessor: processImage,

           // Pintura Image Editor options
           editorOptions: {
               // Pass the editor default configuration options
               ...getEditorDefaults(),

               // This will set a square crop aspect ratio
               imageCropAspectRatio: 1,
           },
       },
   });
</script>



<script>

   $(document).ready(function() {
       // Event listener untuk inputan "User Role"
       $('#user_role').on('change', function() {

           var selectedUserRole = $(this).find('option:selected').text();

           if (selectedUserRole === 'admin prodi' || selectedUserRole === 'Admin Prodi') {
               $('#prodi_div').show();
           } else {
    
               $('#prodi_div').hide();
           }
       });


       $('#user_role').trigger('change');
   });
   $('.prodi').select2({
      theme: 'bootstrap-5',
      placeholder : 'Pilih prodi..'
   });

</script>