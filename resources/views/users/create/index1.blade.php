@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Usuários em Massa</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('enviar.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="arquivo">Escolha o arquivo Excel</label>
            <input type="file" class="form-control" id="arquivo" name="arquivo" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>
    </form>
</div>
@endsection
