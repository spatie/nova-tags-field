<?php

namespace Spatie\TagsField\Tests;

class ToolControllerTest extends TestCase
{
    /** @test */
    public function it_can_can_return_a_response()
    {
        $this->withoutExceptionHandling();

        $this
            ->get('nova-vendor/spatie/nova-tags-field')
            ->assertSuccessful();
    }
}
