<?php

namespace Spatie\TagsField\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Tags\TagsServiceProvider;
use Spatie\TagsField\TagsFieldServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            TagsServiceProvider::class,
            TagsFieldServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->artisan('migrate:fresh');

        include_once __DIR__.'/../vendor/spatie/laravel-tags/database/migrations/create_tag_tables.php.stub';

        (new \CreateTagTables())->up();

        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });

        $app['db']->connection()->getSchemaBuilder()->create('things', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });

        $app['db']->connection()->getSchemaBuilder()->create('thing_tags', function (Blueprint $table) {
            $table->id();

            $table->json('name');
            $table->json('slug');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();

            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('thing_taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained('thing_tags')->cascadeOnDelete();

            $table->morphs('taggable');

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });
    }
}
