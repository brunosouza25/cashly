<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<model-property<Account>, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid7()->toString(),
            'user_id' => User::factory(),
            'account_type_id' => AccountType::factory(),
            'name' => $this->faker->word().' Account',
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'currency' => 'BRL',
            'status' => AccountStatus::ACTIVE,
        ];
    }
}
