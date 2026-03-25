<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountType extends BaseModel
{
    /** @use HasFactory<\Database\Factories\AccountTypeFactory> */
    use HasFactory;
    protected $fillable = ['name', 'slug', 'icon', 'color'];

}
