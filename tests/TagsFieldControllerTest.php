<?php

namespace Spatie\TagsField\Tests;

use Spatie\Tags\Tag;

class TagsFieldControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->createTags();
    }

    /** @test */
    public function it_can_find_tags_containing_a_given_string()
    {
        $this
            ->getJson('nova-vendor/spatie/nova-tags-field?filter[containing]=on')
            ->assertSuccessful()
            ->assertJsonCount(3)
            ->assertDontSee('two');
    }

    /** @test */
    public function it_can_limit_the_suggestions()
    {
        $this
            ->getJson('nova-vendor/spatie/nova-tags-field?limit=2')
            ->assertSuccessful()
            ->assertJsonCount(2);
    }

    /** @test */
    public function limiting_on_zero_returns_no_tags()
    {
        $this
            ->getJson('nova-vendor/spatie/nova-tags-field?limit=0')
            ->assertSuccessful()
            ->assertJsonCount(0);
    }

    protected function createTags()
    {
        Tag::findOrCreateFromString('one');
        Tag::findOrCreateFromString('another-one');
        Tag::findOrCreateFromString('Another-ONE-with-different-casing');
        Tag::findOrCreateFromString('two');
    }
}
