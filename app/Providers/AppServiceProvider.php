<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Démarre les services de l'application.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Inertia::share([
            'auth' => function () {
                return [
                    'user' => Auth::user(),
                ];
            },
            'baseUrl' => asset('storage'),
            'csrf_token' => function () {
                return csrf_token();
            },
        ]);
    }
}
