<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicação')</title>
    <link rel="stylesheet" href="{{ asset('css/app-light.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Minha Aplicação</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('users.index') }}">Usuários</a></li>
                    <li><a href="#">Outras Seções</a></li>
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} Minha Aplicação. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script src="{{ asset('js/apps.js') }}"></script>
</body>
</html>
