<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \Spatie\TagsField\Http\Controllers\TagsFieldController::class.'@index');
