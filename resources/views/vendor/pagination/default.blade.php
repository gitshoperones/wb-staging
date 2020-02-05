@if ($paginator->hasPages())
    <div class="pagination-wrap">
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#" class="next page-numbers current">previous</a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="next page-numbers">previous</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <a href="#" class="page-numbers current">{{ $element }}</a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="page-numbers current">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="page-numbers">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="next page-numbers">Next</a>
            @else
                <a href="#" class="next page-numbers current">Next</a>
            @endif
        </div>
    </div>
@endif

