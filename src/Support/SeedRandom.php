<?php

declare(strict_types=1);

namespace AnimalAvatar\Support;

final class SeedRandom
{
    public static function create(string $seed): \Closure
    {
        $value = self::hash($seed);

        return static function () use (&$value): int {
            $value = self::xorshift32($value);

            return $value;
        };
    }

    private static function xorshift32(int $value): int
    {
        return self::shiftLeft(self::shiftRight(self::shiftLeft($value, 13), 17), 5);
    }

    private static function shiftLeft(int $value, int $shift): int
    {
        return self::toInt32($value ^ self::toInt32($value << $shift));
    }

    private static function shiftRight(int $value, int $shift): int
    {
        return self::toInt32($value ^ ($value >> $shift));
    }

    private static function hash(string $seed): int
    {
        $hash = 0;

        foreach (self::charCodes($seed) as $charCode) {
            $hash = self::toInt32(($hash << 5) - $hash + $charCode);
        }

        return $hash;
    }

    /**
     * JS `charCodeAt` iterates UTF-16 code units.
     *
     * @return list<int>
     */
    private static function charCodes(string $seed): array
    {
        if (function_exists('mb_convert_encoding')) {
            $utf16 = mb_convert_encoding($seed, 'UTF-16BE', 'UTF-8');
            $codes = unpack('n*', $utf16);

            if (is_array($codes)) {
                return array_values($codes);
            }
        }

        $length = strlen($seed);
        $codes = [];

        for ($index = 0; $index < $length; $index++) {
            $codes[] = ord($seed[$index]);
        }

        return $codes;
    }

    private static function toInt32(int $value): int
    {
        $value &= 0xffffffff;

        if ($value >= 0x80000000) {
            $value -= 0x100000000;
        }

        return $value;
    }
}
