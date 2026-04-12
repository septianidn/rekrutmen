<nav>
    <ul class="pagination mb-0" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 4px; margin: 0; padding: 0;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="lni lni-arrow-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="lni lni-arrow-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="lni lni-arrow-right"></i></a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link"><i class="lni lni-arrow-right"></i></span>
            </li>
        @endif
    </ul>
</nav>
