<?php

namespace :namespace_vendor\:namespace_tool_name\Http\Controllers;

use Illuminate\Http\Request;
use :namespace_vendor\:namespace_tool_name\File;
use Illuminate\Routing\Controller;

class ToolController extends Controller
{
    public function index()
    {
        return 'Hello world!';
    }
}
