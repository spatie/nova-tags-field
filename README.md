# A tags field for Nova apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/nova-tags-field.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tags-field)
[![Build Status](https://img.shields.io/travis/spatie/nova-tags-field/master.svg?style=flat-square)](https://travis-ci.org/spatie/nova-tags-field)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/nova-tags-field.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/nova-tags-field)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/nova-tags-field.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tags-field)

This package contains a Nova field to add tags to resources. Under the hood it uses the [spatie/laravel-tags](https://docs.spatie.be/laravel-tags) package.




## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require spatie/nova-tags-field
```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \Spatie\TagsField\Tool(),
    ];
}
```

## Usage

Click on the "nova-tags-field" menu item in your Nova app to see the tool provided by this package.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
