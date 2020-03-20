<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::when(request('q'), function ($builder) {
            $builder->where('name', 'like', '%' . request('q') . '%')
                ->where('email', 'like', '%' . request('q') . '%');
        })->when(request('status'), function ($builder) {
            $builder->where('active', (int) request('status'));
        })
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'min:3', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $attributes['password'] = bcrypt($attributes['password']);

        User::create($attributes);

        flash('Usuário atualizado com sucesso!');
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'min:3', 'max:255', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        if ($attributes['password']) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }

        $user->update($attributes);

        flash('Usuário atualizado com sucesso!');
        return redirect()->route('users.index');
    }
}
