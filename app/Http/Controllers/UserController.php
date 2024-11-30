<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Mostrar o formulário para criar um novo usuário
    public function create()
    {
        return view('users.create.index');
    }

    // Armazenar um novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    // Mostrar um usuário específico
    public function show(User $user)
    {
        return view('users.index', compact('user'));
    }

    // Mostrar o formulário para editar um usuário
    public function edit(User $user)
    {
        return view('users.edit.index', compact('user'));
    }

    // Atualizar um usuário específico
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    // Deletar um usuário
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário deletado com sucesso.');
    }

}
