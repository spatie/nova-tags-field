<?php

namespace Spatie\TagsField;

use Laravel\Nova\Fields\Field;

class Tags extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-tags-field';
}
