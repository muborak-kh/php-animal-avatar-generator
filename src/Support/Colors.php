<?php

declare(strict_types=1);

namespace AnimalAvatar\Support;

final class Colors
{
    public static function darken(string $hex, int $amount): string
    {
        $rgb = self::hexToRgb($hex);

        $darkened = array_map(
            static fn (int $value): int => self::clamp($value - $amount, 0, 255),
            $rgb,
        );

        return self::rgbToHex($darkened);
    }

    /**
     * @return array{0:int,1:int,2:int}
     */
    private static function hexToRgb(string $hex): array
    {
        $normalized = preg_replace('/^#?([a-f\d])([a-f\d])([a-f\d])$/i', '#$1$1$2$2$3$3', $hex);

        if ($normalized === null) {
            throw new \InvalidArgumentException('Invalid hex color.');
        }

        $normalized = ltrim($normalized, '#');

        if (strlen($normalized) !== 6 || !ctype_xdigit($normalized)) {
            throw new \InvalidArgumentException('Invalid hex color.');
        }

        $parts = str_split($normalized, 2);

        return [
            hexdec($parts[0]),
            hexdec($parts[1]),
            hexdec($parts[2]),
        ];
    }

    /**
     * @param array<int, int> $rgb
     */
    private static function rgbToHex(array $rgb): string
    {
        return '#' . implode('', array_map(static fn (int $value): string => str_pad(dechex($value), 2, '0', STR_PAD_LEFT), $rgb));
    }

    private static function clamp(int $value, int $min, int $max): int
    {
        return min($max, max($min, $value));
    }
}
