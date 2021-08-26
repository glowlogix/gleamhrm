<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        View::composer(
            'layouts.master',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'layouts.print',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'layouts.application-form',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'layouts.partials.left-sidebar',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'layouts.partials.navbar',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'welcome',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'auth.login',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'auth.register',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'auth.passwords.email',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'auth.passwords.reset',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'admin.salary.monthly_salary_slip',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'admin.salary.print_salary_slip',
            'App\Http\View\Composers\PlatformComposer'
        );
        View::composer(
            'admin.salary.generate_salary_slip',
            'App\Http\View\Composers\PlatformComposer'
        );
    }
}
