<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckTokenRequest;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function register(CheckTokenRequest $request)
    {
        return responder()->success($request->all());
    }
}
