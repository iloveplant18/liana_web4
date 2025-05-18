{{-- filepath: c:\Личные файлы\СевГУ\Веб-технологии\6 семестр\Лабораторные работы\ЛР1\lr1\resources\views\album.blade.php --}}
<x-layout>
    <x-slot:title>Фотоальбом</x-slot:title>
    <h1 class="text-3xl font-bold mb-4">Фотоальбом</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($photos as $photo)
            <div class="bg-white rounded-lg shadow p-4">
                <img src="{{ asset('images/' . $photo['file']) }}" alt="{{ $photo['caption'] }}" class="w-full h-48 object-cover rounded">
                <p class="mt-2 text-center font-bold">{{ $photo['caption'] }}</p>
            </div>
        @endforeach
    </div>
</x-layout>