<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>

                <div class="flex gap-4">
                    @if ($post->user->image)
                        <img src="{{ Storage::url($post->user->image) }}" alt="{{ $post->user->name }}"
                            class="w-12 h-12 rounded-full">
                    @else
                        <img src="https://cdn12.picryl.com/photo/2016/12/31/head-the-dummy-avatar-people-b61cdb-1024.png"
                            alt="Dummy avatar" class="w-12 h-12 rounded-full">
                    @endif
                    <div>
                        <x-follow-container :user="$post->user" class="flex gap-2">
                            <a class="hover:underline"
                                href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a>
                            @auth
                                &middot;
                                <button @click="follow()" :class="following ? 'text-red-500' : 'text-emerald-600'"
                                    x-text="following ? 'Unfollow' : 'Follow' "></button>
                            @endauth
                        </x-follow-container>
                        <div class="flex gap-2 text-sm text-gray-500">

                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}

                        </div>
                    </div>
                </div>

                <div class="mt-8 p-3 border-t border-b flex justify-between">
                    <x-clap-button :post="$post" />

                    @if ($post->user_id === Auth::id())
                        <div class="">
                            <a href="{{ route('post.edit', $post->slug) }}"
                                class="px-4 py-1 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition me-2">
                                Edit
                            </a>

                            <form class="inline-block" action="{{ route('post.destroy', $post) }}" method="POST">
                                @csrf
                                @method('delete')

                                <button
                                    class="px-4 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <img class="w-full rounded-[4px]" src="{{ Storage::url($post->image) }}"
                        alt="{{ $post->title }}" />
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>

                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-full">
                        {{ $post->category->name }}
                    </span>
                </div>

                {{-- <div class="mt-8 p-3 border-t border-b">
                    <x-clap-button :post="$post" />
                </div> --}}

            </div>

        </div>
    </div>
</x-app-layout>
