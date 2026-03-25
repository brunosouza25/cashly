<?php

use App\Models\AccountType;
use Database\Seeders\AccountTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{postJson, getJson};
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('it should register a new AccounType successfuly', function () {
    $response = postJson('/api/v1/account_types', ["name" => "Debit", "slug" => "debit", "icon" => "credit-card", "color" => "#fff"]);
    $response->assertCreated()
        ->assertJsonStructure([
            'data' => ["id", "name", "slug", "icon", "color"]
        ]);
});

test('it should get all AccountType', function () {
    $this->seed(AccountTypeSeeder::class); //because every refreshdatabase will clean all, need it to run seeders
    $response = getJson('/api/v1/account_types');
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ["id", "name", "slug", "icon", "color"]
            ]
        ])
        ->assertJsonCount(4, 'data');
});

test('it should get one AccountType by id', function () {
    $accountType = AccountType::create(["name" => "Debit", "slug" => "debit", "icon" => "credit-card", "color" => "#fff"]);
    $response = getJson("/api/v1/account_types/{$accountType->id}");

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                "id", "name", "slug", "icon", "color"
            ]
        ]);
});

test("it shouldn't get AccountType by inexistent id", function () {
    $this->seed(AccountTypeSeeder::class); //because every refreshdatabase will clean all, need it to run seeders

    $uuidV7 = Str::uuid7();
    $response = getJson("/api/v1/account_types/{$uuidV7}");

    $response->assertNotFound();
});

test("it shouldn't register a new AccounType with duplicated slug", function () {
    AccountType::create(["name" => "Debit", "slug" => "debit", "icon" => "credit-card", "color" => "#fff"]);

    $response = postJson('/api/v1/account_types', ["name" => "Debit", "slug" => "debit", "icon" => "credit-card", "color" => "#fff"]);
    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['slug']);
});

test('it should update an AccountType successfuly', function () {
    $accountType = AccountType::create([
        "name" => "Old Name",
        "slug" => "old-slug",
        "icon" => "old-icon",
        "color" => "#000"
    ]);

    $newData = [
        "name" => "New Name",
        "slug" => "new-slug",
        "icon" => "new-icon",
        "color" => "#fff"
    ];

    $response = $this->putJson("/api/v1/account_types/{$accountType->id}", $newData);
    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                "id", "name", "slug", "icon", "color"
            ]
        ]);

    $this->assertDatabaseHas('account_types', [
        'id' => $accountType->id,
        'name' => 'New Name'
    ]);

    $this->assertDatabaseMissing('account_types', [
        'name' => 'Old Name'
    ]);
});

test('it should soft delete an account type', function () {
    $accountType = AccountType::create([
        "name" => "Savings",
        "slug" => "savings",
        "icon" => "piggy-bank",
        "color" => "#00ff00"
    ]);

    $response = $this->deleteJson("/api/v1/account_types/{$accountType->id}");

    $response->assertNoContent();

    $this->assertDatabaseHas('account_types', [
        'id' => $accountType->id,
    ]);

    expect($accountType->fresh()->deleted_at)->not->toBeNull();
});

