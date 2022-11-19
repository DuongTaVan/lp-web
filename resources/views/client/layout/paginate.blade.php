@if($paginator->total() === 0)
@else
    @if (isset($paginator)&& $paginator->hasPages())
        <div class="sidebar-right__paginate">
            <div class="sidebar-right__paginate__total">
                <div class="sidebar-right__paginate__total__top">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                    @else
                        <a class="sidebar-right__paginate__total__top__1" href="{{ $paginator->previousPageUrl() }}">
                            <img class="icon-previous" src="{{asset('./assets/img/search/icon/right.svg')}}" alt="">
                        </a>
                    @endif
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page === $paginator->currentPage())
                                    <a class="active sidebar-right__paginate__total__top__2 ">{{ $page }}</a>
                                @elseif (($page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2) || $page === $paginator->lastPage() || $page === 1)
                                    <a class="sidebar-right__paginate__total__top__3" href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                @elseif ($page === $paginator->lastPage() - 1 || $page === 2 )
                                    <li class="sidebar-right__paginate__total__top__3"><span>...</span></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a class="sidebar-right__paginate__total__top__4" href="{{ $paginator->nextPageUrl() }}">
                            <img src="{{asset('./assets/img/search/icon/right.svg')}}" alt="">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-center table__footer__text f-w3 @if($paginator->total()<10)mt-15px @endif">
        @if(isset($paginator))
            {{$paginator->total()}} 件中
            @if(count($paginator) > 0)
                {{ ($paginator->currentPage()-1) * $paginator->perPage() + 1 }}
            @else
                0
            @endif -
            {{ ($paginator->currentPage()-1) * $paginator->perPage() + count($paginator) }}
            件
        @endif
    </div>
@endif