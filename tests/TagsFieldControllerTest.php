<?php

namespace Spatie\TagsField\Tests;

use PHPUnit\Framework\Attributes\Test;
use Spatie\Tags\Tag;
use Spatie\TagsField\Tags;
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
    public function updating_tags_does_not_change_other_users_tags()
    {
        $user = User::find(1);
        $otherUser = UserFactory::new()->create(['tags' => ['other']]);

        $this->actingAs($user)
            ->putJson("nova-api/users/{$user->id}", [
                'name' => $user->name,
                'email' => $user->email,
                'tags' => 'one-----two',
            ])
            ->assertSuccessful();

        $this->assertEquals(['one', 'two'], $user->fresh()->tags->pluck('name')->all());

        $otherUser->update(['name' => 'Updated name']);

        $this->assertEquals(['other'], $otherUser->fresh()->tags->pluck('name')->all());
    }

    #[Test]
    public function it_preserves_zero_as_a_tag_name()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->putJson("nova-api/users/{$user->id}", [
                'name' => $user->name,
                'email' => $user->email,
                'tags' => '0-----one',
            ])
            ->assertSuccessful();

        $this->assertEqualsCanonicalizing(['0', 'one'], $user->fresh()->tags->pluck('name')->all());
    }

    #[Test]
    public function it_only_clears_tags_when_the_field_is_submitted()
    {
        $user = UserFactory::new()->create(['tags' => ['one']]);

        $this->actingAs($user)
            ->putJson("nova-api/users/{$user->id}", [
                'name' => $user->name,
                'email' => $user->email,
            ])
            ->assertSuccessful();

        $this->assertEquals(['one'], $user->fresh()->tags->pluck('name')->all());

        $this->putJson("nova-api/users/{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
            'tags' => '',
        ])->assertSuccessful();

        $this->assertCount(0, $user->fresh()->tags);
    }

    #[Test]
    public function it_can_save_tags_when_creating_a_user()
    {
        $this->actingAs(User::find(1))
            ->postJson('nova-api/users', [
                'name' => 'New user',
                'email' => 'new@example.com',
                'password' => 'secret-password',
                'tags' => 'one-----new',
            ])
            ->assertSuccessful();

        $user = User::where('email', 'new@example.com')->firstOrFail();

        $this->assertEquals(['one', 'new'], $user->tags->pluck('name')->all());
    }

    #[Test]
    public function tag_resource_links_escape_tag_names_and_attributes()
    {
        $user = UserFactory::new()->create(['tags' => ['<b>Tag & name</b>']]);
        $tag = $user->tags->first();
        $field = Tags::make('Tags')->withLinkToTagResource(TagResource::class, 'custom"class');

        $field->resolveForDisplay($user);

        $this->assertEquals(
            '<a href="/nova/resources/tags/'.$tag->id.'" class="custom&quot;class">&lt;b&gt;Tag &amp; name&lt;/b&gt;</a>',
            $field->jsonSerialize()['displayedAs']->first(),
        );
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
