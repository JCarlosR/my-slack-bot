<?php namespace App\Slack;


use GuzzleHttp\Client;

class ApiClient
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

    public function postMessage(string $channel, string $text)
    {
        return $this->client->request('POST', 'chat.postMessage', [
            'json' => [
                'channel' => $channel,
                'text' => $text,
                'as_user' => true
            ]
        ]);
    }

    public function postCommand(string $channel, string $command, string $text)
    {
        return $this->client->request('POST', 'chat.command', [
            'json' => [
                'channel' => $channel,
                'command' => $command,
                'text' => $text,
                'as_user' => true
            ]
        ]);
    }
}