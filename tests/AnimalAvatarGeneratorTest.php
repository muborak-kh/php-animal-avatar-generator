<?php

declare(strict_types=1);

namespace AnimalAvatar\Tests;

use AnimalAvatar\AnimalAvatarGenerator;
use PHPUnit\Framework\TestCase;

final class AnimalAvatarGeneratorTest extends TestCase
{
    public function testItGeneratesDeterministicSvg(): void
    {
        $generator = new AnimalAvatarGenerator();

        $first = $generator->generate('my-seed');
        $second = $generator->generate('my-seed');
        $third = $generator->generate('my-other-seed');

        self::assertSame($first, $second);
        self::assertNotSame($first, $third);
        self::assertStringContainsString('<svg', $first);
        self::assertStringContainsString('width="150"', $first);
        self::assertStringContainsString('viewBox="0 0 500 500"', $first);
    }

    public function testItRespectsOptions(): void
    {
        $generator = new AnimalAvatarGenerator();

        $svg = $generator->generate('my-seed', [
            'size' => '75%',
            'avatarColors' => ['#ffffff'],
            'backgroundColors' => ['#000000'],
            'blackout' => false,
            'round' => false,
        ]);

        self::assertStringContainsString('width="75%"', $svg);
        self::assertStringContainsString('height="75%"', $svg);
        self::assertStringContainsString('rx="0"', $svg);
        self::assertStringContainsString('fill="#000000"', $svg);
        self::assertStringNotContainsString('fill-opacity="0.08"', $svg);
    }
}
