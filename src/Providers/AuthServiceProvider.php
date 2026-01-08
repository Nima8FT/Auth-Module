<?php

namespace AuthModule\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! class_exists(\Tymon\JWTAuth\JWTAuth::class)) {
            return;
        }
    }

    public function boot(): void
    {
        if (! class_exists(\Tymon\JWTAuth\JWTAuth::class)) {
            return;
        }

        $this->registerAuthGuard();
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(
            __DIR__.'/../../routes/api.php'
        );
    }

    protected function registerAuthGuard(): void
    {
        if (! app()->configurationIsCached()) {
            config([
                'auth.guards.jwt' => [
                    'driver' => 'jwt',
                    'provider' => 'users',
                ],
            ]);
        }
    }
}
