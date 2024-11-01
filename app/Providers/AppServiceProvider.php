<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        Vite::prefetch(concurrency: 3);

        Inertia::share([
            'auth' => function (): array {
                return [
                    'user' => Auth::user(),
                ];
            },
            'baseUrl' => asset('storage'),
            'csrf_token' => function (): string {
                return csrf_token();
            },
        ]);
    }
}
