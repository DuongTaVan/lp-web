@php
    $ratingProcess = 0;
    if (isset($rating)) {
        if (($rating * 2) % 2 == 1){
            $ratingProcess = $rating;
        } else {
            $ratingProcess = round($rating);
        }
    }
@endphp
@for($i=0; $i<10; $i++)
    @if($i<$ratingProcess*2)
        @if($i%2!=0)
            <li class="card__content__rate__rating__list-rating__even">
                <i class="fa fa-star-half  rating-active"></i>
            </li>
        @else
            <li>
                <i class="fa fa-star-half rating-active"></i>
            </li>
        @endif
    @else
        @if($i%2!=0)
            <li class="card__content__rate__rating__list-rating__even">
                <i class="fa fa-star-half"  style="color: #CCCCCC"></i>
            </li>
        @else
            <li>
                <i class="fa fa-star-half"  style="color: #CCCCCC"></i>
            </li>
        @endif
    @endif

@endfor
