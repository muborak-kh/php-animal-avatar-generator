<?php

declare(strict_types=1);

namespace AnimalAvatar\Tests;

use AnimalAvatar\Support\SeedRandom;
use PHPUnit\Framework\TestCase;

final class SeedRandomTest extends TestCase
{
    public function testItReturnsExpectedSequenceForSeed(): void
    {
        $random = SeedRandom::create('seed');

        self::assertSame(-2038275316, $random());
        self::assertSame(-1768109603, $random());
        self::assertSame(-78991410, $random());
    }

    public function testItReturnsExpectedSequenceForTest(): void
    {
        $random = SeedRandom::create('test');

        self::assertSame(-601360192, $random());
        self::assertSame(1153614527, $random());
        self::assertSame(-1909411243, $random());
    }
}
