@if ($paginator->hasPages())
<div class="list_Paging">
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><span class="cmn-icon icon-arrow -l"></span></a>
    @foreach ($elements as $element)
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="p_num on" aria-current="page">{{ $page }}</span>
                @else
                    <span class="p_num"><a href="{{ $url }}">{{ $page }}</a></span>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><span class="cmn-icon icon-arrow -r"></span></a>
    @endif
</div>
@endif
