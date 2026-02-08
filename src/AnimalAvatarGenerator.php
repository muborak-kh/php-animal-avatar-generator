<?php

declare(strict_types=1);

namespace AnimalAvatar;

use AnimalAvatar\Contracts\Generator as GeneratorContract;
use AnimalAvatar\Palette\Palette;
use AnimalAvatar\Shapes\ShapeRepository;
use AnimalAvatar\Support\ArrayPicker;
use AnimalAvatar\Support\SeedRandom;
use AnimalAvatar\Support\Svg;

final class AnimalAvatarGenerator implements GeneratorContract
{
    /**
     * @var array{
     *   size: int|string,
     *   avatarColors: list<string>,
     *   backgroundColors: list<string>,
     *   blackout: bool,
     *   round: bool
     * }
     */
    private array $defaults;

    /**
     * @param array<string, mixed> $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->defaults = $this->normalizeOptions($defaults);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function __invoke(string $seed, array $options = []): string
    {
        return $this->generate($seed, $options);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function generate(string $seed, array $options = []): string
    {
        $options = $this->normalizeOptions($options + $this->defaults);

        $random = SeedRandom::create($seed);
        $backgroundColor = ArrayPicker::pick($options['backgroundColors'], $random());
        $avatarColor = ArrayPicker::pick($options['avatarColors'], $random());

        $allShapes = ShapeRepository::all();
        $emptyShape = ShapeRepository::emptyShape();

        $optional = static function (array $shapes) use ($random, $emptyShape): array {
            return array_map(
                static fn (callable $shape): callable => $random() % 2 !== 0 ? $shape : $emptyShape,
                $shapes,
            );
        };

        $shapeGroups = [
            $allShapes['faces'],
            $optional($allShapes['patterns']),
            $allShapes['ears'],
            $optional($allShapes['hairs']),
            $allShapes['muzzles'],
            $allShapes['eyes'],
            $allShapes['brows'],
        ];

        $avatar = implode('', array_map(
            static function (array $group) use ($random, $avatarColor): string {
                $shape = ArrayPicker::pick($group, $random());

                return $shape($avatarColor);
            },
            $shapeGroups,
        ));

        return Svg::create(
            $options['size'],
            Svg::background($options['round'], $backgroundColor),
            $avatar,
            $options['blackout'] ? Svg::blackout($options['round']) : '',
        );
    }

    /**
     * @param array<string, mixed> $options
     * @return array{
     *   size: int|string,
     *   avatarColors: list<string>,
     *   backgroundColors: list<string>,
     *   blackout: bool,
     *   round: bool
     * }
     */
    private function normalizeOptions(array $options): array
    {
        $size = $options['size'] ?? 150;

        if (!is_int($size) && !is_string($size)) {
            throw new \InvalidArgumentException('Option "size" must be int|string.');
        }

        $avatarColors = $options['avatarColors'] ?? Palette::AVATAR_COLORS;
        $backgroundColors = $options['backgroundColors'] ?? Palette::BACKGROUND_COLORS;

        if (!is_array($avatarColors) || $avatarColors === []) {
            throw new \InvalidArgumentException('Option "avatarColors" must be a non-empty string array.');
        }

        if (!is_array($backgroundColors) || $backgroundColors === []) {
            throw new \InvalidArgumentException('Option "backgroundColors" must be a non-empty string array.');
        }

        return [
            'size' => $size,
            'avatarColors' => array_values(array_map('strval', $avatarColors)),
            'backgroundColors' => array_values(array_map('strval', $backgroundColors)),
            'blackout' => (bool) ($options['blackout'] ?? true),
            'round' => (bool) ($options['round'] ?? true),
        ];
    }
}
