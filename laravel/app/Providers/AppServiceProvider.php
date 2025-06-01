<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // редирект, если пользователь уже авторизован
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            return route('admin.dashboard'); // перенаправление на админку
        });

        // редирект, если пользователь НЕ авторизован
        Authenticate::redirectUsing(function ($request) {
            Session::flash('fail', 'Вы должны войти в систему, чтобы получить доступ к админке.');
            return route('admin.login'); // перенаправление на страницу входа
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
