<?php

namespace Spatie\TagsField\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class TestModel extends Model
{
    use HasTags;

    public $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;
}
