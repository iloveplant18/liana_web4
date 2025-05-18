@extends('admin.layout.app')

@section('title', 'Панель управления')

@section('content')
<div class="container mt-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Добро пожаловать в админ-панель</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col">
                <h5 class="text-lg font-semibold text-gray-800 mb-2">Статистика</h5>
                <p class="text-gray-600 mb-4">Просмотр статистики сайта</p>
                <a href="{{ route('admin.statistics') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Перейти
                </a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col">
                <h5 class="text-lg font-semibold text-gray-800 mb-2">Блог</h5>
                <p class="text-gray-600 mb-4">Управление блогом</p>
                <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Перейти
                </a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col">
                <h5 class="text-lg font-semibold text-gray-800 mb-2">Гостевая книга</h5>
                <p class="text-gray-600 mb-4">Управление гостевой книгой</p>
                <a href="{{ route('admin.guestbook') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Перейти
                </a>
            </div>
        </div>
    </div>
</div>

@endsection