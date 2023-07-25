@push('scripts')
    {{ $dataTable->scripts() }}
   
@endpush
<x-app-layout :assets="$assets ?? []">
<div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">{{ $pageTitle ?? 'Data'}}</h4>
               </div>
               @if (isset ($buttonAddTitle))
                <div class="card-action"> 
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addOrUpdateData">
                      Tambah{{ isset($buttonAddTitle) ? $buttonAddTitle : '' }}
                     </button>
                </div>
                @endif
            </div>
            <div class="card-body px-0">
               <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'datatable table table-striped w-100'],true) }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@if (isset ($returnView))
@include($returnView ?? null)
@endif
</x-app-layout>
