<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Боковое меню -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Админ-панель</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Дашборд
                </a>
                <a href="{{ route('admin.statistics') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.statistics') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-chart-bar mr-2"></i> Посещаемость  
                </a>
                <a href="{{ route('admin.blog.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.blog*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-blog mr-2"></i> Блог
                </a>
                <a href="{{ route('admin.guestbook') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.guestbook*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-book mr-2"></i> Гостевая книга
                </a>
                <a href="{{ route('admin.logout') }}" class="block px-4 py-2 hover:bg-gray-700 mt-4">
                    <i class="fas fa-sign-out-alt mr-2"></i> Выход
                </a>
            </nav>
        </div>

        <!-- Основной контент -->
        <div class="flex-1">
            <!-- Верхняя панель -->
            <header class="bg-white shadow">
                <div class="px-4 py-3">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('title', 'Панель управления')
                        </h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">Администратор</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Контент -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html> 