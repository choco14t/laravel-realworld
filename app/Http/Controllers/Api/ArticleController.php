<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['fetchList', 'fetch']]);
    }

    public function fetchList()
    {
    }

    public function fetch(string $slug)
    {
    }

    public function create()
    {
    }

    public function update(string $slug)
    {
    }

    public function delete(string $slug)
    {
    }
}
