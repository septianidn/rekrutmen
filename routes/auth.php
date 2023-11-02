<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::get('/register', [RegisteredUserController::class, 'create'])
//                 ->middleware('guest')
//                 ->name('register');

// Route::post('/register', [RegisteredUserController::class, 'store'])
//                 ->middleware('guest');

Route::group(['middleware' => ['guest:web'],'RevalidateBackHistory'], function () {

    Route::get('/backoffic3', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/backoffic3', [AuthenticatedSessionController::class, 'store']);
    Route::get('/backoffic3/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/backoffic3/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/backoffic3/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/backoffic3/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});
 
Route::group(['middleware' => ['auth:web'],'RevalidateBackHistory'], function () {       
    Route::get('/backoffic3/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                    ->name('verification.notice');
    Route::get('/backoffic3/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('verification.verify');
    Route::post('/backoffic3/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware([ 'throttle:6,1'])
                    ->name('verification.send');
    Route::get('/backoffic3/confirm-password', [ConfirmablePasswordController::class, 'show'])           
                    ->name('password.confirm');
    Route::post('/backoffic3/confirm-password', [ConfirmablePasswordController::class, 'store']);           
    Route::post('/backoffic3/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('logout');
 });
