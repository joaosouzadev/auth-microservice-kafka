<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;
use Illuminate\Http\Request;

class AuthService {
    use ConsumeExternalService;

    public string $baseUri;

    public function __construct() {
        $this->baseUri = config('services.microservices.auth.base_uri');
    }

    public function register(Request $request) {
        return $this->externalRequest('POST', 'register', $request);
    }

    public function login(Request $request) {
        return $this->externalRequest('POST', 'login', $request);
    }

    public function sendResetLinkEmail(Request $request) {
        return $this->externalRequest('POST', 'recover-password', $request);
    }

    public function resetPassword(Request $request) {
        return $this->externalRequest('POST', 'reset-password', $request);
    }

    public function getUser(Request $request) {
        return $this->externalRequest('GET', 'user', $request);
    }
}
