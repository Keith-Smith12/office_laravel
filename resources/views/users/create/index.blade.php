<!-- resources/views/users/create/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Novo Usuário</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmação da Senha</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-success">Criar Usuário</button>
    </form>
</div>
@endsection
