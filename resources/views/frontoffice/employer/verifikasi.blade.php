<x-front-office-layout :assets="$assets ?? []">

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Post a Job</h1>
                        <p>Business plan draws on a wide range of knowledge from different business<br> disciplines.
                            Business draws on a wide range of different business .</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="news-standard.html">Blog</a></li>
                        <li>Post a Job</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="job-post section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-12">
                    <div class="job-information">
                        <h3 class="title">Lengkapi Informasi Perusahaan</h3>
                        <form method="POST" action="{{route('employer.verifikasi')}}">
                            @csrf
                            <input type="hidden" value="{{$user->id}}" name="id_user">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nama_perusahaan">Nama Perusahaan*</label>
                                        <input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat Perusahaan*</label>
                                        <input type="text" name="alamat" id="alamat">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="telp">No.Telp Perusahaan*</label>
                                        <input type="text" name="telp" id="telp">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="id_industri_type">Tipe Industri*</label>
                                        <select class="select" name="id_industri_type" id="id_industri_type">
                                            <option value="1">UX/UI Designer</option>
                                            <option value="2">Web Developer</option>
                                            <option value="3">Web Designer</option>
                                            <option value="4">Software Developer</option>
                                            <option value="5">SEO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Perusahaan*</label>
                                        <input type="text" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="deskripsi_perusahaan">Deskripsi Perusahaan*</label>
                                        <textarea name="deskripsi_perusahaan" class="form-control" rows="5" id="deskripsi_perusahaan"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    {{-- <div class="form-group">
                                        <label for="link">Additional Link (Website/Sosial Media)*</label>
                                        Instagram<input type="text" name="instagram" id="instagram">
                                    </div>
                                    <div class="form-group">
                                        Twitter<input type="text" name="twitter" id="twitter">
                                    </div>
                                    <div class="form-group">
                                        LinkedIn<input type="text" name="linkedin" id="linkedin">
                                    </div>
                                    <div class="form-group">
                                        Facebook<input type="text" name="facebook" id="facebook">
                                    </div> --}}
                                    <div class="form-group">
                                        Website<input type="text" name="website" id="website">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 button">
                                    <button class="btn" type="submit" name="verifikasi">
                                        Simpan
                                    </button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal"><i class="lni lni-close"></i></button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>Login From Here</h3>
                                <p>Log in to continue your account <br> and explore new jobs.</p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li><a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i> Log in
                                            with LinkedIn</a></li>
                                    <li><a class="google" href="#"><i class="lni lni-google"></i> Log in with
                                            Google</a></li>
                                    <li><a class="facebook" href="#"><i class="lni lni-facebook-original"></i> Log in
                                            with Facebook</a></li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">Remember password</label>
                                    </div>
                                    <a href="" class="font-size-3 text-dodger line-height-reset">Forget Password</a>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn ">Log in
                                    </button>
                                </div>
                                <p class="text-center create-new-account">Don’t have an account? <a href="#">Create a free account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Login Modal -->

    <!-- Signup Modal -->
    <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal"><i class="lni lni-close"></i></button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>Create a free Account <br> Today</h3>
                                <p>Create your account to continue <br> and explore new jobs.</p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li><a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i> Import from LinkedIn</a></li>
                                    <li><a class="google" href="#"><i class="lni lni-google"></i> Import from
                                            Google</a></li>
                                    <li><a class="facebook" href="#"><i class="lni lni-facebook-original"></i> Import from Facebook</a></li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="flexCheckDefault">Agree to the <a
                                                href="#">Terms & Conditions</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn ">Sign Up
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-front-office-layout>