# gravatar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/shamarkellman/gravatar.svg?style=flat-square)](https://packagist.org/packages/shamarkellman/gravatar)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/shamarkellman/gravatar/run-tests?label=tests)](https://github.com/shamarkellman/gravatar/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/shamarkellman/gravatar.svg?style=flat-square)](https://packagist.org/packages/shamarkellman/gravatar)


This package is used to generate a gravatar url for Laravel 8 applications.

## Installation

You can install the package via composer:

```bash
composer require shamarkellman/gravatar
```

You can publish and run the migrations with:

You can publish the config file with:
```bash
php artisan vendor:publish --provider="ShamarKellman\Gravatar\GravatarServiceProvider" --tag="gravatar-config"
```

This is the contents of the published config file:

```php
return [
    'size' => 80,
    'max_rating' => 'g',
    'default_image' => 'mp',
    'always_force_default_image' => false,
];
```

## Usage

```php
$gravatar = new ShamarKellman\Gravatar();
echo $gravatar->buildGravatarURL();
```
or use the Facade
```php
use ShamarKellman\Gravatar\Facades\Gravatar;

Gravatar::buildGravatarURL();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Shamar Kellman](https://github.com/ShamarKellman)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
