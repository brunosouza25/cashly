<?php

namespace Database\Factories;

use App\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<AccountType>
 */
class AccountTypeFactory extends Factory
{
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Wallet',
            'Bank Account',
            'Credit Card',
            'Savings',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            "icon" => $this->faker->imageUrl(),
            "color" => $this->faker->hexColor(),
        ];
    }
}
