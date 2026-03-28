@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('content')
        <!-- Main Content Start -->
    <div class="resume">
        <div class="container">
            <div class="resume-inner">
                <div class="row">
                    <!-- Start Main Content -->
                    {{-- <div class="col-lg-4 col-12">
                        <div class="dashbord-sidebar">
                            <ul>
                                <li class="heading">Manage Account</li>
                                <li><a class="active" href="resume.html"><i class="lni lni-clipboard"></i> My Resume</a>
                                </li>
                                <li><a href="bookmarked.html"><i class="lni lni-bookmark"></i> Bookmarked Jobs</a></li>
                                <li><a href="notifications.html"><i class="lni lni-alarm"></i> Notifications <span
                                            class="notifi">5</span></a></li>
                                <li><a href="manage-applications.html"><i class="lni lni-envelope"></i> Manage
                                        Applications</a></li>
                                <li><a href="manage-resumes.html"><i class="lni lni-files"></i> Manage Resumes</a></li>
                                <li><a href="job-alerts.html"><i class="lni lni-briefcase"></i> Job Alerts</a></li>
                                <li><a href="change-password.html"><i class="lni lni-lock"></i> Change Password</a></li>
                                <li><a href="index.html"><i class="lni lni-upload"></i> Sign Out</a></li>
                            </ul>
                        </div>
                    </div> --}}
                    <!-- End Main Content -->
                    <div class="col-lg-12 col-12">
                        <div class="inner-content">
                            <!-- Start Personal Top Content -->
                            <div class="personal-top-content">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-12">
                                        <div class="name-head">
                                            <a class="mb-2" href="#"><img class="circle-54"
                                                    src="assets/images/resume/avater.png" alt=""></a>
                                            <h4><a class="name" href="#">{{$jobs->nama_pekerjaan}}</a></h4>
                                            <p><a class="deg" href="#">{{$jobs->posisi}}</a></p>
                                            <ul class="social">
                                                <li><a href="{{route('employer.job.edit', ['job'=>$jobs->id])}}"><i class="lni lni-facebook-original"></i></a></li>
                                                <div>
                                                <form action="{{route('employer.job.destroy', ['job'=>$jobs->id])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?')">DELETE&nbsp;<i class="fas fa-trash"></i></i></button>
                                                </form>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-12">
                                        <div class="content-right">
                                            <h5 class="title-main">Job Info</h5>
                                            <!-- Single List -->
                                            <div class="single-list">
                                                <h5 class="title">Location</h5>
                                                <p>{{$jobs->alamat}}</p>
                                            </div>
                                            <!-- Single List -->
                                            <!-- Single List -->
                                            <div class="single-list">
                                                <h5 class="title">Worktime</h5>
                                                <p>{{$jobs->worktime}}</p>
                                            </div>
                                            <!-- Single List -->
                                            <!-- Single List -->
                                            <div class="single-list">
                                                <h5 class="title">Expected Salary</h5>
                                                <p>{{$jobs->ekspektasi_gaji}}</p>
                                            </div>
                                            <!-- Single List -->
                                            <!-- Single List -->
                                            <div class="single-list">
                                                <h5 class="title">Application Deadline</h5>
                                                <p><a href="#">{{$jobs->application_deadline}}</a></p>
                                            </div>
                                            <!-- Single List -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Personal Top Content -->
                            <!-- Start Single Section -->
                            <div class="single-section">
                                <h4>About</h4>
                                <p class="font-size-4 mb-8">{!!$jobs->deskripsi_pekerjaan !!}</p>
                                
                            </div>
                            <!-- End Single Section -->
                            <!-- Start Single Section -->
                            <div class="single-section skill">
                                <h4>Skills</h4>
                                <div>
                                   {!!$jobs->deskripsi_pekerjaan !!}
                                </div>
                                <p class="font-size-4 mb-8">{!!$jobs->requirement !!}</p>
                                <ul class="list-unstyled d-flex align-items-center flex-wrap">
                                    <li>
                                        <a href="#">Agile</a>
                                    </li>
                                    <li>
                                        <a href="#">Wireframing</a>
                                    </li>
                                    <li>
                                        <a href="#">Prototyping</a>
                                    </li>
                                    <li>
                                        <a href="#">Information</a>
                                    </li>
                                    <li>
                                        <a href="#">Waterfall Model</a>
                                    </li>
                                    <li>
                                        <a href="#">New Layout</a>
                                    </li>
                                    <li>
                                        <a href="#">Ui/Ux Design</a>
                                    </li>
                                    <li>
                                        <a href="#">Web Design</a>
                                    </li>
                                    <li>
                                        <a href="#">Graphics Design</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Section -->
                            <!-- Start Single Section -->
                            <div class="single-section exprerience">
                                <h4>Work Exprerience</h4>
                                <!-- Single Exp -->
                                <div class="single-exp mb-30">
                                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                                        <div class="image">
                                            <img src="assets/images/resume/work1.png" alt="#">
                                        </div>
                                        <div class="w-100 mt-n2">
                                            <h3 class="mb-0">
                                                <a href="#">Lead Product Designer</a>
                                            </h3>
                                            <a href="#">Airabnb</a>
                                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                                <a href="#">Jun 2020 - April 2023- 3 years</a>
                                                <a href="#" class="font-size-3 text-gray">
                                                    <span class="mr-2" style="margin-top: -2px"><i
                                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Exp -->
                                <!-- Single Exp -->
                                <div class="single-exp mb-30">
                                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                                        <div class="image">
                                            <img src="assets/images/resume/work2.png" alt="#">
                                        </div>
                                        <div class="w-100 mt-n2">
                                            <h3 class="mb-0">
                                                <a href="#">Senior UI/UX Designer</a>
                                            </h3>
                                            <a href="#">Google Inc</a>
                                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                                <a href="#">Jun 2020 - April 2023- 3 years</a>
                                                <a href="#" class="font-size-3 text-gray">
                                                    <span class="mr-2" style="margin-top: -2px"><i
                                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Exp -->
                            </div>
                            <!-- End Single Section -->
                            <!-- Start Single Section -->
                            <div class="single-section education">
                                <h4>Education</h4>
                                <!-- Single Edu -->
                                <div class="single-edu mb-30">
                                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                                        <div class="image">
                                            <img src="assets/images/resume/edu1.svg" alt="#">
                                        </div>
                                        <div class="w-100 mt-n2">
                                            <h3 class="mb-0">
                                                <a href="#">Masters in Art Design</a>
                                            </h3>
                                            <a href="#">Harvard University</a>
                                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                                <a href="#">Jun 2020 - April 2023- 3 years</a>
                                                <a href="#" class="font-size-3 text-gray">
                                                    <span class="mr-2" style="margin-top: -2px"><i
                                                            class="lni lni-map-marker"></i></span>Brylin, USA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Edu -->
                                <!-- Single Edu -->
                                <div class="single-edu mb-30">
                                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                                        <div class="image">
                                            <img src="assets/images/resume/edu2.svg" alt="#">
                                        </div>
                                        <div class="w-100 mt-n2">
                                            <h3 class="mb-0">
                                                <a href="#">Bachelor in Software Engineering</a>
                                            </h3>
                                            <a href="#">Manipal Institute of Technology</a>
                                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                                <a href="#">Fed 2019 - April 2023 - 4 years </a>
                                                <a href="#" class="font-size-3 text-gray">
                                                    <span class="mr-2" style="margin-top: -2px"><i
                                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Edu -->
                            </div>
                            <!-- End Single Section -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection