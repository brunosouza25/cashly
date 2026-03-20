<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\{postJson, assertDatabaseHas};

uses(RefreshDatabase::class);

test("should be able to register and login", function () {
    // Passo 1: Registro
    postJson("api/auth/register", [
        'name' => 'Bruno Pestana',
        'email' => 'bruno@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertCreated();

    // Passo 2: Login (Aqui as requisições são independentes)
    postJson("api/auth/login", [
        'email' => 'bruno@example.com',
        'password' => 'password123',
    ])->assertOk()->assertJsonStructure([
        "token",
        "user" => ["name", "email"] // Você pode até detalhar o que vem dentro de user
    ]);
});

test("should not be able to log in with invalid credentials", function () {
    $user = User::factory()->createOne();
    postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])
        ->assertStatus(422);

});

test('it should register a new user successfully', function () {

    $userData = [
        'name' => 'Bruno Pestana',
        'email' => 'bruno@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = postJson('/api/auth/register', $userData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'token',
            'user' => [
                'name',
                'email'
            ]
        ]);

    assertDatabaseHas('users', [
        'email' => 'bruno@example.com',
    ]);
});

test('it should fail to register with an invalid email', function () {
    $response = postJson('/api/auth/register', [
        'name' => 'Bruno',
        'email' => 'invalid-email',
        'password' => '123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('it should fail to register with missing email', function () {
    $response = postJson('/api/auth/register', [
        'name' => 'Bruno',
        'password' => '123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});


test('it should logout with successfully', function () {

    $user = User::factory()->create();

    $token = $user->createToken('test-token')->plainTextToken;

    postJson('/api/auth/logout', [], [
        'Authorization' => "Bearer {$token}",
    ])
        ->assertNoContent();
});
