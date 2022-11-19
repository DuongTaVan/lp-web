@if($paginate['totalPage'] === 0)

@else
    @if ($paginate && $paginate['total'] > 10)
        <div class="sidebar-right__paginate">
            <div class="sidebar-right__paginate__total">
                <div class="sidebar-right__paginate__total__top">
                    {{-- Previous Page Link --}}
                    @if($paginate['page'] > 1)
                        <a class="sidebar-right__paginate__total__top__1"
                        href="{{request()->fullUrlWithQuery(['page'=> $paginate['page']-1])}}">
                            <img class="icon-previous" src="{{asset('./assets/img/search/icon/right.svg')}}" alt="">
                        </a>
                    @endif

                    @for($i = 1; $i <= $paginate['totalPage']; $i++)

                        {{-- Pagination Elements --}}

                        {{-- Array Of Links --}}
                        @if($i == request()->page)
                            <a class="active sidebar-right__paginate__total__top__2 ">{{$i}}</a>
                        @elseif(request()->page === null && $i === 1)
                            <a class="active sidebar-right__paginate__total__top__2 ">{{$i}}</a>
                        @elseif (($i == $paginate['page'] -1 || $i  == $paginate['page'] - 2 || $i  == $paginate['page'] + 1 || $i  == $paginate['page'] + 2) || $i  == $paginate['totalPage'] || $i  == 1)
                            @if ($i  == $paginate['totalPage'] && $paginate['page'] < $paginate['totalPage'] - 3)
                                <div
                                    class="sidebar-right__paginate__total__top__3"
                                    href="#"
                                >
                                    ...
                                </div>
                            @endif
                            <a
                                class="sidebar-right__paginate__total__top__3"
                                href="{{request()->fullUrlWithQuery(['page'=>$i])}}"
                            >
                                {{$i}}
                            </a>
                            @if ($i  == 1 && $paginate['page'] > 3)
                                <div
                                    class="sidebar-right__paginate__total__top__3"
                                    href="#"
                                >
                                    ...
                                </div>
                            @endif
                        @endif

                    @endfor

                    {{-- Next Page Link --}}
                    @if($paginate['page'] != $paginate['totalPage'])
                        <a class="sidebar-right__paginate__total__top__4"
                        href="{{request()->fullUrlWithQuery(['page'=>$paginate['page']+1])}}">
                            <img src="{{asset('./assets/img/search/icon/right.svg')}}" alt="">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-center table__footer__text f-w3">
        {{$paginate['total']}} 件中
        @if($paginate['page'] < $paginate['totalPage'])
            {{($paginate['page'] -1)*$paginate['limit'] + 1}} - {{($paginate['page']) * $paginate['limit']}}件
        @else
            {{($paginate['page'] -1)*$paginate['limit'] + 1}} - {{$paginate['total']}}件
        @endif
    </div>
@endif