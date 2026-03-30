<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Usuário Teste',
            'email' => 'teste@cashly.com',
        ]);

        $type = AccountType::first() ?? AccountType::factory()->create(['name' => 'Carteira']);

        Account::factory(10)->create([
            'user_id' => $user->id,
            'account_type_id' => $type->id,
        ]);
    }
}
