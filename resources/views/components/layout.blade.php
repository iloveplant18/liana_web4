<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Website' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">
    <header class="bg-blue-600 text-white p-4">
        <nav class="container mx-auto flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/" class="font-bold">Главная</a>
                <a href="/test" class="font-bold">Тест</a>
                <a href="/test-results" class="font-bold">Результаты теста</a>
                <a href="/interests" class="font-bold">Мои интересы</a>
                <a href="/album" class="font-bold">Фотоальбом</a>
                <a href="/guestbook" class="font-bold">Гостевая книга</a>
                <a href="{{ route('blog.index') }}" class="font-bold">Блог</a>
            </div>
            <div class="flex items-center space-x-4">
                @if (session('user_id'))
                    <span class="text-sm">Привет, {{ session('user_name') }}!</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Войти
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Регистрация
                    </a>
                @endauth
            </div>
        </nav>
    </header>
    <main class="container mx-auto p-4">
        {{ $slot }}
    </main>
    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        &copy; {{ date('Y') }} Волшебный грибочек
    </footer>
</body>
</html>