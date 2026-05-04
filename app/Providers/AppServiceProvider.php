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
            $testUser = User::where('email', 'asep@example.com')->first();
            $jadwalKonsultasi = $testUser ? SesiKonseling::with('profilKonselor')->where('user_id', $testUser->id)->get() : collect();
            $view->with('jadwalKonsultasi', $jadwalKonsultasi);
        });
    }
}
