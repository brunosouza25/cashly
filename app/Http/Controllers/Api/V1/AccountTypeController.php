<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountTypeRequest;
use App\Http\Requests\UpdateAccountTypeRequest;
use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = AccountType::all();
        return AccountTypeResource::collection($types);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountTypeRequest $request)
    {
        $account_type = AccountType::create($request->validated());

        return $account_type->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountType $accountType)
    {
        return $accountType->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAccountTypeRequest $request, AccountType $accountType)
    {
        $accountType->update($request->validated());
        return $accountType->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountType $accountType)
    {
        $accountType->delete();
        return response()->noContent();
    }
}
