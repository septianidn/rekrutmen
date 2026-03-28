@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('content')

                   
                        <div class="job-items">
                            <div>
                                <a href="{{route('employer.job.create')}}">
                                    <button class="btn btn-primary btn-sm" >Tambah</button>
                                </a>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-success btn-sm">Download</button>
                            </div>
                            <div class="manage-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-12">
                                        <p>Name</p>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <p>Contract Type</p>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <p>Action</p>
                                    </div>
                                </div>
                            </div>

                            @foreach ($jobs as $j)
                            <div class="manage-content">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-6 col-md-3 col-12">
                                        <h3><a href="{{ route('employer.job.show', ['job'=>$j->id]) }}">{{$j->nama_pekerjaan}}</a></h3>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <p><span class="time">{{$j->worktime}}</span></p>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12">
                                        <p><i class="lni lni-star"></i></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Pagination -->
                        <div class="pagination left pagination-md-center">
                            <ul class="pagination-list">
                                <li><a href="#"><i class="lni lni-arrow-left"></i></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="lni lni-arrow-right"></i></a></li>
                            </ul>
                        </div>
                        <!-- End Pagination -->

@endsection