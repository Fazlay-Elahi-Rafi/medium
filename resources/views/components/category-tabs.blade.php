<li class="me-2">
    <a href="/"
        class="{{ request('category')
            ? 'px-4 py-2 rounded-[4px] text-gray-700 hover:bg-blue-100 font-semibold hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-400'
            : 'px-4 py-2 rounded-[4px] bg-blue-100 text-blue-700 font-semibold transition ease-in-out duration-400' }} ">
        All
    </a>
</li>
@foreach ($categories as $category)
    <li>
        <a href="{{ route('post.byCategory', $category) }}"
            class="{{ Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id
                ? 'active-tab px-4 py-2 rounded-[4px] bg-blue-100 text-blue-700 font-semibold transition ease-in-out duration-400'
                : 'px-4 py-2 rounded-[4px] text-gray-700 hover:bg-blue-100 font-semibold hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-400' }}">
            {{ $category->name }}
        </a>
    </li>
@endforeach
