<?php

namespace Spatie\TagsField\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\HasTags;

class Thing extends Model
{
    use HasTags;

    protected $table = 'things';

    protected $guarded = [];

    public $timestamps = false;

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'thing_taggables', null, 'tag_id')
            ->orderBy('order_column');
    }
}
