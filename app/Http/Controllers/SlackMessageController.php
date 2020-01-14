<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SlackMessageController extends Controller
{
    private $client;

    public function __construct()
    {
        $headers = [
            'Authorization' => 'Bearer ' . env('SLACK_JWT_USER'),
            'Content-Type' => 'application/json;charset=UTF-8'
        ];

        $this->client = new Client([
            'base_uri' => 'https://slack.com/api/',
            'headers' => $headers
        ]);
    }

    public function newMessage()
    {
        return view('messages.new');
    }

    public function sendMessage(Request $request)
    {
        $response = $this->client->request('POST', 'chat.postMessage', [
            'json' => [
                'channel' => $request->input('channel'),
                'text' => $request->input('text'),
                'as_user' => true
            ]
        ]);

        dd((string) $response->getBody());
    }

    public function newCommand()
    {
        return view('commands.new');
    }

    public function sendCommand(Request $request)
    {
        $response = $this->client->request('POST', 'chat.command', [
            'json' => [
                'channel' => $request->input('channel'),
                'command' => $request->input('command'),
                'text' => $request->input('text'),
                'as_user' => true
            ]
        ]);

        dd((string) $response->getBody());
    }
}
