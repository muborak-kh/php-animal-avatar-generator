<?php

declare(strict_types=1);

namespace AnimalAvatar\Laravel;

use AnimalAvatar\AnimalAvatarGenerator;
use AnimalAvatar\Contracts\Generator as GeneratorContract;
use Illuminate\Support\ServiceProvider;

final class AnimalAvatarServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/animal-avatar.php', 'animal-avatar');

        $this->app->singleton(GeneratorContract::class, function ($app): AnimalAvatarGenerator {
            /** @var array<string, mixed> $defaults */
            $defaults = $app['config']->get('animal-avatar', []);

            return new AnimalAvatarGenerator($defaults);
        });

        $this->app->alias(GeneratorContract::class, AnimalAvatarGenerator::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/animal-avatar.php' => config_path('animal-avatar.php'),
        ], 'animal-avatar-config');
    }
}
