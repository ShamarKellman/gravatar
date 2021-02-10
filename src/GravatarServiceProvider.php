<?php

namespace ShamarKellman\Gravatar;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use ShamarKellman\Gravatar\Components\GravatarImage;

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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gravatar');
        $this->app->alias(Gravatar::class, 'gravatar');

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component(GravatarImage::class, 'gravatar-image');
        });
    }
}
