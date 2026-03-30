<?php

namespace App\Enums;

enum AccountStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case CLOSED = 'closed';

    public function label(): string
    {
        return __('enums.account_status.'.$this->value);
    }
}
