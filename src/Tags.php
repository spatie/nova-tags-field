<?php

namespace Spatie\TagsField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tags extends Field
{
    public $component = 'nova-tags-field';

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $requestValue = $request[$requestAttribute];

        $tagNames = explode(',', $requestValue);

        $model->syncTags($tagNames);
    }
}
