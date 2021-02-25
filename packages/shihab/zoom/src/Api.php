<?php

namespace Shihab\Zoom;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use GuzzleHttp\ClientInterface;

class Api implements ApiInterface
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct(ClientInterface $client=null)
    {
        $this->client = $client;
        $this->jwt = $this->generateToken();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->jwt,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function generateToken(): string
    {
        $key = getenv('ZOOM_API_KEY');
        $secret = getenv('ZOOM_API_SECRET');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveUrl()
    {
        return getenv('ZOOM_API_URL');
    }

    public function get(array $query = []): Response
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveUrl();
        $request = $this->request();
        return $request->get($url . $path, $query);
    }

    public function post(array $body = []): Response
    {
        $url = $this->retrieveUrl();
        $path = 'users/me/meetings';
        $request = $this->request();
        return $request->post($url . $path, $body);
    }

    public function patch(string $path, array $body = []): Response
    {
        $url = $this->retrieveUrl();
        $request = $this->request();
        return $request->patch($url . $path, $body);
    }

    public function delete(string $path, array $body = []): Response
    {
        $url = $this->retrieveUrl();
        $request = $this->request();
        return $request->delete($url . $path, $body);
    }

    public function request(): PendingRequest
    {
        return Http::withHeaders([
            'authorization' => 'Bearer ' . $this->jwt,
            'content-type' => 'application/json',
        ]);
    }
}
