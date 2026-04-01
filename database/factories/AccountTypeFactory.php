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
    protected string $keyType = 'string';

    /**
     * Define the model's default state.
     *
     * @return array<model-property<AccountType>, mixed>
     */
    public function definition(): array
    {
        /** @var string $baseName */
        $baseName = fake()->randomElement([
            'Wallet',
            'Bank Account',
            'Credit Card',
            'Savings',
            'Investment',
            'Cash',
        ]);

        $name = $baseName.' '.fake()->unique()->randomNumber(5);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => $this->faker->imageUrl(),
            'color' => $this->faker->hexColor(),
        ];
    }
}
