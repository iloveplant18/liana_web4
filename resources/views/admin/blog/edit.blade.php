@extends('admin.layout.app')

@section('title', 'Редактирование поста')

@section('content')
<div class="container mt-4">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Редактирование поста</h2>
                <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Назад
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="message-container">

            </div>

            <form method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Заголовок</label>
                        <input type="text" name="title" id="title" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                               value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Содержание</label>
                        <textarea name="content" id="content" rows="10" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.blog.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Отмена
                        </a>
                        <button id="submit-button" type="button" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i> Сохранить изменения
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="hidden" id="post-id">{{$post->id}}</div>

    <script>
        const submitButton = document.querySelector("#submit-button");
        console.log(submitButton)
        submitButton.addEventListener("click", function () {
            const postId = document.querySelector("#post-id").textContent;
            submitChanges(postId);
        });

        function submitChanges(postId) {
            console.log("asdf")
            const title = document.querySelector("#title").value;
            const content = document.querySelector("#content").value;
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = `/admin/blog/${postId}?title=${title}&content=${content}`;
            document.body.append(script);
        }

        function completeResponse() {
            console.log("response completed");
            const messageContainer = document.querySelector("#message-container");
            messageContainer.textContent = message;
        }
    </script>
</div>
@endsection 