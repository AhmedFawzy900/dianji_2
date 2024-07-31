<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestApiController extends Controller
{

    public function index()
    {
        return response()->json(['message' => 'Hello World!'], 200);
    }
}
