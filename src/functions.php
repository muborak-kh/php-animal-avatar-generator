<?php

declare(strict_types=1);

use AnimalAvatar\AnimalAvatarGenerator;

if (!function_exists('animal_avatar')) {
    /**
     * @param array<string, mixed> $options
     */
    function animal_avatar(string $seed, array $options = []): string
    {
        static $generator = null;

        if (!$generator instanceof AnimalAvatarGenerator) {
            $generator = new AnimalAvatarGenerator();
        }

        return $generator->generate($seed, $options);
    }
}
