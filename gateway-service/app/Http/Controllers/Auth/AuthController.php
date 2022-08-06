<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse {
        return $this->authService->register($request->all());
    }

    public function login(Request $request): JsonResponse {
        return $this->authService->login($request->all());
    }

    public function sendResetLinkEmail(Request $request): JsonResponse {
        return $this->authService->login($request->all());
    }
}
