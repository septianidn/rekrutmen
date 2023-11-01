<?php

// Controllers

use App\Http\Controllers\BackOffice\AdminProdiController;
use App\Http\Controllers\BackOffice\AlumniController;
use App\Http\Controllers\BackOffice\DataPediaController;
use App\Http\Controllers\BackOffice\DataPediaDetailController;
use App\Http\Controllers\BackOffice\DataPediaSController;
use App\Http\Controllers\BackOffice\DataProsesController;
use App\Http\Controllers\BackOffice\EmailBoxController;
use App\Http\Controllers\BackOffice\EmailSendController;
use App\Http\Controllers\BackOffice\EmailTemplateController;
use App\Http\Controllers\BackOffice\FakultasController;
use App\Http\Controllers\BackOffice\GrupKontenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontOffice\LandingPageController;
use App\Http\Controllers\FrontOffice\TracerStudy\TracerStudyLandingPageController;
use App\Http\Controllers\BackOffice\KelolaAdminController;
use App\Http\Controllers\BackOffice\JenjangController;
use App\Http\Controllers\BackOffice\KabKotaController;
use App\Http\Controllers\BackOffice\KategoriKontenController;
use App\Http\Controllers\BackOffice\KontenController;
use App\Http\Controllers\BackOffice\LaporanTSController;
use App\Http\Controllers\BackOffice\PaketSoalController;
use App\Http\Controllers\BackOffice\PertanyaanController;
use App\Http\Controllers\BackOffice\ProdiController;
use App\Http\Controllers\BackOffice\ProvinsiController;
use App\Http\Controllers\BackOffice\RekapTCController;
use App\Http\Controllers\BackOffice\UploadAvatarController;
use App\Http\Controllers\BackOffice\UploadFileController;
use App\Http\Controllers\FrontOffice\TracerStudy\LoginAlumniController;
use App\Http\Controllers\FrontOffice\TracerStudy\PengisianController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;

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

//Tracer Study Content
Route::get('/tracerstudy', [TracerStudyLandingPageController::class, 'index'])->name('tracerstudy');
Route::get('/tracerstudy-laporan', [TracerStudyLandingPageController::class, 'laporan'])->name('tracerstudy-laporan');

//Tracer Study Kuesioner

Route::prefix('tracerstudy/kuesioner')->name('kuesioner.')->group(function(){
    Route::group(['middleware' => 'guest:alumni'], function () {
        Route::get('/login/{alias_url}', [LoginAlumniController::class, 'create'])->name('tracerstudy-login.create');
        Route::post('/login/{alias_url}', [LoginAlumniController::class, 'store'])->name('tracerstudy-login.store');
    });
    Route::group(['middleware' => 'auth:alumni'], function () {
        Route::get('/{alias_url}', [PengisianController::class, 'show'])->name('tracerstudy-pengisian.index');
        Route::get('/prolog', [PengisianController::class, 'prolog'])->name('tracerstudy-pengisian.prolog');
    });
});

//Back Office 
Route::prefix('backoffic3')->name('backoffice.')->group(function(){
    Route::group(['middleware' => ['auth:web', 'role:admin', 'RevalidateBackHistory']], function () {
        // Users Module
        Route::resource('/users', UserController::class);

        Route::resource('/kelola-admin', KelolaAdminController::class);
        Route::resource('/kelola-admin-prodi', AdminProdiController::class);

        // Permission Module
        // Route::get('/role-permission',[RolePermission::class, 'index'])->name('role.permission.list');
        Route::resource('/permission', PermissionController::class);
        Route::resource('/role-permission', RolePermission::class);
        Route::resource('/role', RoleController::class);

        //Upload File
        Route::post('/upload-laporants', [UploadFileController::class, 'tmpUpload'])->name('upload-ts');
        Route::delete('/delete-laporants', [UploadFileController::class, 'tmpDelete'])->name('delete-ts');
        Route::post('/upload-avatar', [UploadAvatarController::class, 'tmpUpload'])->name('upload-profile-image.store');
        Route::delete('/delete-avatar', [UploadAvatarController::class, 'tmpDelete'])->name('upload-profile-image.destroy');
        Route::get('/fetch-avatar', [UploadAvatarController::class, 'fetch'])->name('upload-profile-image.fetch');

        Route::group(['prefix' => 'datamaster'], function () {
            Route::resource('/jenjang', JenjangController::class);
            Route::resource('/fakultas', FakultasController::class);

            Route::group(['prefix' => 'alumni'], function () {
                Route::resource('/databasealumni', AlumniController::class);
                Route::get('/delete-selected', [AlumniController::class, 'deletedSelected'])->name('deleted-selected-alumni');
                Route::get('/blasting-ts/create', [AlumniController::class, 'blastingtsCreate'])->name('blastingts.create');
                Route::get('/blasting-ts/store', [AlumniController::class, 'blastingtsStore'])->name('blastingts.store');
                Route::get('/import/create', [AlumniController::class, 'import'])->name('importdatabasealumni.create');
                Route::get('/import/store', [AlumniController::class, 'importStore'])->name('importdatabasealumni.store');
                Route::get('/export/csv', [AlumniController::class, 'exportCSV'])->name('exportcsvdatabasealumni.store');
            });

            Route::group(['prefix' => 'zona'], function () {
                Route::resource('/provinsi', ProvinsiController::class);
                Route::resource('/kabkota', KabKotaController::class);
                
            });

            Route::resource('/datapedia', DataPediaController::class);
            Route::resource('/datapedias', DataPediaSController::class);
            Route::get('/datapedia/detail/{id_datapedia}', [DataPediaDetailController::class, 'index'])->name('datapediadetail.index');
            Route::get('/datapedia/create/{id_datapedia}', [DataPediaDetailController::class, 'create'])->name('datapediadetail.create');
            Route::get('/datapedia/edit/{id_datapedia}/{id}', [DataPediaDetailController::class, 'edit'])->name('datapediadetail.edit');
            Route::post('/datapedia/store', [DataPediaDetailController::class, 'store'])->name('datapediadetail.store');
            Route::patch('/datapedia/update/{id}', [DataPediaDetailController::class, 'update'])->name('datapediadetail.update');
            Route::delete('/datapedia/destroy/{id}', [DataPediaDetailController::class, 'destroy'])->name('datapediadetail.destroy');
        });

        Route::group(['prefix' => 'email'], function () {
            Route::resource('/template', EmailTemplateController::class);
            Route::resource('/outbox', EmailBoxController::class);
            Route::resource('/send', EmailSendController::class);
        });

        Route::group(['prefix' => 'konten'], function () {
            Route::resource('/laporan-tracer-study', LaporanTSController::class);
            Route::resource('/grup-konten', GrupKontenController::class);
            Route::resource('/kategori-konten', KategoriKontenController::class);
            Route::resource('/kelola', KontenController::class);
        });

        Route::group(['prefix' => 'tracer-study'], function () {
            Route::resource('/rekap', RekapTCController::class);
            Route::resource('/paket-soal', PaketSoalController::class);

            Route::get('paket-soal/pertanyaan/{id}', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
            Route::post('paket-soal/pertanyaan/{id}/store', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
            Route::get('paket-soal/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
            Route::post('paket-soal/pertanyaan/{id}/update', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
            
            Route::resource('/usulan-pertanyaan', EmailBoxController::class);
            Route::resource('/jawaban', EmailSendController::class);
        });

    });

    Route::group(['middleware' => ['auth:web', 'role:admin|adminprodi', 'RevalidateBackHistory']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
        Route::get('/lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
        Route::get('/recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    
        Route::get('/userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
        Route::group(['prefix' => 'datamaster'], function () {
            Route::resource('/prodi', ProdiController::class);
        });
    });

    Route::group(['middleware' => ['auth:web', 'role:adminprodi', 'RevalidateBackHistory']], function () {
       
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
