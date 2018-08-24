<?php

namespace Spatie\TagsField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag;

class Tags extends Field
{
    public $component = 'nova-tags-field';

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $requestValue = $request[$requestAttribute];

        $tagNames = explode(',', $requestValue);

        $model->syncTags($tagNames);
    }

    public function resolveAttribute($resource, $attribute = null)
    {
        return $resource->tags->map(function(Tag $tag) {
            return ['id' => $tag->id, 'name' => $tag->name];
        });
    }
}
