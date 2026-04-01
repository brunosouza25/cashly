<?php

namespace App\Http\Controllers\Api\Auth;

use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginData $data): JsonResponse
    {
        $user = User::where('email', $data->email)->first();

        if (! $user || ! Hash::check($data->password, (string) $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        /** @var string $appName */
        $appName = config('app.name', 'cashly_token');

        $tokenName = str($appName)->slug()->toString() ?: 'cashly_token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => new AuthResource($user),
        ]);
    }
}
