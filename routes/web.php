<?php

// Controllers
use App\Models\Konselor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\BackOffice\ProdiController;
use App\Http\Controllers\BackOffice\KontenController;

use App\Http\Controllers\BackOffice\JenjangController;
use App\Http\Controllers\BackOffice\JobController as BackofficeJobController;
use App\Http\Controllers\BackOffice\JobFairController;
use App\Http\Controllers\BackOffice\EmailBoxController;
use App\Http\Controllers\BackOffice\FakultasController;

use App\Http\Controllers\BackOffice\KonselorController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\BackOffice\EmailSendController;
use App\Http\Controllers\BackOffice\GrupKontenController;
use App\Http\Controllers\BackOffice\KelolaAdminController;
use App\Http\Controllers\BackOffice\EmployerVerificationController;
use App\Http\Controllers\BackOffice\UploadAvatarController;
use App\Http\Controllers\FrontOffice\JobFairController as FrontJobFairController;
use App\Http\Controllers\FrontOffice\LandingPageController;
use App\Http\Controllers\BackOffice\EmailTemplateController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// Packages
use App\Http\Controllers\BackOffice\KategoriKontenController;
use App\Http\Controllers\Auth\EmployerAuth\AuthenticatedSessionController as AuthenticatedSessionControllerEmployer;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobseekerController;
use App\Livewire\RiwayatPendidikan;
use App\Models\Jobseeker;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//Front Office Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
Route::get('/vacancy', [LandingPageController::class, 'vacancy'])->name('vacancy');
Route::post('/register', [AuthenticatedSessionControllerEmployer::class, 'register'])->name('register')->middleware('guest');

// Notifications (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/notification/{id}/read', [NotificationController::class, 'markAsRead'])->name('notification.read');
    Route::post('/notification/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notification.mark-all-read');
});


Route::prefix('employer')->name('employer.')->group(function(){

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login.create');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
        Route::post('/logout', [AuthenticatedSessionControllerEmployer::class, 'destroy'])->name('logout');

    });
    
Route::group(['middleware' => 'role:employer'], function () {
        Route::get('/verifikasi', [EmployerController::class, 'verifikasi'])->name('cek_verifikasi');
        Route::post('/verifikasi', [EmployerController::class, 'store'])->name('verifikasi');

    Route::group(['middleware' => 'verified_employer'], function(){
        Route::get('/index', [EmployerController::class, 'home'])->name('index');
        Route::get('/profile', [EmployerController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [EmployerController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [EmployerController::class, 'update'])->name('profile.update');      
        // Route::get('/jobs', [JobController::class, 'index'])->name('jobs');      
        // Route::get('/job/create', [JobController::class, 'create'])->name('job.create');      
        // Route::post('/job/store', [JobController::class, 'store'])->name('job.store');   
        // Route::post('/job/store', [JobController::class, 'store'])->name('job.store');   
        Route::patch('/job/{job}/close', [JobController::class, 'close'])->name('job.close');
        Route::patch('/job/{job}/reopen', [JobController::class, 'reopen'])->name('job.reopen');
        Route::resource('job', JobController::class)->except(['destroy']);
        Route::get('/job/{job}/applicants', [ApplicationController::class, 'applicants'])->name('job.applicants');
        Route::patch('/application/{application}/status', [ApplicationController::class, 'updateStatus'])->name('application.update-status');
        Route::get('/application/{application}/progress', [ApplicationController::class, 'progress'])->name('application.progress');
        Route::post('/application/{application}/progress/{step}', [ApplicationController::class, 'updateProgress'])->name('application.progress.update');
        Route::get('/applicant/{jobseeker}/cv', [ApplicationController::class, 'viewCv'])->name('applicant.cv');
        Route::get('/applicant/{jobseeker}/cv-pdf', [ApplicationController::class, 'downloadCv'])->name('applicant.cv-pdf');

        Route::get('/job-fair', [FrontJobFairController::class, 'employerIndex'])->name('job-fair.index');
        Route::get('/job-fair/{jobFair}', [FrontJobFairController::class, 'employerShow'])->name('job-fair.show');
        Route::post('/job-fair/{jobFair}/register', [FrontJobFairController::class, 'employerRegister'])->name('job-fair.register');
        Route::delete('/job-fair/{jobFair}/cancel/{jobId}', [FrontJobFairController::class, 'employerCancel'])->name('job-fair.cancel');

        });
        
           
        // Route::post('/{alias_url}/submit', [PengisianController::class, 'submit'])->name('tracerstudy-pengisian.form-submit');
        // Route::post('/{alias_url}/check-influence', [PengisianController::class, 'checkInfluence'])->name('tracerstudy-pengisian.form-check-influence');
        // Route::post('/{alias_url}/change-flag', [PengisianController::class, 'changeFlag'])->name('tracerstudy-pengisian.form-change-flag');
        // Route::get('/{alias_url}/{nim}/logout', [PengisianController::class, 'finished'])->name('tracerstudy-pengisian.form-finished');
        // Route::get('/logout/{alias_url}', [AuthenticatedSessionControllerAlumni::class, 'destroy'])->name('tracerstudy-login.destroy');

    });
});

Route::prefix('jobseeker')->name('jobseeker.')->group(function(){
    Route::group(['middleware'=> 'role:mahasiswa'], function(){
        Route::get('index', [JobseekerController::class, 'index'])->name('index');
        Route::get('profile', [JobseekerController::class,'profile'])->name('profile');
        Route::get('profile/edit', [JobseekerController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile/update', [JobseekerController::class, 'updateProfile'])->name('profile.update');
        Route::get('profile/riwayat-pendidikan', RiwayatPendidikan::class)->name('profile.riwayat-pendidikan');
        Route::get('jobs', [JobseekerController::class, 'joblist'])->name('jobs');
        Route::post('jobs/{job}/apply', [JobseekerController::class, 'applyJob'])->name('jobs.apply');
        Route::get('my-applications', [JobseekerController::class, 'myApplications'])->name('my-applications');
        Route::get('my-applications/{application}/progress', [JobseekerController::class, 'applicationProgress'])->name('application.progress');
        Route::get('cv-pdf', [JobseekerController::class, 'downloadCvPdf'])->name('cv-pdf');
        Route::get('job-fair', [FrontJobFairController::class, 'studentIndex'])->name('job-fair.index');
        Route::get('job-fair/{jobFair}', [FrontJobFairController::class, 'studentShow'])->name('job-fair.show');
    });
});


//Back Office : ROLE : ADMIN, ADMIN PRODI GUARD : WEB (CHANGE TO ADMIN)


Route::middleware(['auth:web'])->group(function () {
Route::prefix('backoffic3')->name('backoffice.')->group(function(){

    Route::middleware('role:admin')->group(function () {

        Route::group(['prefix' => 'users'], function () {
            Route::resource('/users', UserController::class);
            Route::get('/delete-selected', [UserController::class, 'deletedSelected'])->name('deleted-selected-users');
            Route::resource('/kelola-admin', KelolaAdminController::class);
            Route::get('/admin/delete-selected', [KelolaAdminController::class, 'deletedSelected'])->name('deleted-selected-admin');

            Route::post('/upload-avatar', [UploadAvatarController::class, 'tmpUpload'])->name('upload-profile-image.store');
            Route::delete('/delete-avatar', [UploadAvatarController::class, 'tmpDelete'])->name('upload-profile-image.destroy');
            Route::get('/fetch-avatar', [UploadAvatarController::class, 'fetch'])->name('upload-profile-image.fetch');
        });


            Route::resource('/konselor', KonselorController::class);
            Route::get('/konselor/delete-selected', [KonselorController::class, 'deletedSelected'])->name('deleted-selected-konselor');

        // Permission Module
        // Route::get('/role-permission',[RolePermission::class, 'index'])->name('role.permission.list');
        Route::group(['prefix' => 'security'], function () {
            Route::resource('/permission', PermissionController::class);
            Route::resource('/role-permission', RolePermission::class);
            Route::resource('/role', RoleController::class);
        });

        Route::group(['prefix' => 'datamaster'], function () {
            Route::resource('/jenjang', JenjangController::class);
            Route::resource('/fakultas', FakultasController::class);

        });


        Route::group(['prefix' => 'email'], function () {
            Route::resource('/template', EmailTemplateController::class);
            Route::resource('/outbox', EmailBoxController::class);
            Route::get('/delete-selected', [EmailBoxController::class, 'deletedSelected'])->name('deleted-selected-emailbox');
            Route::resource('/send', EmailSendController::class);
        });

        Route::resource('/job-fair', JobFairController::class);
        Route::patch('/job-fair/{job_fair}/participant/{pivot}', [JobFairController::class, 'updateParticipant'])->name('job-fair.participant.update');

        Route::get('/job', [BackofficeJobController::class, 'index'])->name('job.index');
        Route::get('/job/{job}', [BackofficeJobController::class, 'show'])->name('job.show');
        Route::delete('/job/{job}', [BackofficeJobController::class, 'destroy'])->name('job.destroy');
        Route::patch('/job/{job}/restore', [BackofficeJobController::class, 'restore'])->name('job.restore');

        Route::get('/employer-verification', [EmployerVerificationController::class, 'index'])->name('employer-verification.index');
        Route::get('/employer-verification/{employer}', [EmployerVerificationController::class, 'show'])->name('employer-verification.show');
        Route::post('/employer-verification/{employer}/approve', [EmployerVerificationController::class, 'approve'])->name('employer-verification.approve');
        Route::post('/employer-verification/{employer}/reject', [EmployerVerificationController::class, 'reject'])->name('employer-verification.reject');

        Route::group(['prefix' => 'konten'], function () {
            Route::resource('/grup-konten', GrupKontenController::class);
            Route::resource('/kategori-konten', KategoriKontenController::class);
            Route::resource('/kelola-konten', KontenController::class);
        });



    });

    Route::middleware('role:admin|konselor')->group(function () {
        Route::middleware('RevalidateBackHistory')->group(function () {
            Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        });
        Route::get('/confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
        Route::get('/lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
        Route::get('/recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');

        Route::get('/userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
        Route::group(['prefix' => 'datamaster'], function () {
            Route::resource('/prodi', ProdiController::class);
        });
    });

    Route::middleware('role:konselor')->group(function () {

    });


});


});


//TEMPLATE
//UI Pages Routs
Route::get('/home', [HomeController::class, 'uisheet'])->name('uisheet');

//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function () {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
Route::group(['prefix' => 'special-pages'], function () {
    //Example Page Routs
    Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
    Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
    Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
    Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
    Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
});

//Widget Routs
Route::group(['prefix' => 'widget'], function () {
    Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
    Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
    Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
});

//Maps Routs
Route::group(['prefix' => 'maps'], function () {
    Route::get('google', [HomeController::class, 'google'])->name('maps.google');
    Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function () {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});

//Forms Pages Routs
Route::group(['prefix' => 'forms'], function () {
    Route::get('element', [HomeController::class, 'element'])->name('forms.element');
    Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
    Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
});

//Table Page Routs
Route::group(['prefix' => 'table'], function () {
    Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
});

//Icons Page Routs
Route::group(['prefix' => 'icons'], function () {
    Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
    Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
    Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
    Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
});

//Extra Page Routs
Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');


// Route::resource('jobseeker', App\Http\Controllers\JobseekerController::class)->only('index', 'create', 'store');


// Route::resource('jobseeker', App\Http\Controllers\JobseekerController::class)->only('index', 'create', 'store');





// Route::resource('jobseeker', App\Http\Controllers\JobseekerController::class);

// Route::resource('membership', App\Http\Controllers\MembershipController::class);

// Route::resource('pembayaran', App\Http\Controllers\PembayaranController::class);

// Route::resource('account', App\Http\Controllers\AccountController::class);

// Route::resource('user', App\Http\Controllers\UserController::class);

// Route::resource('employer', App\Http\Controllers\EmployerController::class);

// Route::resource('industri-type', App\Http\Controllers\IndustriTypeController::class);

// Route::resource('job', App\Http\Controllers\JobController::class);

// Route::resource('posisi', App\Http\Controllers\PosisiController::class);

// Route::resource('step', App\Http\Controllers\StepController::class);

// Route::resource('proses', App\Http\Controllers\ProsesController::class);

// Route::resource('progress', App\Http\Controllers\ProgressController::class);

// Route::resource('application', App\Http\Controllers\ApplicationController::class);

// Route::resource('jobseeker-type', App\Http\Controllers\JobseekerTypeController::class);

// Route::resource('organisasi', App\Http\Controllers\OrganisasiController::class);

// Route::resource('bahasa', App\Http\Controllers\BahasaController::class);

// Route::resource('riwayat-kerja', App\Http\Controllers\RiwayatKerjaController::class);

// Route::resource('prestasi', App\Http\Controllers\PrestasiController::class);

// Route::resource('riwayat-pendidikan', App\Http\Controllers\RiwayatPendidikanController::class);

// Route::resource('pelatihan', App\Http\Controllers\PelatihanController::class);

// Route::resource('rekomendasi', App\Http\Controllers\RekomendasiController::class);

// Route::resource('posisi', App\Http\Controllers\PosisiController::class);

// Route::resource('step', App\Http\Controllers\StepController::class);

// Route::resource('proses', App\Http\Controllers\ProsesController::class);

// Route::resource('progress', App\Http\Controllers\ProgressController::class);

// Route::resource('application', App\Http\Controllers\ApplicationController::class);

// Route::resource('jobseeker-type', App\Http\Controllers\JobseekerTypeController::class);

// Route::resource('organisasi', App\Http\Controllers\OrganisasiController::class);

// Route::resource('bahasa', App\Http\Controllers\BahasaController::class);

// Route::resource('riwayat-kerja', App\Http\Controllers\RiwayatKerjaController::class);

// Route::resource('prestasi', App\Http\Controllers\PrestasiController::class);

// Route::resource('riwayat-pendidikan', App\Http\Controllers\RiwayatPendidikanController::class);

// Route::resource('pelatihan', App\Http\Controllers\PelatihanController::class);

// Route::resource('rekomendasi', App\Http\Controllers\RekomendasiController::class);




// Route::resource('jobseeker', App\Http\Controllers\JobseekerController::class);

// Route::resource('membership', App\Http\Controllers\MembershipController::class);

// Route::resource('pembayaran', App\Http\Controllers\PembayaranController::class);

// Route::resource('account', App\Http\Controllers\AccountController::class);

// Route::resource('user', App\Http\Controllers\UserController::class);

// Route::resource('employer', App\Http\Controllers\EmployerController::class);

// Route::resource('industri-type', App\Http\Controllers\IndustriTypeController::class);

// Route::resource('job', App\Http\Controllers\JobController::class);

// Route::resource('posisi', App\Http\Controllers\PosisiController::class);

// Route::resource('step', App\Http\Controllers\StepController::class);

// Route::resource('proses', App\Http\Controllers\ProsesController::class);

// Route::resource('progress', App\Http\Controllers\ProgressController::class);

// Route::resource('application', App\Http\Controllers\ApplicationController::class);

// Route::resource('jobseeker-type', App\Http\Controllers\JobseekerTypeController::class);

// Route::resource('organisasi', App\Http\Controllers\OrganisasiController::class);

// Route::resource('bahasa', App\Http\Controllers\BahasaController::class);

// Route::resource('riwayat-kerja', App\Http\Controllers\RiwayatKerjaController::class);

// Route::resource('prestasi', App\Http\Controllers\PrestasiController::class);

// Route::resource('riwayat-pendidikan', App\Http\Controllers\RiwayatPendidikanController::class);

// Route::resource('pelatihan', App\Http\Controllers\PelatihanController::class);

// Route::resource('rekomendasi', App\Http\Controllers\RekomendasiController::class);


// Route::resource('jobseeker', App\Http\Controllers\JobseekerController::class);

// Route::resource('membership', App\Http\Controllers\MembershipController::class);

// Route::resource('pembayaran', App\Http\Controllers\PembayaranController::class);

// Route::resource('account', App\Http\Controllers\AccountController::class);

// Route::resource('user', App\Http\Controllers\UserController::class);

// Route::resource('employer', App\Http\Controllers\EmployerController::class);

// Route::resource('industri-type', App\Http\Controllers\IndustriTypeController::class);

// Route::resource('job', App\Http\Controllers\JobController::class);

// Route::resource('posisi', App\Http\Controllers\PosisiController::class);

// Route::resource('step', App\Http\Controllers\StepController::class);

// Route::resource('proses', App\Http\Controllers\ProsesController::class);

// Route::resource('progress', App\Http\Controllers\ProgressController::class);

// Route::resource('application', App\Http\Controllers\ApplicationController::class);

// Route::resource('jobseeker-type', App\Http\Controllers\JobseekerTypeController::class);

// Route::resource('organisasi', App\Http\Controllers\OrganisasiController::class);

// Route::resource('bahasa', App\Http\Controllers\BahasaController::class);

// Route::resource('riwayat-kerja', App\Http\Controllers\RiwayatKerjaController::class);

// Route::resource('prestasi', App\Http\Controllers\PrestasiController::class);

// Route::resource('riwayat-pendidikan', App\Http\Controllers\RiwayatPendidikanController::class);

// Route::resource('pelatihan', App\Http\Controllers\PelatihanController::class);

// Route::resource('rekomendasi', App\Http\Controllers\RekomendasiController::class);
