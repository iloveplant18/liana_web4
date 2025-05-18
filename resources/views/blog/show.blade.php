<x-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Назад к списку
                    </a>
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span>Опубликовано {{ $post->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>

            @if($post->image)
                <div class="border-t border-gray-200">
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ asset($post->image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>


            @if(session("user_id"))
            <button onclick="showCommentForm({{ $post->id }})">Добавить комментарий</button>
            <div id="comment-form-{{ $post->id }}" style="display:none; position:absolute; border:1px solid #ccc; background:#fff; padding:10px;">
                <form action="/blog/{{ $post->id }}/comment" method="POST"  target="hidden-iframe" onsubmit="setCommentXml({{ $post->id }});">
                    @csrf
                    <textarea id="comment-text-{{ $post->id }}"></textarea>
                    <input type="hidden" name="xml" id="comment-xml-{{ $post->id }}">
                    <button type="submit">Отправить</button>
                </form>
                <iframe name="hidden-iframe" style="display:none;"></iframe>
            </div>
        @endif
        
        <script> 
            function showCommentForm(postId) {
                    document.getElementById('comment-form-' + postId).style.display = 'block';
                }

                function setCommentXml(postId) {
                    const text = document.getElementById('comment-text-' + postId).value;
                    const xml = `<comment><text>${text}</text></comment>`;
                    document.getElementById('comment-xml-' + postId).value = xml;
                }
        </script>

        @foreach($post->comments as $comment)
    <div>
        <strong>{{ $comment->user?->full_name }}</strong> ({{ $comment->created_at }})
        <p>{{ $comment->comment }}</p>
    </div>
@endforeach




            <div class="border-t border-gray-200">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout> 