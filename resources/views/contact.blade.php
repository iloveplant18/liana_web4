{{-- filepath: c:\Личные файлы\СевГУ\Веб-технологии\6 семестр\Лабораторные работы\ЛР1\lr1\resources\views\contact.blade.php --}}
<x-layout>
    <x-slot:title>Контакты</x-slot:title>
    <h1 class="text-3xl font-bold mb-4">Свяжитесь со мной</h1>
    {{ session("success") }}
    <form action="/contact" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-bold">Имя</label>
            <input type="text" name="name" class="border p-2 w-full">
            <div class="text-red-500">
                @foreach ($errors->get("name") as $error)
                    {{ $error }}
                @endforeach
            </div>
        </div>
        <div>
            <label class="block font-bold">Сообщение</label>
            <textarea name="message" class="border p-2 w-full"></textarea>
            <div class="text-red-500">{{ $errors->first("message") }}</div>
        </div>
        <div>
            <label class="block font-bold">Пол</label>
            <select name="gender" class="border p-2 w-full">
                <option value="male">Мужской</option>
                <option value="female">Женский</option>
            </select>
            <div class="text-red-500">{{ $errors->first("gender") }}</div>
        </div>
        <div>
            <label class="block font-bold">Возраст</label>
            <input type="number" name="age" class="border p-2 w-full">
            <div class="text-red-500">{{ $errors->first("age") }}</div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Отправить</button>
    </form>
</x-layout>