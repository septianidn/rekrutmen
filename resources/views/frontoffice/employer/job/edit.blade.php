@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('page-title', 'Edit Lowongan')
@section('page-subtitle', 'Perbarui detail lowongan pekerjaan.')
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input class="form-control" type="text" name="posisi" value="{{$jobs->posisi}}">                                        
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Job Types*</label>
                                        @php $currentWorktime = old('worktime', $jobs->worktime); @endphp
                                        <select class="select" name="worktime">
                                            <option value="Full Time" @selected($currentWorktime === 'Full Time')>Full Time</option>
                                            <option value="Part Time" @selected($currentWorktime === 'Part Time')>Part Time</option>
                                            <option value="Contract" @selected($currentWorktime === 'Contract')>Contract</option>
                                            <option value="Internship" @selected($currentWorktime === 'Internship')>Internship</option>
                                            <option value="Office" @selected($currentWorktime === 'Office')>Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Application Deadline</label>
                                        <div class="input-group date" id="datetimepicker">
                                            <input type="date" class="form-control" value="{{ old('application_deadline', $jobs->application_deadline) }}" name="application_deadline">
                                            <span class="input-group-addon"></span>
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Salary Starting at</label>
                                        @php $currentGaji = (string) old('ekspektasi_gaji', $jobs->ekspektasi_gaji); @endphp
                                        <select class="select" name="ekspektasi_gaji">
                                            <option value="0" @selected($currentGaji === '0')>TBA</option>
                                            <option value="1500000" @selected($currentGaji === '1500000')>Rp.1.500.000</option>
                                            <option value="2500000" @selected($currentGaji === '2500000')>Rp.2.500.000</option>
                                            <option value="4500000" @selected($currentGaji === '4500000')>Rp.4.500.000</option>
                                            <option value="6500000" @selected($currentGaji === '6500000')>Rp.6.500.000</option>
                                            <option value="8500000" @selected($currentGaji === '8500000')>Rp.8.500.000</option>
                                            <option value="10000000" @selected($currentGaji === '10000000')>Rp.10.000.000</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job Description*</label>
                                        <div id="deskripsi_editor" style="height:250px"></div>
                                        <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" style="display:none">{{ old('deskripsi_pekerjaan', $jobs->deskripsi_pekerjaan) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Job Requirement*</label>
                                        <div id="requirement_editor" style="height:250px"></div>
                                        <textarea name="requirement" id="requirement" style="display:none">{{ old('requirement', $jobs->requirement) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <h4 class="title mt-3">Tahap Seleksi <span class="text-danger">*</span></h4>
                                    @php
                                        $progressExists = \App\Models\Progress::whereHas('step', fn($q) => $q->where('job_id', $jobs->id))->exists();
                                    @endphp
                                    @if($progressExists)
                                        <div class="alert alert-warning">
                                            Tahap seleksi tidak dapat diubah karena sudah ada pelamar yang sedang diproses.
                                        </div>
                                    @endif
                                    <p class="text-muted mb-2">
                                        Tentukan tahapan yang harus dilalui pelamar. Minimal satu tahap. Urutan mengikuti urutan baris di bawah.
                                    </p>
                                    @error('steps')<div class="text-danger mb-2">{{ $message }}</div>@enderror
                                    @foreach($errors->get('steps.*.proses_id') as $msgs)
                                        @foreach($msgs as $msg)<div class="text-danger mb-2">{{ $msg }}</div>@endforeach
                                    @endforeach
                                    <div id="steps-wrapper">
                                        @php
                                            $existingSteps = old('steps', $jobs->steps->map(fn($s) => [
                                                'proses_id' => $s->proses_id,
                                                'deskripsi' => $s->deskripsi,
                                            ])->toArray());
                                            if (empty($existingSteps)) {
                                                $existingSteps = [['proses_id' => '', 'deskripsi' => '']];
                                            }
                                        @endphp
                                        @foreach($existingSteps as $i => $step)
                                        <div class="row align-items-start step-row mb-2" data-step-row>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Tahap</label>
                                                    <select class="form-control" name="steps[{{ $i }}][proses_id]" {{ $progressExists ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Tahap --</option>
                                                        @foreach($prosesList as $proses)
                                                            <option value="{{ $proses->id }}" {{ (string)($step['proses_id'] ?? '') === (string)$proses->id ? 'selected' : '' }}>
                                                                {{ $proses->nama_proses }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="form-group">
                                                    <label>Deskripsi / Instruksi</label>
                                                    <input type="text" class="form-control" name="steps[{{ $i }}][deskripsi]"
                                                           value="{{ $step['deskripsi'] ?? '' }}"
                                                           placeholder="Contoh: upload berkas KTP, CV, transkrip"
                                                           {{ $progressExists ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1 d-flex align-items-center" style="padding-top: 28px;">
                                                @unless($progressExists)
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-step>&times;</button>
                                                @endunless
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @unless($progressExists)
                                        <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="add-step-btn">
                                            + Tambah Tahap
                                        </button>
                                    @endunless
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Company Website</label>
                                        <input class="form-control" type="text" name="Website">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Company Industry</label>
                                        <input class="form-control" type="text" name="Industry">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Facebook Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Linkedin Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Twitter Page (Link)</label>
                                        <input class="form-control" type="text" name="Link">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input class="form-control" type="text" name="Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
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
        const toolbarOptions = [
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
            [{ header: [1, 2, 3, false] }],
            ['clean']
        ];

        const descEditor = new Quill('#deskripsi_editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });
        const reqEditor  = new Quill('#requirement_editor',  { theme: 'snow', modules: { toolbar: toolbarOptions } });

        const descInit = document.getElementById('deskripsi_pekerjaan').value;
        if (descInit) descEditor.clipboard.dangerouslyPasteHTML(descInit);

        const reqInit = document.getElementById('requirement').value;
        if (reqInit) reqEditor.clipboard.dangerouslyPasteHTML(reqInit);

        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('deskripsi_pekerjaan').value =
                descEditor.getText().trim() === '' ? '' : descEditor.root.innerHTML;
            document.getElementById('requirement').value =
                reqEditor.getText().trim() === '' ? '' : reqEditor.root.innerHTML;
        });

        (function () {
            const wrapper = document.getElementById('steps-wrapper');
            const addBtn = document.getElementById('add-step-btn');
            if (!wrapper || !addBtn) return;

            const prosesOptions = @json($prosesList->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_proses])->values());

            function reindex() {
                wrapper.querySelectorAll('[data-step-row]').forEach((row, i) => {
                    row.querySelectorAll('[name]').forEach((el) => {
                        el.name = el.name.replace(/steps\[\d+\]/, `steps[${i}]`);
                    });
                });
            }

            addBtn.addEventListener('click', function () {
                const i = wrapper.querySelectorAll('[data-step-row]').length;
                const optsHtml = ['<option value="">-- Pilih Tahap --</option>']
                    .concat(prosesOptions.map(o => `<option value="${o.id}">${o.nama}</option>`))
                    .join('');
                const html = `
                    <div class="row align-items-start step-row mb-2" data-step-row>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Tahap</label>
                                <select class="form-control" name="steps[${i}][proses_id]">${optsHtml}</select>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label>Deskripsi / Instruksi</label>
                                <input type="text" class="form-control" name="steps[${i}][deskripsi]" placeholder="Contoh: upload berkas KTP, CV, transkrip">
                            </div>
                        </div>
                        <div class="col-12 col-md-1 d-flex align-items-center" style="padding-top: 28px;">
                            <button type="button" class="btn btn-sm btn-outline-danger" data-remove-step>&times;</button>
                        </div>
                    </div>`;
                wrapper.insertAdjacentHTML('beforeend', html);
            });

            wrapper.addEventListener('click', function (e) {
                if (e.target.matches('[data-remove-step]')) {
                    const row = e.target.closest('[data-step-row]');
                    if (row) row.remove();
                    reindex();
                }
            });
        })();
    </script>
@endsection