@extends("admin.layout.app")

@section("content")
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-8">
            <!-- Форма создания поста -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Создание нового поста</h3>

                    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Тема сообщения *</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}"
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 min-h-10 px-5 rounded-md @error('title') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                       required>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Текст сообщения *</label>
                            <div class="mt-1">
                                <textarea id="content" 
                                          name="content" 
                                          rows="5" 
                                          class="px-5 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('content') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <x-file-upload 
                            name="image"
                            label="Изображение"
                            accept="image/*"
                            hint="PNG, JPG, GIF до 5MB"
                            :error="$errors->first('image')"
                        />

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.blog.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Отмена
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Создать пост
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Форма загрузки CSV -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Импорт постов из CSV</h3>

                    <form method="POST" action="{{ route('admin.blog.import') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <x-file-upload 
                            name="csv_file"
                            label="CSV файл с постами"
                            accept=".csv"
                            hint="CSV файл с колонками: title,content,created_at"
                            :error="$errors->first('csv_file')"
                        />

                        <div class="flex justify-end space-x-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Импортировать посты
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection