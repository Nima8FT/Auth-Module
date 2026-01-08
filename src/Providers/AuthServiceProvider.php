<?php

namespace AuthModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (class_exists(\Tymon\JWTAuth\Providers\LaravelServiceProvider::class)) {
            $this->app->register(
                \Tymon\JWTAuth\Providers\LaravelServiceProvider::class
            );
        }

        if (function_exists('config')) {
            $this->registerAuthGuard();
        }
    }

    public function boot(): void
    {
        $routesPath = __DIR__ . '/../../routes/api.php';
        if (file_exists($routesPath)) {
            Route::middleware('api')
                ->prefix('api')
                ->group($routesPath);
        }
    }

    protected function registerAuthGuard(): void
    {
        config([
            'auth.guards.jwt' => [
                'driver' => 'jwt',
                'provider' => 'users',
            ],
        ]);
    }
}
