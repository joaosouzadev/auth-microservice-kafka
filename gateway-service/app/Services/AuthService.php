<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class AuthService {
    use ConsumeExternalService;

    public string $baseUri;

    public function __construct() {
        $this->baseUri = config('services.microservices.auth.base_uri');
    }

    public function register($data) {
        return $this->externalRequest('POST', 'register', $data);
    }

    public function login($data) {
        return $this->externalRequest('POST', 'login', $data);
    }

    public function sendResetLinkEmail($data) {
        return $this->externalRequest('POST', 'recover-password', $data);
    }
}
