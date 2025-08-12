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

                    <div>
                        <a href='{{ route('posts.create') }}'><h3>Create new post</h3></a>
                    </div>

                    <hr>

                    @forelse ($posts as $post)
                        <div @class([
                                'post-item','mb-4',
                                'is-odd'=>$loop->odd, 'is-even'=>$loop->even
                            ])>
                            <h3 class="text-lg font-bold">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-600">
                                By {{ $post->user->name }}
                            </p>

                            <div class="flex">

                                @can( 'update', $post )
                                    <form method="get" action="{{ route('posts.edit', $post) }}">
                                        <x-primary-button>{{ __('Edit Post') }}</x-primary-button>
                                    </form>
                                @endcan

                                @can( 'delete', $post )
                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-post-deletion-{{$post->id}}' )"
                                        >{{ __('Delete') }}</x-danger-button>
                                        <x-modal name="confirm-post-deletion-{{$post->id}}" :show="false" focusable>
                                            <form method="post" action="{{ route('posts.destroy', $post) }}" class="p-6">
                                                @csrf
                                                @method('delete')
                                    
                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ __('Are you sure you want to delete your Post?') }}
                                                </h2>
                                    
                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ __('Once your post is deleted, all of its data will be permanently deleted.') }}
                                                </p>
                                    
                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>
                                    
                                                    <x-danger-button class="ms-3">
                                                        {{ __('Delete Post') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                @endcan
                            </div>

                        </div>
                        <hr>
                    @empty
                        <p>No posts found.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>