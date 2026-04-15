<?php

namespace App\Providers;

use App\Services\NotificationService;
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
