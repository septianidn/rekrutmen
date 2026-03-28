@extends('frontoffice.jobseeker.templates.body')
@section('jobs', 'active')
@section('content')



<section class="find-job job-list">
        <div class="container">
            <div class="single-head">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <!-- Single Job -->
                        @foreach (
                        $jobs as $j)
                            
                        
                        <div class="single-job">
                            <div class="job-image">
                                <img src="assets/images/jobs/img1.png" alt="#">
                            </div>
                            <div class="job-content">
                                <h4><a href="job-details.html">{{$j->nama_pekerjaan}}</a></h4>
                                <p>{!!$j->deskripsi_pekerjaan !!} </p>
                                <ul>
                                    <li><i class="lni lni-website"></i><a href="#"> {{$j->created_at}}</a></li>
                                    <li><i class="lni lni-dollar"></i>Rp.{{$j->ekspektasi_gaji}}</li>
                                    <li><i class="lni lni-map-marker"></i> {{$j->alamat}}</li>
                                </ul>
                            </div>
                            <div class="job-button">
                                <ul>
                                    <li><a href="job-details.html">Apply</a></li>
                                    <li><span>{{$j->worktime}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Job -->
                    @endforeach

                </div>
                {{$jobs->links('components.paginate')}}
            </div>
        </div>
    </section>

@endsection