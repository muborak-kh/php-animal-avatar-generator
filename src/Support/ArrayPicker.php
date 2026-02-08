<?php

declare(strict_types=1);

namespace AnimalAvatar\Support;

final class ArrayPicker
{
    private const MIN = -2147483648;
    private const MAX = 2147483647;

    /**
     * @template T
     * @param list<T> $items
     * @return T
     */
    public static function pick(array $items, int $index)
    {
        if ($items === []) {
            throw new \InvalidArgumentException('Cannot pick from an empty array.');
        }

        $normalized = self::integer($index, 0, count($items) - 1);

        return $items[$normalized];
    }

    private static function integer(int $value, int $min, int $max): int
    {
        return (int) floor(((($value - self::MIN) / (self::MAX - self::MIN)) * ($max + 1 - $min)) + $min);
    }
}
