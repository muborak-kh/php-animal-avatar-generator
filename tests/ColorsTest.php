<?php

declare(strict_types=1);

namespace AnimalAvatar\Tests;

use AnimalAvatar\Support\Colors;
use PHPUnit\Framework\TestCase;

final class ColorsTest extends TestCase
{
    public function testDarkenReturnsExpectedColors(): void
    {
        self::assertSame('#000000', Colors::darken('#000', 20));
        self::assertSame('#ebebeb', Colors::darken('#fff', 20));
        self::assertSame('#dddddd', Colors::darken('#f1f1f1', 20));
    }

    public function testDarkenWorksForShortAndLongHex(): void
    {
        self::assertSame('#ebda1f', Colors::darken('#fe3', 20));
        self::assertSame('#ebda1f', Colors::darken('#ffee33', 20));
    }
}
