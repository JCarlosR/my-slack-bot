<?php

namespace App\Http\Controllers;

use App\SlackEvent;
use Illuminate\Http\Request;

class SlackEventController extends Controller
{
    public function index(Request $request)
    {
        $query = SlackEvent::orderBy('created_at', 'desc');

        if ($eventSubType = $request->input('event_subtype', null)) {
            $query->where('event_subtype', $eventSubType);
        }

        if ($channel = $request->input('event_channel', null)) {
            $query->where('event_channel', $channel);
        }

        $jsonStructure = $request->input('json_structure', null);
        if ($jsonStructure === 'event_attachment') {
            $query->whereNotNull('attachment_fallback');
        } elseif ($jsonStructure === 'event_message') {
            $query->whereNotNull('event_message_type');
        }

        $rows = $query->paginate(10);

        return view('events.index', compact('rows', 'eventSubType', 'channel', 'jsonStructure'));
    }

    public function show(SlackEvent $slackEvent)
    {
        return view('events.show', compact('slackEvent'));
    }
}
