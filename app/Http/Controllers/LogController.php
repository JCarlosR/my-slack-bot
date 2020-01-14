<?php

namespace App\Http\Controllers;

use App\HttpRequest;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $requests = HttpRequest::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('logs.index', compact('requests'));
    }
}
