@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination mb-0" style="display:flex;justify-content:center;gap:10px;list-style:none;padding-left:0;">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="opacity:.6;cursor:default;">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif

