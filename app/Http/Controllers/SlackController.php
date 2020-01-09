<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SlackController extends Controller
{
    public function action(Request $request)
    {
        return $request->input('challenge');
    }
}
