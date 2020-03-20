<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersActiveController extends Controller
{
    public function store(User $user)
    {
        $user->update(['active' => true]);

        flash('Usuário ativado com sucesso!');
        return back();
    }

    public function destroy(User $user)
    {
        $user->update(['active' => false]);

        flash('Usuário inativado com sucesso!');
        return back();
    }
}
