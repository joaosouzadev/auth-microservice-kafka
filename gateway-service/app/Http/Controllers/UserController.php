<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {
    public function getUser(Request $request) {
        return $request->user();
    }

    public function updateUser(Request $request) {
        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return response()->json($user, 200);
    }
}
