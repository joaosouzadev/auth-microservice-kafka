<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;

trait ConsumeExternalService {
    public function externalRequest(string $method, string $url, ?array $params = [], ?array $headers = []): JsonResponse {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->request($method, $url, [
            'form_params' => $params,
            'headers' => $headers,
            'http_errors' => false
        ]);

        return self::buildJsonResponse($response);
    }

    private static function buildJsonResponse(ResponseInterface $response): JsonResponse {
        return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }
}
