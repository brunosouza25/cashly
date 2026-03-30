<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return AccountResource::collection($request->user()->accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        $account = $request->user()->accounts()->create($request->validated());

        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        // Simples: Se não for do usuário, bloqueia.
        abort_if($account->user_id !== auth()->id(), 404);

        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        abort_if($account->user_id !== auth()->id(), 404);

        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        abort_if($account->user_id !== auth()->id(), 404);

        $account->delete();

        return response()->noContent();
    }
}
