<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $role = $request->role === 'admin' ? 'admin' : 'customer';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'verification_code' => Str::random(6),
        ]);

        $token = $user->createToken('support-chat')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        $requestedRole = $request->role ?? 'customer';

        if ($requestedRole === 'admin' && $user->role !== 'admin') {
            throw ValidationException::withMessages([
                'role' => ['You are not authorized to use the admin portal.'],
            ]);
        }

        if ($requestedRole === 'support_agent' && $user->role !== 'support_agent') {
            throw ValidationException::withMessages([
                'role' => ['You are not authorized to use the support agent portal.'],
            ]);
        }

        $token = $user->createToken('support-chat')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully.',
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        Password::broker()->sendResetLink(['email' => $request->email]);

        return response()->json(['message' => 'Password reset link sent.']);
    }

    public function verifyEmail(Request $request)
    {
        $user = User::where('verification_code', $request->code)->firstOrFail();
        $user->verified_at = now();
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully.']);
    }
}
