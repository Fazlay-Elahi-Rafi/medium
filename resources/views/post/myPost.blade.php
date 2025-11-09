<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-2xl font-semibold text-center py-4">My Posts</div>
            </div>

            <div class="mt-8">
                @forelse ($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                @empty
                    <div class="text-center">No Posts Found</div>
                @endforelse
            </div>

            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>
