<ul>
    @for($i=0; $i<10; $i++)
        @if($i%2==0)
            <li><i class="fa fa-star-half disabled @if($i<$rating) active @endif" aria-hidden="true"></i>
            </li>
        @else
            <li class="order-view__content__satisfaction__right__rate__rating__list__second">
                <i class="fa fa-star-half disabled @if($i<$rating) active @endif" aria-hidden="true"></i>
            </li>
        @endif
    @endfor
</ul>

