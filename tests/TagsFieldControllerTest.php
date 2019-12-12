<?php

namespace Spatie\TagsField\Tests;

use Laravel\Nova\Resource;
use Spatie\Tags\Tag;
use Spatie\TagsField\Tags;

class TagsFieldControllerTest extends TestCase
{
    /** @var TestModel */
    protected $testModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->createTags();

        $this->testModel = TestModel::create([
            'name' => 'model1',
            'tags' => ['one'],
        ]);
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

    /** @test */
    public function the_display_callback_is_valid()
    {
        $tags = Tag::all()->take(1);

        $resource = $this->testModel->load('tags');

        $tagField = Tags::make('Tag');
        $this->assertNull($tagField->displayCallback);

        $tagField = Tags::make('Tag')->withLinkToTagResource(TagResource::class);
        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('<a href="/nova/resources/tag-resources/1" class="no-underline dim text-primary font-bold">one</a>', call_user_func($tagField->displayCallback, $tags->toArray(), $resource, 'tags')->first());

        $tagField = Tags::make('Tag')->withLinkToTagResource(TagResource::class, 'custom-class');
        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('<a href="/nova/resources/tag-resources/1" class="custom-class">one</a>', call_user_func($tagField->displayCallback, $tags->toArray(), $resource, 'tags')->first());

        $tagField = Tags::make('Tag')->displayUsing(function ($tags) {
            return $tags->map(function (Tag $tag) {
                return $tag->name;
            })->join(', ');
        });

        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('one', call_user_func($tagField->displayCallback, $tags));

        $this->expectExceptionMessage('Class \'App\Nova\Tag\' not found');
        Tags::make('Tag')->withLinkToTagResource();
    }

    protected function createTags()
    {
        Tag::findOrCreateFromString('one');
        Tag::findOrCreateFromString('another-one');
        Tag::findOrCreateFromString('Another-ONE-with-different-casing');
        Tag::findOrCreateFromString('two');
    }
}

abstract class TagResource extends Resource
{
}
