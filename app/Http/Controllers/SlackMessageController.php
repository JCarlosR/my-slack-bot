<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SlackMessageController extends Controller
{
    public function newMessage()
    {
        return view('messages.new');
    }

    public function sendMessage(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer ' . env('SLACK_JWT_USER'),
            'Content-Type' => 'application/json;charset=UTF-8'
        ];

        $client = new Client([
            'base_uri' => 'https://slack.com/api/',
            'headers' => $headers
        ]);

        $response = $client->request('POST', 'chat.postMessage', [
            'json' => [
                'channel' => $request->input('channel'),
                'text' => $request->input('text'),
                'as_user' => true
            ]
        ]);

        dd((string) $response->getBody());
    }
}
