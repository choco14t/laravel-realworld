<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function fetch()
    {
    }
}
