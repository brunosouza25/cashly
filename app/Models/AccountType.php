<?php

namespace App\Models;

use App\Http\Resources\AccountTypeResource;
use Database\Factories\AccountTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountType extends BaseModel
{
    /** @use HasFactory<AccountTypeFactory> */
    use HasFactory;
    public function toResource(?string $resourceClass = null): AccountTypeResource
    {
        return new AccountTypeResource($this);
    }
    protected $fillable = ['name', 'slug', 'icon', 'color'];
}
