<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $password = $request->string('password')->value();

        $data = $request->validated();
        $data['password'] = Hash::make($password);

        $user = User::query()->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => new AuthResource($user), 'token' => $token], Response::HTTP_CREATED);
    }
}
