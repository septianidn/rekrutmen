<x-app-layout :assets="$assets ?? []">
<div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title mb-0">Role & Permission</h4>
               </div>
               <div class="text-center ms-3 ms-lg-0 ms-md-0">
                    <a href="#" class="mt-lg-0 mt-md-0 mt-3 btn btn-primary btn-icon" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="{{ route('permission.create') }}" data-app-title="Add new permission" data-placement="top" title="New Permission">
                        <i class="btn-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </i>
                        <span>Tambah Permission</span>
                    </a>
                    <a href="#" class="mt-lg-0 mt-md-0 mt-3 btn btn-primary btn-icon" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="{{ route('role.create') }}" data-app-title="Tambah Data Role" data-placement="top" title="Tambah Role">
                        <i class="btn-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </i>
                        <span>Tambah Role</span>
                    </a>
               </div>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    {{ Form::open(['route' => ['role-permission.store'], 'method' => 'post']) }}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach ($roles as $role)
                                        <th class="text-center">{{ $role->title }}
                                        <div style="float:right;">
                                        <a class="btn btn-sm btn-icon text-primary flex-end" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="{{ route('role.edit', $role->id) }}" data-app-title="Edit Data Role" data-placement="top" title="Edit Role">
                                            <span class="btn-inner">
                                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                                    <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <a class="btn btn-sm btn-icon text-danger"  onclick="showDeleteConfirmationRole({{$role->id}})" data-bs-toggle="tooltip" title="Hapus Role">
                                            <span class="btn-inner">
                                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                    <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr class="{{ !isset($permission->parent_id) ? 'bg-body' : '' }}">
                                    <td>{{ $permission->title }}
                                    <div style="float:right;">
                                        <a class="btn btn-sm btn-icon text-primary flex-end" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="{{ route('permission.edit', $permission->id) }}" data-app-title="Edit Data Permission" data-placement="top" title="Edit Permission">
                                        <span class="btn-inner">
                                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    <a class="btn btn-sm btn-icon text-danger " onclick="showDeleteConfirmationPermission({{$permission->id}})"  data-bs-toggle="tooltip" title="Hapus Permission" href="#">
                                        <span class="btn-inner">
                                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>
                                    </div>
                                    </td>
                                    @foreach ($roles as $role)
                                        <td class="text-center">
                                            @if($permission->parent_id === null)
                                            <input class="form-check-input checkbox-role parent" type="checkbox" id="role-{{$role->id}}-permission-{{$permission->id}}" name="permission[{{$permission->name}}][]" value='{{$role->name}}'
                                            {{ (AuthHelper::checkRolePermission($role,$permission->name)) ? 'checked' : '' }}>
                                            @else
                                            <input class="form-check-input checkbox-role child " type="checkbox" id="role-{{$role->id}}-permission-{{$permission->id}}" name="permission[{{$permission->name}}][]" value='{{$role->name}}'
                                            {{ (AuthHelper::checkRolePermission($role,$permission->name)) ? 'checked' : '' }}>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                        {{ Form::submit( __('global-message.save'), ['class'=>'btn btn-md btn-primary']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
</x-app-layout>

<script>
    $(document).ready(function () {
        // Tangkap semua elemen input dengan class checkbox-role
        $('.checkbox-role').change(function () {
            // Dapatkan nilai dari checkbox saat ini (diceklis atau tidak)
            var isChecked = $(this).prop('checked');

            // Lakukan sesuatu berdasarkan kondisi checkbox
            if (isChecked) {
                // Checkbox terceklis, tambahkan kode yang ingin Anda jalankan di sini
                console.log('Checkbox terceklis');
            } else {
                // Checkbox tidak terceklis, tambahkan kode yang ingin Anda jalankan di sini
                console.log('Checkbox tidak terceklis');
            }
        });
    });
</script>

<script>
    function showDeleteConfirmationRole(id) {
        var message = "{!! __('global-message.delete_alert', ['form' => __('role.title')]) !!}";
    
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
                form.action = "{{route('role.destroy', '')}}/" + id;
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
    function showDeleteConfirmationPermission(id) {
        var message = "{!! __('global-message.delete_alert', ['form' => __('permission.title')]) !!}";
    
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
                form.action = "{{route('permission.destroy', '')}}/" + id;
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