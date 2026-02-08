<?php

declare(strict_types=1);

namespace AnimalAvatar\Shapes;

use AnimalAvatar\Support\Colors;

final class ShapeRepository
{
    /**
     * @return array<string, list<callable(string): string>>
     */
    public static function all(): array
    {
        static $cache = null;

        if (is_array($cache)) {
            return $cache;
        }

        $cache = [];

        foreach (Templates::all() as $name => $templates) {
            $cache[$name] = array_map(
                static fn (string $template): callable => static fn (string $color): string => self::renderTemplate($template, $color),
                $templates,
            );
        }

        return $cache;
    }

    public static function emptyShape(): callable
    {
        return static fn (string $color): string => '';
    }

    private static function renderTemplate(string $template, string $color): string
    {
        $rendered = preg_replace_callback(
            '/\$\{darken\(\s*color\s*,\s*(-?\d+)\s*,?\s*\)\}/s',
            static fn (array $matches): string => Colors::darken($color, (int) $matches[1]),
            $template,
        );

        if (!is_string($rendered)) {
            throw new \RuntimeException('Cannot render SVG template.');
        }

        return str_replace('${color}', $color, $rendered);
    }
}
