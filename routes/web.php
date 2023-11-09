<?php

// Controllers

use App\Http\Controllers\BackOffice\EmailBoxController;
use App\Http\Controllers\BackOffice\EmailSendController;
use App\Http\Controllers\BackOffice\EmailTemplateController;
use App\Http\Controllers\BackOffice\FakultasController;
use App\Http\Controllers\BackOffice\GrupKontenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontOffice\LandingPageController;
use App\Http\Controllers\BackOffice\KelolaAdminController;
use App\Http\Controllers\BackOffice\JenjangController;

use App\Http\Controllers\BackOffice\KategoriKontenController;
use App\Http\Controllers\BackOffice\KonselorController;
use App\Http\Controllers\BackOffice\KontenController;

use App\Http\Controllers\BackOffice\ProdiController;
use App\Http\Controllers\BackOffice\UploadAvatarController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\UserController;
use App\Models\Konselor;
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
