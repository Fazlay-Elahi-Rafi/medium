<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul
                    class="flex flex-wrap text-sm font-medium justify-center items-center text-center text-gray-700 dark:text-gray-300 px-4 py-6">
                    <x-category-tabs></x-category-tabs>
                </ul>
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
