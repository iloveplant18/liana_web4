{{-- filepath: c:\Личные файлы\СевГУ\Веб-технологии\6 семестр\Лабораторные работы\ЛР1\lr1\resources\views\test.blade.php --}}
<x-layout>
    <x-slot:title>Тест</x-slot:title>
    <h1 class="text-3xl font-bold mb-4">Тест по дисциплине</h1>
    <div>
        {{ session("success") }}
    </div>
    <form action="/test" method="POST" class="space-y-4">
        @csrf
        {{ $errors }}
        <div>
            <label class="block font-bold">Ваше имя, пожалуйста</label>
            <input type="text" name="name" class="border p-2 w-full">
            <div class="text-red-500">
                @foreach ($errors->get("name") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div>
            <label class="block font-bold">Емаил</label>
            <input type="email" name="email" class="border p-2 w-full">
            <div class="text-red-500">
                @foreach ($errors->get("email") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div>
            <label class="block font-bold">1. Ваш любимый цвет?</label>
            <input type="text" name="favorite_color" class="border p-2 w-full">
            <div class="text-red-500">
                @foreach ($errors->get("favorite_color") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div>
            <label class="block font-bold">2. Выберите любимое животное:</label>
            <div>
                <input type="radio" name="animal" value="cat" id="cat">
                <label for="cat">Кошка</label>
            </div>
            <div>
                <input type="radio" name="animal" value="dog" id="dog">
                <label for="dog">Собака</label>
            </div>
            <div class="text-red-500">
                @foreach ($errors->get("animal") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div>
            <label class="block font-bold">3. Какие из этих хобби вам нравятся?</label>
            <div>
                <input type="checkbox" name="hobbies[]" value="reading" id="reading">
                <label for="reading">Чтение</label>
            </div>
            <div>
                <input type="checkbox" name="hobbies[]" value="traveling" id="traveling">
                <label for="traveling">Путешествия</label>
            </div>
            <div class="text-red-500">
                @foreach ($errors->get("hobbies[]") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Отправить</button>
    </form>
</x-layout>