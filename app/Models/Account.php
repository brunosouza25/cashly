<?php

namespace App\Models;

use App\Enums\AccountStatus;
use Database\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends BaseModel
{
    /** @use HasFactory<AccountFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_type_id',
        'name',
        'balance',
        'currency',
        'status',
    ];

    protected $casts = [
        'status' => AccountStatus::class,
        'balance' => 'decimal:2',
        'id' => 'string',
    ];

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
