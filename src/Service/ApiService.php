<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function fetchData($method,$url): array
    {
        $response = $this->client->request(
            $method,
            $url
        );
        dd($response->getContent());

        return $response->toArray();
    }

}