<?php

namespace App\Models;

use Database\Factories\AccountTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountType extends BaseModel
{
    /** @use HasFactory<AccountTypeFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'color'];
}
