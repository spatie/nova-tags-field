<?php

namespace Spatie\TagsField\Http\Controllers;

use Spatie\Tags\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

        return $query->get()->map(function (Tag $tag) {
            return $tag->name;
        });
    }
}
