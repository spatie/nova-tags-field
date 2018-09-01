<?php

namespace Spatie\TagsField;

use Spatie\Tags\Tag;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tags extends Field
{
    public $component = 'nova-tags-field';

    public function type(string $type)
    {
        return $this->withMeta(['type' => $type]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $requestValue = $request[$requestAttribute];
        $tagNames = explode('-----', $requestValue);
        $tagNames = array_filter($tagNames);

        $class = get_class($model);

        $class::saved(function ($model) use ($tagNames) {
            $model->syncTagsWithType($tagNames, $this->meta()['type'] ?? null);
        });
    }

    public function resolveAttribute($resource, $attribute = null)
    {
        $tags = $resource->tags;

        if (array_has($this->meta(), 'type')) {
            $tags = $tags->where('type', $this->meta()['type']);
        }

        return $tags->map(function (Tag $tag) {
            return ['id' => $tag->id, 'name' => $tag->name];
        })->values();
    }
}
