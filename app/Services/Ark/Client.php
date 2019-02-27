<?php

namespace App\Services\Ark;

use GrahamCampbell\GuzzleFactory\GuzzleFactory;

class Client
{
    private $client;

    public function __construct()
    {
        $this->client = GuzzleFactory::make([
            'base_uri' => config('ark.host'),
        ]);
    }

    public function supply(): int
    {
        return $this->get('api/v2/blockchain')['data']['supply'];
    }

    public function delegates(): array
    {
        $api_delegates = $this->get('api/delegates')['delegates'];
        $api_delegates2 = $this->get('api/delegates?offset=51')['delegates'];
        return array_merge($api_delegates, $api_delegates2);

    }

    public function get(string $path, array $query = []): array
    {
        $response = $this->client->get($path, compact('query'));

        return json_decode($response->getBody(), true);
    }
}
