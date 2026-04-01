<?php

namespace App\Http\Requests;

use App\Enums\AccountStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, ValidationRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'account_type_id' => ['required', 'uuid', 'exists:account_types,id'],
            'currency' => ['required', 'string', 'size:3'],
            'balance' => ['nullable', 'numeric'],
            'status' => ['nullable', new Enum(AccountStatus::class)],
        ];
    }
}
