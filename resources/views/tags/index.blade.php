<x-app-layout>

    {{-- This part goes into the layout's named "header" slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Tags') }}
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
                        <a href='{{ route('tags.create') }}'><h3>Create new TAG</h3></a>
                    </div>

                    <hr>

                    @forelse ($tags as $tag)
                        <div @class([
                                'post-item','mb-4',
                                'is-odd'=>$loop->odd, 'is-even'=>$loop->even
                            ])>
                            <h3 class="text-lg font-bold">
                                <a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a>
                            </h3>

                        </div>
                        <hr>
                    @empty
                        <p>No tags found.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $tags->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>