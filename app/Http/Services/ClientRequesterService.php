<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class ClientRequesterService
{
    private $types = [
        'public',
        'private'
    ];

    private $headers = [];

    public function __construct()
    {
        $this->headers = [
            'user-agent' => 'PostmanRuntime/7.28.0',
            'referer' => config('app.endpoints.indodax') . '/dashboard',
        ];
    }

    public function indodax(string $uri, $type = "public")
    {
        if (!in_array($type, $this->types)) return "FUCK OFF!";

        $url = config('app.endpoints.indodax');

        return $this->executePublicRequest($url, $uri);
    }

    private function executePublicRequest(string $url, string $uri)
    {
        $client = new Client([
            'headers' => $this->headers,
            'base_uri' => "$url/api/"
        ]);

        $request = $client->get($uri);

        return $request;
    }
}