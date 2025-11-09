@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="mt-8 flex justify-center text-sm">
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 border rounded cursor-not-allowed">Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 bg-white border rounded text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">Prev</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 rounded-[4px] bg-blue-100 text-blue-700 font-semibold transition ease-in-out duration-400">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 bg-white border rounded text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 bg-white border rounded text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">Next</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 border rounded cursor-not-allowed">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
