<?php

namespace Spatie\TagsField\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $query = Tag::query();

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
