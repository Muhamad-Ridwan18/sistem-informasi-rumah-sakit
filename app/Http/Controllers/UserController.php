<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        User::create(request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|confirmed',
        ]));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $user->update(request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]));    
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
