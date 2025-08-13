<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Post Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update this post") }}
        </p>
    </header>

    <form method="post" enctype="multipart/form-data"
        action="{{ route('posts.update', $post) }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post->title )" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="content" :value="__('Content')" />
            <x-text-input id="content" name="content" type="text" class="mt-1 block w-full" :value="old('content', $post->content )" required autocomplete="content" />
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>

        <div>
            <label for="tags">Tags</label><br>
            <select name="tags[]" id="tags" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}"
                        @selected(in_array($tag->id,old('tags',$postTagIds)))>
                            {{ $tag->name }}
                        </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="image" :value="__('Cover Image')" />
            <input type="file" name="image" id="image" accept="Image/*">
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update This Post') }}</x-primary-button>

            @if (session('status') === 'post-updated')
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
