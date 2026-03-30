<?php

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->accountType = AccountType::factory()->create();
});

test('authenticated user can list their accounts', function () {
    Account::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'account_type_id' => $this->accountType->id,
    ]);

    Account::factory()->create();

    $this->actingAs($this->user)
        ->getJson('/api/v1/accounts')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(3, 'data');
});

test('user can create a new account', function () {
    $payload = [
        'name' => 'Main Wallet',
        'account_type_id' => $this->accountType->id,
        'balance' => 1500.50,
        'currency' => 'USD',
        'status' => 'active',
    ];

    $this->actingAs($this->user)
        ->postJson('/api/v1/accounts', $payload)
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonPath('data.name', 'Main Wallet');

    $this->assertDatabaseHas('accounts', [
        'name' => 'Main Wallet',
        'user_id' => $this->user->id,
    ]);
});

test('user can see a specific account details', function () {
    $account = Account::factory()->create([
        'user_id' => $this->user->id,
        'account_type_id' => $this->accountType->id,
    ]);

    $this->actingAs($this->user)
        ->getJson("/api/v1/accounts/{$account->id}")
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.id', $account->id);
});

test('user can update their own account', function () {
    $account = Account::factory()->create([
        'user_id' => $this->user->id,
        'account_type_id' => $this->accountType->id,
        'name' => 'Old Balance',
    ]);

    $this->actingAs($this->user)
        ->patchJson("/api/v1/accounts/{$account->id}", ['name' => 'New Name'])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.name', 'New Name');

    expect($account->fresh()->name)->toBe('New Name');
});

test('user cannot access or modify accounts from others', function () {
    $otherUser = User::factory()->create();
    $originalName = 'Forbidden account';
    $otherAccount = Account::factory()->create([
        'user_id' => $otherUser->id,
        'name' => $originalName,
        'account_type_id' => $this->accountType->id,
    ]);

    $response = $this->actingAs($this->user)
        ->patchJson("/api/v1/accounts/{$otherAccount->id}", [
            'name' => 'Hacked your account',
        ]);

    $response->assertStatus(Response::HTTP_NOT_FOUND);

    $this->assertDatabaseHas('accounts', [
        'id' => $otherAccount->id,
        'name' => $originalName,
        'user_id' => $otherUser->id,
    ]);

    $this->assertDatabaseMissing('accounts', [
        'name' => 'Hacked your account',
    ]);
});
