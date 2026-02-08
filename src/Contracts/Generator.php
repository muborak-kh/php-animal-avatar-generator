<?php

declare(strict_types=1);

namespace AnimalAvatar\Contracts;

interface Generator
{
    /**
     * @param array<string, mixed> $options
     */
    public function generate(string $seed, array $options = []): string;
}
