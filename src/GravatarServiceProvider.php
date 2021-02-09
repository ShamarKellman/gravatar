<?php

namespace ShamarKellman\Gravatar;

use Illuminate\Support\ServiceProvider;

class GravatarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gravatar.php' => config_path('gravatar.php'),
            ], 'gravatar-config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gravatar.php', 'gravatar');
        $this->app->alias(Gravatar::class, 'gravatar');
    }
}
