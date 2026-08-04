<?php

namespace App\Providers;

use App\Services\NotificationService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Email reset kata sandi dalam bahasa Indonesia, dengan tautan yang
        // mengarah ke halaman reset frontoffice (bertema CDC), bukan backoffice.
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('user.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi — CDC Unand')
                ->greeting('Halo,')
                ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.')
                ->action('Atur Ulang Kata Sandi', $url)
                ->line('Tautan ini akan kedaluwarsa dalam ' . $expire . ' menit.')
                ->line('Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini dan tidak diperlukan tindakan lebih lanjut.')
                ->salutation("Salam,\nTim CDC Unand");
        });

        View::composer([
            'partials.frontoffice._body_nav',
            'partials.dashboard._body_header',
            'frontoffice.employer.template.sidebar',
            'frontoffice.jobseeker.templates.body',
        ], function ($view) {
            if (Auth::check()) {
                $view->with('notifCount', NotificationService::unreadCount(Auth::id()));
                $view->with('notifications', NotificationService::getRecent(Auth::id(), 10));
            } else {
                $view->with('notifCount', 0);
                $view->with('notifications', collect());
            }
        });
    }
}
