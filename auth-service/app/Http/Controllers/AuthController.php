<?php

namespace App\Http\Controllers;

use App\Jobs\ResetPasswordEmail;
use App\Jobs\ResetPasswordEmailConfirmation;
use App\Jobs\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function register(Request $request) {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255'
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_token' => Str::uuid()
        ]);

        WelcomeEmail::dispatch($user->toArray());
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], Response::HTTP_BAD_REQUEST);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('SANCTUM_TOKEN');
            return response()->json($token->plainTextToken);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    public function sendResetLinkEmail(Request $request) {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->reset_password_token = Str::uuid();
            $user->save();
            ResetPasswordEmail::dispatch($request->email, $user->reset_password_token);
        }

        return response()->json('Follow the instructions sent to your e-mail');
    }

    public function resetPassword(Request $request) {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'token' => 'required|string|max:255',
            'new_password' => 'required|string|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->where('reset_password_token', $request->token)->first();
        if (!$user) {
            return response()->json(['errors' => 'User not found'], Response::HTTP_BAD_REQUEST);
        }

        $user->password = Hash::make($request->new_password);
        $user->reset_password_token = null;
        $user->save();
        ResetPasswordEmailConfirmation::dispatch($request->email, $user->reset_password_token);

        return response()->json('Password changed!');
    }
}
