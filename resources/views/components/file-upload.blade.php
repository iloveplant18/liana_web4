@props([
    'name',
    'label',
    'accept' => '*',
    'hint' => '',
    'error' => null
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="{{ $name }}" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <span id="upload-text-{{ $name }}">Загрузить файл</span>
                    <input id="{{ $name }}" 
                           name="{{ $name }}" 
                           type="file" 
                           class="sr-only" 
                           accept="{{ $accept }}"
                           onchange="handleFileSelect(this, '{{ $name }}')">
                    <span id="file-name-{{ $name }}" class="text-xs text-gray-500"></span>
                </label>
                <p id="drag-text-{{ $name }}" class="pl-1">или перетащите</p>
            </div>
            @if($hint)
                <p class="text-xs text-gray-500">{{ $hint }}</p>
            @endif
        </div>
    </div>
    @if($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @enderror
</div>

<script>
    function handleFileSelect(input, name) {
        const fileName = input.files[0].name;
        document.getElementById('file-name-' + name).textContent = fileName;
        document.getElementById('upload-text-' + name).style.display = 'none';
        document.getElementById('drag-text-' + name).style.display = 'none';
    }
</script> 