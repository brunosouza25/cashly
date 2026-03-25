<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Wallet', 'slug' => 'wallet', 'icon' => 'wallet', 'color' => '#10B981'],
            ['name' => 'Bank Account', 'slug' => 'bank-account', 'icon' => 'bank', 'color' => '#3B82F6'],
            ['name' => 'Credit Card', 'slug' => 'credit-card', 'icon' => 'credit-card', 'color' => '#EF4444'],
            ['name' => 'Savings', 'slug' => 'savings', 'icon' => 'piggy-bank', 'color' => '#8B5CF6'],
        ];

        foreach ($types as $type) {
            AccountType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
