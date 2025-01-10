<!-- resources/views/users/edit/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuário</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Senha (deixe em branco para não alterar)</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmação da Senha</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-warning">Atualizar Usuário</button>
    </form>
</div>
@endsection
