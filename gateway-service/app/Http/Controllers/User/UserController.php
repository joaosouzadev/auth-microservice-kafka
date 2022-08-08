<?php

namespace App\Http\Controllers\User;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {
    public $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function getUser(Request $request): JsonResponse {
        return $this->authService->getUser($request);
    }

    public function updateUser(Request $request) {
//        $user = $request->user();
//        $user->name = $request->name;
//        $user->save();
//
//        return response()->json($user, 200);
    }
}
