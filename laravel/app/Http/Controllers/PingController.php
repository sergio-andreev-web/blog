<?php

namespace App\Http\Controllers;


class PingController extends Controller
{
    public function ping()
    {
        return response()->json(['message' => 'pong'], 200);
    }
}
