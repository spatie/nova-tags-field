<?php

namespace Spatie\TagsField\Tests;

use PHPUnit\Framework\Attributes\Test;
use Spatie\TagsField\Tags;
use Spatie\Tags\Tag;
use Workbench\App\Models\User;
use Workbench\App\Nova\Tag as TagResource;
use Workbench\Database\Factories\UserFactory;

class TagsFieldControllerTest extends TestCase
{
    #[Test]
    public function it_can_find_tags_containing_a_given_string()
    {
        $this
            ->actingAs(User::find(1))
            ->getJson('nova-vendor/spatie/nova-tags-field?filter[containing]=on')
            ->assertSuccessful()
            ->assertJsonCount(3)
            ->assertDontSee('two');
    }

    #[Test]
    public function it_can_limit_the_suggestions()
    {
        $this
            ->actingAs(User::find(1))
            ->getJson('nova-vendor/spatie/nova-tags-field?limit=2')
            ->assertSuccessful()
            ->assertJsonCount(2);
    }

    #[Test]
    public function limiting_on_zero_returns_no_tags()
    {
        $this
            ->actingAs(User::find(1))
            ->getJson('nova-vendor/spatie/nova-tags-field?limit=0')
            ->assertSuccessful()
            ->assertJsonCount(0);
    }

    #[Test]
    public function the_display_callback_is_valid()
    {
        $tags = Tag::all()->take(1);

        $resource = UserFactory::new()->create([
            'tags' => ['one'],
        ])->load('tags');

        $tagField = Tags::make('Tag');
        $this->assertNull($tagField->displayCallback);

        $tagField = Tags::make('Tag')->withLinkToTagResource(TagResource::class);
        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('<a href="/nova/resources/tags/1" class="no-underline dim text-primary font-bold">one</a>', call_user_func($tagField->displayCallback, $tags->toArray(), $resource, 'tags')->first());

        $tagField = Tags::make('Tag')->withLinkToTagResource(TagResource::class, 'custom-class');
        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('<a href="/nova/resources/tags/1" class="custom-class">one</a>', call_user_func($tagField->displayCallback, $tags->toArray(), $resource, 'tags')->first());

        $tagField = Tags::make('Tag')->displayUsing(function ($tags) {
            return $tags->map(function (Tag $tag) {
                return $tag->name;
            })->join(', ');
        });

        $this->assertIsCallable($tagField->displayCallback);
        $this->assertEquals('one', call_user_func($tagField->displayCallback, $tags));

        $this->expectException(\Error::class);
        Tags::make('Tag')->withLinkToTagResource();
    }
}
