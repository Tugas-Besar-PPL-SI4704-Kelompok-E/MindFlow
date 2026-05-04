<?php

namespace App\Providers;

use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $userId = \Illuminate\Support\Facades\Auth::id();
            $jadwalKonsultasi = $userId ? SesiKonseling::with('profilKonselor')
                ->where('user_id', $userId)
                ->where('status', '!=', 'cancelled')
                ->get() : collect();
            $view->with('jadwalKonsultasi', $jadwalKonsultasi);
        });
    }
}
