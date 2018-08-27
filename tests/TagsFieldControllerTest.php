<?php

namespace Spatie\TagsField\Tests;

use Spatie\Tags\Tag;

class TagsFieldControllerTest extends TestCase
{
    /** @test */
    public function it_can_find_tags_containing_a_given_string()
    {
        Tag::findOrCreateFromString('one');
        Tag::findOrCreateFromString('another-one');
        Tag::findOrCreateFromString('Another-ONE-with-different-casing');
        Tag::findOrCreateFromString('two');

        $this
            ->getJson('nova-vendor/spatie/nova-tags-field?filter[containing]=on')
            ->assertSuccessful()
            ->assertJsonCount(3)
            ->assertDontSee('two');
    }

    /** @test */
    public function the_containing_filter_is_required()
    {
        $this
            ->getJson('nova-vendor/spatie/nova-tags-field')
            ->assertJsonValidationErrors('filter.containing');
    }


}
