<div class="flex align-items-center list-email-template-action">
    <a class="btn btn-sm btn-icon btn-info" data-bs-toggle="modal" data-bs-target="#showDetailTemplate{{$data->id}}" title="Edit fakultas">
        <span class="btn-inner">
            <svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1614 12.0531C15.1614 13.7991 13.7454 15.2141 11.9994 15.2141C10.2534 15.2141 8.83838 13.7991 8.83838 12.0531C8.83838 10.3061 10.2534 8.89111 11.9994 8.89111C13.7454 8.89111 15.1614 10.3061 15.1614 12.0531Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.998 19.355C15.806 19.355 19.289 16.617 21.25 12.053C19.289 7.48898 15.806 4.75098 11.998 4.75098H12.002C8.194 4.75098 4.711 7.48898 2.75 12.053C4.711 16.617 8.194 19.355 12.002 19.355H11.998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            
            </svg>                           
         </span>
    </a>
    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" title="Edit Template" href="{{ route('template.edit', $data->id) }}">
        <span class="btn-inner">
            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </a>
    <?php 
    $message = __('global-message.delete_alert', ['form' => __('emailtemplate.title')]);
    ?>
    <a class="btn btn-sm btn-icon btn-danger" onclick="showDeleteConfirmation({{$data->id}})" data-bs-toggle="tooltip" title="Delete Template">
        <span class="btn-inner">
            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </a>
</div>

<div class="modal fade" id="showDetailTemplate{{$data->id}}" tabindex="-1" aria-labelledby="addOrUpdateDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                 <h6 class="modal-title">Detail Template Email</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <div class="row">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="nama_template">Nama Template</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_template" value="{{$data->nama_template }}" class="form-control" placeholder="Nama Template" readonly  id="nama_template">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="subjek_template">Subjek</label>
                    <div class="col-sm-10">
                        <input type="text" name="subjek_template" value="{{ $data->subjek_template }}" class="form-control" placeholder="Subjek Template" readonly  id="subjek_template">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="isi_template">Isi</label>
                    <div class="col-sm-10">
                        <textarea name="isi_template" class="form-control" placeholder="Isi Template" required id="isi_template" disabled >{{ $data->isi_template }}</textarea>
                    </div>
                </div>
             </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
    </div>

<script>
function showDeleteConfirmation(id) {
    var message = "{!! __('global-message.delete_alert', ['form' => __('emailtemplate.title')]) !!}";

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) {
            var form = document.createElement('form');
            form.action = "{{route('template.destroy', '')}}/" + id;
            form.method = 'POST';

            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";

            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        toolbar: false,
        statusbar: false,
        height: '800',
        tinycomments_mode: 'embedded',
        noneditable_noneditable_class: 'nonedit', // Menambahkan class CSS 'nonedit' untuk membuat isi tidak dapat diubah
    });
</script>
