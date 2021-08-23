<?php

namespace Spatie\TagsField\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Nova\Nova;
use Spatie\Tags\Tag;

class TagsFieldController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $tagModel = null;

        if ($request->has('resourceName')) {
            $resourceClass = Nova::resourceForKey($request['resourceName']);

            if ($resourceClass) {
                $modelClass = $resourceClass::$model;

                if (method_exists($modelClass, 'getTagClassName')) {
                    $tagModel = $modelClass::getTagClassName();
                }
            }
        }

        if (!$tagModel) {
            $tagModel = config('tags.tag_model', Tag::class);
        }

        $query = resolve($tagModel)->query();

        if ($request->has('filter.containing')) {
            $query->containing($request['filter']['containing']);
        }

        if ($request->has('filter.type')) {
            $query->where('type', $request['filter']['type']);
        }

        if ($request->has('limit')) {
            $query->limit($request['limit']);
        }

        $sorted = $query->get()->sortBy(function (Tag $tag) {
            return strtolower($tag->name);
        })->values();

        return $sorted->map(function (Tag $tag) {
            return $tag->name;
        });
    }
}
