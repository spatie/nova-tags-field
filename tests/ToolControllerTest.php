<?php

namespace Spatie\TagsField\Tests;

use Spatie\TagsField\Http\Controllers\TagsFieldController;
use Spatie\TagsField\TagsField;
use Symfony\Component\HttpFoundation\Response;

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
