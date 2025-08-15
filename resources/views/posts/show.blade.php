<x-app-layout>
    {{-- This part goes into the layout's named "header" slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Blog Posts') }}
        </h2>
    </x-slot>

    {{-- This is your main page content, which goes into the default slot --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="post-item mb-4">
                        <h3 class="text-lg font-bold">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </h3>

                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                alt="Cover image for {{ $post->title }}">
                        @endif

                        <p>
                            {{ $post->content }}
                        </p>
                        <p class="text-sm text-gray-600">
                            By {{ $post->user->name }}
                        </p>

                        @if( $post->tags )
                            <div class="tags">
                                @foreach( $post->tags as $tag )
                                    <a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            @if( $comments )
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @forelse( $comments as $comment )
                    <div class="post-item mb-4">
                    <p>from: {{ $comment->user->name }}</p>
                    <p>{{ $comment->body }}</p>
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    منتظر اولین کامنت هستیم!
                @endforelse
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ $comments->links() }}
                </div>
            </div>
            @endif

            
            @if( Auth::user() )
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('posts.comments.store', $post ) }}">
                        @csrf
                        <textarea name="body" placeholder="Comment"></textarea>
                        <br>
                        <input type="submit" value="Send comment">
                    </form>
                </div>
            </div>
            @endif


        </div>
    </div>
</x-app-layout>