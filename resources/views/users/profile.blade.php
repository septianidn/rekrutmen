<x-app-layout :assets="$assets ?? []">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="d-flex flex-wrap align-items-center justify-content-between">
                  <div class="d-flex flex-wrap align-items-center">
                     <div class="profile-img position-relative me-3 mb-3 mb-lg-0">
                        <img src="{{ $profileImage ?? asset('images/avatars/01.png')}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/avatars/avtar_1.png')}}" alt="User-Profile" class="theme-color-purple-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/avatars/avtar_2.png')}}" alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/avatars/avtar_4.png')}}" alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/avatars/avtar_5.png')}}" alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/avatars/avtar_3.png')}}" alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-100">
                     </div>
                     <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                        <h4 class="me-2 h4">{{ $data->full_name ?? '-'  }}</h4>
                        <span class="text-capitalize"> - {{ str_replace('_',' ',auth()->user()->user_type) ?? 'Marketing Administrator' }}</span>
                     </div>
                  </div>
                  <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" href="#profile-profile" role="tab" aria-selected="false">Profil</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile-account" role="tab" aria-selected="false">Akun</a>
                     </li>
                    
                     
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-9">
         <div class="profile-content tab-content">
         <div id="profile-account" class="tab-pane fade">
            <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h4 class="card-title">Informasi Akun</h4>
                  </div>
               </div>
               <div class="card-body">
                  
               </div>
            </div>
         </div>
         <div id="profile-profile" class="tab-pane fade active show">
     
            <div class="card">
               <div class="card-header">
                  <div class="header-title">
                     <h4 class="card-title">Profil Pengguna</h4>
                  </div>
               </div>
               <div class="card-body">
                  <div class="mt-2">
                  <h6 class="mb-1">Tanggal Bergabung:</h6>
                  <p>{{auth()->user()->created_at}}</p>
                  </div>
                  <div class="mt-2">
                  <h6 class="mb-1">Alamat</h6>
                  <p>{{ auth()->user()->street_addr ?? '-'}}</p>
                  </div>
                  <div class="mt-2">
                  <h6 class="mb-1">Email:</h6>
                  <p><a href="#" class="text-body">{{auth()->user()->email}}</a></p>
                  </div>
                  <div class="mt-2">
                  <h6 class="mb-1">Url:</h6>
                  <p><a href="#" class="text-body" target="_blank"> www.bootstrap.com </a></p>
                  </div>
                  <div class="mt-2">
                  <h6 class="mb-1">Kontak:</h6>
                  <p><a href="#" class="text-body">{{$data->phone_number ?? '-'}}</a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div class="col-lg-3">
         <div class="card">
         <div class="card-header">
            <div class="header-title">
               <h4 class="card-title">Status Akun</h4>
            </div>
         </div>
         <div class="card-body">
            <div class="mt-2">
               <h6 class="mb-1">Status:</h6>
               @if(auth()->user()->status == 'active')
               <span class="text-capitalize badge bg-primary">{{auth()->user()->status}}</span>
               @elseif(auth()->user()->status == 'inactive')
               <span class="text-capitalize badge bg-danger">{{auth()->user()->status}}</span>
               @elseif(auth()->user()->status == 'banned')
               <span class="text-capitalize badge bg-warning">{{auth()->user()->status}}</span>
               @else
               <span class="text-capitalize badge bg-primary">-</span>
               @endif
            </div>
          
            <div class="mt-2">
               <h6 class="mb-1">Role:</h6>
               @if(auth()->user()->user_type == 'admin')
               <p class="text-body text-capitalize ">{{auth()->user()->user_type}}</p>
               @elseif(auth()->user()->user_type == 'kaprodi')
               <p class="text-body text-capitalize ">Kepala Prodi {{$nama_prodi ?? '-'}}</p>
               @else
               <p class="text-body">-</p>
               @endif
            </div>
           
         </div>
         </div>
      </div>
   </div>

   @include('partials.components.share-offcanvas')
</x-app-layout>
