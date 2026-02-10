# Animal Avatar Generator for PHP

PHP-порт [`roma-lukashik/animal-avatar-generator`](https://github.com/roma-lukashik/animal-avatar-generator): детерминированная генерация SVG-аватаров животных по строковому `seed`.

## Установка

```bash
composer require animal-avatar/animal-avatar-generator
```

## Использование (чистый PHP)

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use AnimalAvatar\AnimalAvatarGenerator;

$generator = new AnimalAvatarGenerator();
$svg = $generator->generate('user-42', ['size' => 200]);

echo $svg;
```

### Helper-функция

```php
$svg = animal_avatar('user-42', ['size' => '75%']);
```

## Опции

- `size` (`int|string`) — размер аватара, по умолчанию `150`
- `round` (`bool`) — круглая или прямоугольная форма, по умолчанию `true`
- `blackout` (`bool`) — тень на правой стороне, по умолчанию `true`
- `avatarColors` (`string[]`) — палитра цветов аватара
- `backgroundColors` (`string[]`) — палитра цветов фона

## Laravel

Провайдер и фасад подключаются автоматически через package discovery.

```php
use AnimalAvatar\Laravel\Facades\AnimalAvatar;

$svg = AnimalAvatar::generate('user-42');
```

Опубликовать конфиг:

```bash
php artisan vendor:publish --tag=animal-avatar-config
```

После публикации можно менять дефолты в `config/animal-avatar.php`.

## Тесты

```bash
composer install
vendor/bin/phpunit
```

## Лицензия

MIT
