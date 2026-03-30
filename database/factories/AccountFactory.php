<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => str()->uuid7(),
            'user_id' => User::factory(),
            'account_type_id' => AccountType::factory(),
            'name' => $this->faker->word() . ' Account',
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'currency' => 'BRL',
            'status' => AccountStatus::ACTIVE,
        ];
    }
}
