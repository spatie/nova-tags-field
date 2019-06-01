# A tags field for Nova apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/nova-tags-field.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tags-field)
![CircleCI branch](https://img.shields.io/circleci/project/github/spatie/nova-tags-field/master.svg?style=flat-square)
[![StyleCI](https://github.styleci.io/repos/145974148/shield?branch=master)](https://github.styleci.io/repos/145974148)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/nova-tags-field.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tags-field)

This package contains a Nova field to add tags to resources. Under the hood it uses the [spatie/laravel-tags](https://docs.spatie.be/laravel-tags) package.

![screenshot of the tags field](https://spatie.github.io/nova-tags-field/screenshot.png)

## Requirements

This Nova field requires MySQL 5.7.8 or higher.

## Installation

First you must install [spatie/laravel-tags](https://github.com/spatie/laravel-tags) into your Laravel app. Here are [the installation instructions](https://docs.spatie.be/laravel-tags/v2/installation-and-setup) for that package.

Next, you can install this package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require spatie/nova-tags-field
```

## Usage

To make an Eloquent model taggable just add the `\Spatie\Tags\HasTags` trait to it:

```php
class BlogPost extends \Illuminate\Database\Eloquent\Model
{
    use \Spatie\Tags\HasTags;
    
    ...
}
```

Next you can use the `Spatie\TagsField\Tags` field in your Nova resource:

```php
namespace App\Nova;

use Spatie\TagsField\Tags;

class BlogPost extends Resource
{
    // ...
    
    public function fields(Request $request)
    {
        return [
            // ...
            
            Tags::make('Tags'),

            // ...
        ];
    }
}
```

Now you can view and add tags on the blog posts screen in your Nova app. All tags will be saved in the `tags` table. 

## Limiting suggestions

By default a tags field will display a maximum of 5 suggestions when typing into it. If you don't want to display any suggestions, tag on `withoutSuggestions()`.

```php
Tags::make('Tags')->withoutSuggestions(),
```

You can change the number of suggestions with `limitSuggestions()`.

```php
Tags::make('Tags')->limitSuggestions($maxNumberOfSuggestions),
```

## Using types

The [underlying tags package](https://github.com/spatie/laravel-tags) has support for [tag types](https://docs.spatie.be/laravel-tags/v2/advanced-usage/using-types). To make your tags field save tags of a certain type just tack on the name of type when adding the field to your Nova resource.

```php
// in your Nova resource

public function fields(Request $request)
{
    return [
        // ...
        
        Tags::make('Tags')->type('my-special-type'),

        // ...
    ];
}
```

## Allowing only one tag

If the user is only allowed to select one tag for your resource you can call the `single` method.

```php
// in your Nova resource

public function fields(Request $request)
{
    return [
        // ...
        
        Tags::make('Tags')->single(),

        // ...
    ];
}
```

The field will be rendered as a select form element. It will be populated by the names of the tags already saved.

## Working with tags

For more info on how to work with the saved tags, head over to [the docs of spatie/laravel-tags](https://docs.spatie.be/laravel-tags/).

## Administering tags in Nova

If you want to perform crud actions on the save tags, just create a Nova resource for it. Here's an example.

```php
namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Spatie\Tags\Tag as TagModel;

class Tag extends Resource
{
    public static $model = TagModel::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Name')->sortable(),
        ];
    }
}
```

### Show tags with a link to a Nova resource

When creating the field, you can use the `withLinkToTagResource` method.  
Example:
```php
Tags::make('Tags')->withLinkToTagResource() // The resource App\Nova\Tag will be used
Tags::make('Tags')->withLinkToTagResource(\Custom\CustomTag::class) // The resource \Custom\CustomTag will be used
```

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

The Vue components that render the tags are based upon the tag Vue components created by [Adam Wathan](https://twitter.com/adamwathan) as shown in [his excellent Advanced Vue Component Design course](https://adamwathan.me/advanced-vue-component-design/).

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
