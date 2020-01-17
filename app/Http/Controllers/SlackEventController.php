<?php

namespace App\Http\Controllers;

use App\SlackEvent;
use Illuminate\Http\Request;

class SlackEventController extends Controller
{
    public function index()
    {
        $rows = SlackEvent::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('events.index', compact('rows'));
    }

    public function show(SlackEvent $slackEvent)
    {
        return view('events.show', compact('slackEvent'));
    }
}
