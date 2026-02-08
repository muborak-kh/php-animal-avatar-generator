<?php

declare(strict_types=1);

namespace AnimalAvatar\Support;

final class Svg
{
    public static function create(string|int $size, string ...$children): string
    {
        return "\n  <svg\n    xmlns=\"http://www.w3.org/2000/svg\"\n    version=\"1.1\"\n    width=\"{$size}\"\n    height=\"{$size}\"\n    viewBox=\"0 0 500 500\"\n  >\n    " . implode('', $children) . "\n  </svg>\n";
    }

    public static function background(bool $round, string $color): string
    {
        $radius = $round ? 250 : 0;

        return "\n  <rect\n    width=\"500\"\n    height=\"500\"\n    rx=\"{$radius}\"\n    fill=\"{$color}\"\n  />\n";
    }

    public static function blackout(bool $round): string
    {
        $path = $round ? 'M250,0a250,250 0 1,1 0,500' : 'M250,0L500,0L500,500L250,500';

        return "\n  <path\n    d=\"{$path}\"\n    fill=\"#15212a\"\n    fill-opacity=\"0.08\"\n  />\n";
    }
}
