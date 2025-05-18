<x-layout>
    <x-slot:title>Гостевая книга</x-slot:title>

    <h1 class="text-3xl font-bold mb-4">Гостевая книга</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/guestbook" class="space-y-4">
        @csrf
        <div>
            <label>Фамилия:</label>
            <input type="text" name="last_name" class="border p-2 w-full" required>
        </div>
        <div>
            <label>Имя:</label>
            <input type="text" name="first_name" class="border p-2 w-full" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" class="border p-2 w-full" required>
        </div>
        <div>
            <label>Текст отзыва:</label>
            <textarea name="message" rows="4" class="border p-2 w-full" required></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Отправить</button>
    </form>

    <hr class="my-6">

    <h2 class="text-xl font-semibold mb-2">Оставленные отзывы:</h2>
    @forelse($messages as $m)
        <div class="border p-4 rounded mb-2">
            <p class="text-sm text-gray-500">{{ $m['date'] }} — {{ $m['first'] }} {{ $m['last'] }} ({{ $m['email'] }})</p>
            <p class="mt-1">{{ $m['text'] }}</p>
        </div>
    @empty
        <p class="text-gray-500">Пока нет ни одного отзыва.</p>
    @endforelse
</x-layout>