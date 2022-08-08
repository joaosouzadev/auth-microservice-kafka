<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

trait ConsumeExternalService {
    public function externalRequest(string $method, string $url, Request $originalRequest): JsonResponse {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->request($method, $url, [
            'json' => $originalRequest->all(),
            'headers' => self::buildHeaders($originalRequest->header()),
            'http_errors' => false,
            //'debug' => true
        ]);

        return self::buildJsonResponse($response);
    }

    private static function buildJsonResponse(ResponseInterface $response): JsonResponse {
        return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }

    private static function buildHeaders(?array $headers = []): array {
        if (empty($headers)) {
            return [];
        }

        $h = [];
        foreach ($headers as $header => $arr) {
            foreach ($arr as $val) {
                if ($val) {
                    $h[$header] = $val;
                }
            }
        }

        return $h;
    }
}
