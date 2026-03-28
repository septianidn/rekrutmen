@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('content')

<section class="job-post">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="job-information">
                        <h3 class="title">Job Information</h3>
                        <form action="{{route('employer.job.update', ['job'=>$jobs->id])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <input type="hidden" name="employer_id" value="{{$jobs->employer->id}}">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job title*</label>
                                        <input class="form-control" type="text" name="nama_pekerjaan" value="{{$jobs->nama_pekerjaan}}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job address*</label>
                                        <input class="form-control" type="text" name="alamat" value="{{$jobs->alamat}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input class="form-control" type="text" name="posisi" value="{{$jobs->posisi}}">                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Job Types*</label>
                                        <select class="select" name="worktime">
                                            <option value="Full Time">Full Time</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Internship">Internship</option>
                                            <option value="Office">Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Application Deadline</label>
                                        <div class="input-group date" id="datetimepicker">
                                            <input type="date" class="form-control" placeholder="{{$jobs->application_deadline}}" name="application_deadline">
                                            <span class="input-group-addon"></span>
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Salary Starting at</label>
                                        <select class="select" name="ekspektasi_gaji">
                                            <option value="0">TBA</option>
                                            <option value="1500000">Rp.1.500.000</option>
                                            <option value="3500000">Rp.2.500.000</option>
                                            <option value="4500000">Rp.4.500.000</option>
                                            <option value="6500000">Rp.6.500.000</option>
                                            <option value="8500000">Rp.8.500.000</option>
                                            <option value="10000000">Rp.10.000.000</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job Requirement*</label>
                                        <textarea name="requirement" class="form-control" rows="5" value="{{$jobs->requirement}}"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job Description*</label>
                                        <textarea name="deskripsi_pekerjaan" class="form-control" rows="5" value="{{$jobs->deskripsi_pekerjaan}}"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 button">
                                    <button class="btn">
                                        Post a Job
                                    </button>
                                </div>
                            </div>
                        </form>

                            <h3 class="title mt-4">Informasi Tambahan</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nama Perusahaan</label>
                                        <input class="form-control" type="text" name="Company">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Company Website</label>
                                        <input class="form-control" type="text" name="Website">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Company Industry</label>
                                        <input class="form-control" type="text" name="Industry">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Facebook Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Linkedin Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Twitter Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Instagram Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Company Description*</label>
                                        <textarea name="message" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="choose-img">
                                        <p>Logo (Optional)</p>
                                        <label for="img">Select image:</label>
                                        <input type="file" id="img" name="img" accept="image/*">
                                        <p>Maximum file size: 2 MB</p>
                                    </div>
                                </div>
                            </div>
                            <h3 class="title">Recruiter Information</h3>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input class="form-control" type="text" name="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="email" name="email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group checkboxs">
                                        <input type="checkbox" class="checkboxs" id="chb2">
                                        <p>
                                            By clicking checkbox, you agree to our <a href="terms-conditions.html">Terms
                                                &
                                                Conditions</a> And <a href="privacy-policy.html">Privacy Policy.</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12 button">
                                    <button class="btn" type="submit">
                                        Post a Job
                                    </button>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
        CKEDITOR.replace('deskripsi_pekerjaan', {
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                { name: 'styles', items: ['Format'] },
                { name: 'clipboard', items: ['Undo', 'Redo'] }
            ],
            height: 300
        });
        CKEDITOR.replace('requirement', {
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                { name: 'styles', items: ['Format'] },
                { name: 'clipboard', items: ['Undo', 'Redo'] }
            ],
            height: 300
        });
    </script>
@endsection