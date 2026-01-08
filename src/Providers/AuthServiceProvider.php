<?php

namespace AuthModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register bindings and merge configs.
     */
    public function register(): void
    {
        if (! class_exists(\Tymon\JWTAuth\JWTAuth::class)) {
            return;
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth-module.php',
            'auth-module'
        );
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        if (! class_exists(\Tymon\JWTAuth\JWTAuth::class)) {
            return;
        }

        if ($this->app->bound('auth')) {
            Auth::extend('jwt', function ($app, $name, array $config) {
                return $app['tymon.jwt.auth'];
            });
        }

        $this->loadRoutesFrom(
            __DIR__ . '/../../routes/api.php'
        );
    }
}
