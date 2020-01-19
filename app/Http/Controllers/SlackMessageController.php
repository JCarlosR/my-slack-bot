<?php

namespace App\Http\Controllers;

use App\Slack\ApiClient;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SlackMessageController extends Controller
{
    private $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function newMessage()
    {
        return view('messages.new');
    }

    public function sendMessage(Request $request)
    {
        $response = $this->apiClient->postMessage(
            $request->input('channel'),
            $request->input('text')
        );

        $status = (string) $response->getBody();
        return back()->with(compact('status'));
    }

    public function newCommand()
    {
        return view('commands.new');
    }

    public function sendCommand(Request $request)
    {
        $response = $this->apiClient->postCommand(
            $request->input('channel'),
            $request->input('command'),
            $request->input('text')
        );

        $status = (string) $response->getBody();
        return back()->with(compact('status'));
    }
}
