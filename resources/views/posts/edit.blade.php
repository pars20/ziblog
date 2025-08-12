<x-app-layout>

    {{-- This part goes into the layout's named "header" slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Blog Post : '. $post->title ) }}
        </h2>
    </x-slot>

    {{-- This is your main page content, which goes into the default slot --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('posts.partials.edit-post')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>