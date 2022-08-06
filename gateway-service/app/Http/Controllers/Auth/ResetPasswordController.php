<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller {
    public $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function sendResetLinkEmail(Request $request): JsonResponse {
        return $this->authService->sendResetLinkEmail($request->all());
    }
}
