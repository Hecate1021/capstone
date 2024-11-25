<?php

namespace App\Providers;

use App\Models\UserInfo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class UserProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * * @return void
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $user = Auth::user();
            $userInfo = null;

            if ($user) {
                $userInfo = UserInfo::where('user_id', $user->id)->first();
            }

            $view->with('userInfo', $userInfo);
        });

    }
}
