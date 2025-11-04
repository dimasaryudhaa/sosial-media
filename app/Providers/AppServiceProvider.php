<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        Model::unguard();
    }

     public function boot(): void
     {
         View::composer('*', function ($view) {
             if (Auth::check()) {
                 $unreadCount = Notification::where('user_id', Auth::id())
                     ->where('is_read', false)
                     ->count();
                 $view->with('unreadCount', $unreadCount);
             }
         });
     }
}
