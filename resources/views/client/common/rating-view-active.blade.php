@for($i=0; $i<10; $i++)
    @if($i%2!=0)
        <li class="card__content__rate__rating__list-rating__even">
            <i class="fa fa-star-half @if($i<$rating) rating-active @endif"></i>
        </li>
    @else
        <li>
            <i class="fa fa-star-half @if($i<$rating) rating-active @endif"></i>
        </li>
    @endif

@endfor
