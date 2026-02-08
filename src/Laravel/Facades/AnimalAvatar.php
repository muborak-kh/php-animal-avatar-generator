<?php

declare(strict_types=1);

namespace AnimalAvatar\Laravel\Facades;

use AnimalAvatar\Contracts\Generator as GeneratorContract;
use Illuminate\Support\Facades\Facade;

final class AnimalAvatar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GeneratorContract::class;
    }
}
