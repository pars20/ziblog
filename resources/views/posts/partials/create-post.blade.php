<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Post Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Create a new post") }}
        </p>
    </header>

    <form method="post" enctype="multipart/form-data"
        action="{{ route('posts.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="content" :value="__('Content')" />
            <x-text-input id="content" name="content" type="text" class="mt-1 block w-full" :value="old('content')" required autocomplete="content" />
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Cover Image')" />
            <input type="file" name="image" id="image" accept="Image/*">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save New Post') }}</x-primary-button>

            @if (session('status') === 'post-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
