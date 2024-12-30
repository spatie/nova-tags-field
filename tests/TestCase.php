<?php

namespace Spatie\TagsField\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\Database\Seeders\DatabaseSeeder;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    /** {@inheritDoc} */
    protected function shouldSeed()
    {
        return true;
    }

    /** {@inheritDoc} */
    protected function seeder()
    {
        return DatabaseSeeder::class;
    }
}
