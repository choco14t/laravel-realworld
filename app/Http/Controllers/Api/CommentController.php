<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'fetch']);
    }

    public function fetch(string $slug)
    {
    }

    public function create(string $slug)
    {
    }

    public function delete(string $slug, int $id)
    {
    }
}
