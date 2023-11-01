<x-guest-layout>
   <section class="login-content">
      <div class="row m-0 align-items-center bg-white vh-100">            
         <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
            <img src="{{asset('images/backoffice/hero/unand.jpg')}}" class="img-fluid gradient-main animated-scaleX" alt="images">
         </div>
         <div class="col-md-6">           
            <div class="row justify-content-center">
               <div class="col-md-10">
                  <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                     <div class="card-body">
                        <a href="{{route('backoffice.dashboard')}}" class="navbar-brand d-flex align-items-center mb-3">
                           <img src="{{ asset('images/backoffice/logo/logounand30.svg') }}" />
                           <h4 class="logo-title ms-3">{{env('APP_NAME')}}</h4>
                        </a>
                        <h2 class="mb-2 mt-2 ">Reset Password</h2>
                        <p>Isi password baru anda</p>
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form  action="{{route("password.update")}}" method="POST" data-toggle="validator">
                            {{csrf_field()}}
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password"  name="password" class="form-control" type="password" placeholder="Isi password"  required autofocus >
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input id="password_confirmation"  name="password_confirmation" class="form-control" type="password" placeholder="Isi konfirmasi password"  required autofocus >
                                 </div>
                              </div>
                              
                              <input id="token"  name="token" type="hidden"  value="{{$request->token}}" >
                              <input id="email"  name="email"  type="hidden"  value="{{$request->email}}" >
                                 
                              
                           </div>
                           <div class="d-flex ">
                              <button type="submit" class="btn btn-primary"> {{ __('Reset') }}</button>
                           </div>
                           
                          
                        </form>
                     </div>
                  </div> 
               </div>
            </div>    
            <div class="sign-bg sign-bg-right">
               <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.05">
                  <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"/>
                  <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"/>
                  <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"/>
                  <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"/>
                  </g>
               </svg>
            </div>
         </div>   
      </div>
   </section>
</x-guest-layout>
