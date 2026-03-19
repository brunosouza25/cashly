<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{postJson, assertDatabaseHas};

uses(RefreshDatabase::class);

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
