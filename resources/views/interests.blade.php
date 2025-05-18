<x-layout>
    <x-slot:title>Мои интересы</x-slot:title>
    <h1 class="text-3xl font-bold mb-4">Мои интересы</h1>
    
    <div class="space-y-6">
        @foreach ($interests as $interest)
            <div class="p-4 border rounded-lg bg-white shadow">
                <h2 class="text-2xl font-bold">{{ $interest['title'] }}</h2>
                <p class="mt-2">{{ $interest['description'] }}</p>
            </div>
        @endforeach
    </div>
</x-layout>
