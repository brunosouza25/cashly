<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
    protected function getUser(): User
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        return $user;
    }
}
