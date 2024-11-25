<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $manifest = json_decode(File::get(public_path('build/manifest.json')), true);
            $view->with('manifest', $manifest);
        });
        // Share unread message count with all views
    View::composer('*', function ($view) {
        $unreadCount = 0;
        if (Auth::check()) {
            $unreadCount = Message::where('receiver_id', Auth::id())
                                  ->where('is_read', false)
                                  ->count();
        }
        $view->with('unreadCount', $unreadCount);
    });
    }
}
