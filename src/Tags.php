<?php

namespace Spatie\TagsField;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Tags\Tag;

class Tags extends Field
{
    public $component = 'nova-tags-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->multiple();
    }

    public function type(string $type)
    {
        return $this->withMeta(['type' => $type]);
    }

    public function withLinkToTagResource(string $tagResource = null, string $class = 'no-underline dim text-primary font-bold')
    {
        if (is_null($tagResource)) {
            $tagResource = 'App\Nova\Tag';
        }

        $uriKey = $tagResource::uriKey();

        return $this->displayUsing(function ($value, $resource, $attribute) use ($class, $uriKey) {
            $tags = data_get($resource, $attribute);

            return $tags->map(function (Tag $tag) use ($class, $uriKey) {
                $href = rtrim(Nova::path(), '/').'/resources/'.$uriKey.'/'.$tag->id;

                return "<a href=\"$href\" class=\"$class\">$tag->name</a>";
            });
        });
    }

    public function multiple(bool $multiple = true)
    {
        $this->withMeta([
            'multiple' => $multiple,
            'suggestionLimit' => 5,
        ]);

        if (! $this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function single(bool $single = true)
    {
        $this->withMeta(['multiple' => ! $single]);

        if (! $this->meta['multiple']) {
            $this->doNotLimitSuggestions();
        }

        return $this;
    }

    public function withoutSuggestions()
    {
        return $this->limitSuggestions(0);
    }

    public function limitSuggestions(int $maxNumberOfSuggestions)
    {
        return $this->withMeta(['suggestionLimit' => $maxNumberOfSuggestions]);
    }

    public function doNotLimitSuggestions()
    {
        return $this->limitSuggestions(9999);
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

        if (Arr::has($this->meta(), 'type')) {
            $tags = $tags->where('type', $this->meta()['type']);
        }

        return $tags->map(function (Tag $tag) {
            return e($tag->name);
        })->values();
    }
}
