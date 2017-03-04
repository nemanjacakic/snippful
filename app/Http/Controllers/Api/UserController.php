<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        return $this->respondWith($request->user(), new UserTransformer);
    }
}
