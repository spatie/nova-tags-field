<?php

namespace Spatie\TagsField\Tests\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Resource;
use Spatie\Tags\HasTags;

class Thing extends Resource
{
    public static $model = \Spatie\TagsField\Tests\Models\Thing::class;

    public function fields(Request $request): array
    {
        return [];
    }
}
