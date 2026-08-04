{{-- Login Modal --}}
<div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog max-width-px-840 position-relative">
        <button type="button"
            class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
            data-dismiss="modal">
            <i class="lni lni-close"></i>
        </button>
        <div class="login-modal-main">
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="row">
                        <div class="heading">
                            <h3>Masuk Di Sini</h3>
                            <p>
                                Masuk untuk melanjutkan ke akun Anda <br />
                                dan menjelajahi lowongan baru.
                            </p>
                        </div>
                        <form action="{{ route('employer.login.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="label">E-mail</label>
                                <input type="email" class="form-control" placeholder="example@gmail.com"
                                    id="email" name="email"/>
                            </div>
                            <div class="form-group">
                                <label for="password" class="label">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Masukkan password" name="password"/>
                                    <button type="button" class="btn-peek" onclick="togglePassword(this)">
                                        <i class="lni lni-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-wrap justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value
                                        id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">Ingat Saya</label>
                                </div>
                                <a href="{{ route('user.password.request') }}" class="font-size-3 text-dodger line-height-reset">Lupa Password?</a>
                            </div>
                            <div class="form-group mb-8 button">
                                <button class="btn" type="submit">Masuk</button>
                            </div>
                            <p class="text-center create-new-account">
                                Belum punya akun? <a href="javascript:void(0)" data-switch-modal="signup" data-from-modal="login">Buat akun gratis</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Signup Modal --}}
<div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog max-width-px-840 position-relative">
        <button type="button"
            class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
            data-dismiss="modal">
            <i class="lni lni-close"></i>
        </button>
        <div class="login-modal-main">
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="row">
                        <div class="heading">
                            <h3>
                                Buat Akun Gratis <br />
                                Sekarang
                            </h3>
                            <p>
                                Buat akun Anda untuk melanjutkan <br />
                                dan menjelajahi lowongan baru.
                            </p>
                        </div>
                        <form action="{{ route('register') }}" method="POST" id="signupForm">
                            @csrf
                            @if($errors->any() && old('_signup_form'))
                                <div class="alert alert-danger py-2 px-3 small">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="label">Daftar Sebagai</label>
                                <div class="d-flex flex-wrap" style="gap: 1rem;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" value="employer" id="roleEmployer" {{ old('role', 'employer') === 'employer' ? 'checked' : '' }} required />
                                        <label class="form-check-label" for="roleEmployer">Employer (Perusahaan)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" value="mahasiswa" id="roleJobseeker" {{ old('role') === 'mahasiswa' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="roleJobseeker">Jobseeker (Pencari Kerja)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none" id="jobseekerTypeGroup">
                                <label class="label">Tipe Jobseeker</label>
                                <select name="jobseeker_type_id" class="form-control" id="jobseekerTypeSelect">
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach(($jobseekerTypes ?? \App\Models\JobseekerType::all()) as $type)
                                        <option value="{{ $type->id }}" {{ old('jobseeker_type_id') == $type->id ? 'selected' : '' }}>{{ $type->jobseekerType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label">E-mail</label>
                                <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" required />
                            </div>
                            <div class="form-group">
                                <label class="label">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required minlength="8" />
                                    <button type="button" class="btn-peek" onclick="togglePassword(this)">
                                        <i class="lni lni-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Konfirmasi Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required minlength="8" />
                                    <button type="button" class="btn-peek" onclick="togglePassword(this)">
                                        <i class="lni lni-eye"></i>
                                    </button>
                                </div>
                                <small class="text-danger d-none" id="pw-mismatch">Password tidak cocok.</small>
                            </div>
                            <input type="hidden" name="_signup_form" value="1">
                            <div class="form-group d-flex flex-wrap justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" required />
                                    <label class="form-check-label">Setuju dengan <a
                                            href="#">Syarat &amp; Ketentuan</a></label>
                                </div>
                            </div>
                            <div class="form-group mb-8 button">
                                <button class="btn" type="submit">Daftar</button>
                            </div>
                            <p class="text-center create-new-account">
                                Sudah punya akun? <a href="javascript:void(0)" data-switch-modal="login" data-from-modal="signup">Masuk</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Make auth modals scrollable on small screens */
.form-modal {
    overflow-y: auto !important;
}
.form-modal .modal-dialog {
    max-height: calc(100vh - 2rem);
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.form-modal .login-modal-main {
    max-height: calc(100vh - 4rem);
    overflow-y: auto;
}
.btn-peek {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0 5px;
    color: #888;
    font-size: 18px;
    z-index: 5;
}
.btn-peek:hover {
    color: #333;
}
.btn-peek.active {
    color: #009A4B;
}
</style>

<script>
function togglePassword(btn) {
    var input = btn.parentElement.querySelector('input');
    if (input.type === 'password') {
        input.type = 'text';
        btn.classList.add('active');
    } else {
        input.type = 'password';
        btn.classList.remove('active');
    }
}

(function() {
    var form = document.getElementById('signupForm');
    if (!form) return;

    var pw = form.querySelector('input[name="password"]');
    var pwc = form.querySelector('input[name="password_confirmation"]');
    var msg = document.getElementById('pw-mismatch');

    function check() {
        if (pwc.value && pw.value !== pwc.value) {
            msg.classList.remove('d-none');
        } else {
            msg.classList.add('d-none');
        }
    }

    pw.addEventListener('input', check);
    pwc.addEventListener('input', check);

    form.addEventListener('submit', function(e) {
        if (pw.value !== pwc.value) {
            e.preventDefault();
            msg.classList.remove('d-none');
        }
    });

    // Role selector → show/hide jobseeker type field
    var roleRadios = form.querySelectorAll('input[name="role"]');
    var jsTypeGroup = document.getElementById('jobseekerTypeGroup');
    var jsTypeSelect = document.getElementById('jobseekerTypeSelect');

    function toggleJobseekerType() {
        var selected = form.querySelector('input[name="role"]:checked');
        if (selected && selected.value === 'mahasiswa') {
            jsTypeGroup.classList.remove('d-none');
            jsTypeSelect.required = true;
        } else {
            jsTypeGroup.classList.add('d-none');
            jsTypeSelect.required = false;
            jsTypeSelect.value = '';
        }
    }

    roleRadios.forEach(function(r) {
        r.addEventListener('change', toggleJobseekerType);
    });
    toggleJobseekerType();

    @if($errors->any() && old('_signup_form'))
        var modal = document.getElementById('signup');
        if (modal && typeof $ !== 'undefined') {
            $(modal).modal('show');
        }
    @endif
})();

(function () {
    // Beralih antar modal masuk/daftar tanpa meninggalkan halaman.
    function switchModal(fromId, toId) {
        if (!document.getElementById(toId) || typeof $ === 'undefined') return;
        var $from = $('#' + fromId);
        var $to = $('#' + toId);
        // Treat a modal that is open OR mid-open-animation as "present" so we
        // always close it before opening the target (avoids stacked backdrops).
        if ($from.length && ($from.hasClass('show') || $from.is(':visible'))) {
            $from.one('hidden.bs.modal.switch', function () { $to.modal('show'); });
            $from.modal('hide');
        } else {
            $to.modal('show');
        }
    }
    document.querySelectorAll('[data-switch-modal]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            switchModal(el.getAttribute('data-from-modal'), el.getAttribute('data-switch-modal'));
        });
    });
})();
</script>
