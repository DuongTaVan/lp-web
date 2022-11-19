@php
    $ratingProcess = 0;
    if (isset($rating)) {
        $rating = $rating > 5 ? 5 : $rating;
        $ratingProcess = ($rating * 10) % 10 === 5 ? $rating : round($rating);
    }
    $subsist = 5 - $ratingProcess;
@endphp
<div class="list-star d-flex justify-content-center align-items-center">
    @for($i = 0; $i < floor($ratingProcess); $i++)
        <li class="full-star-active">
            <img class="star-active" src="{{asset('assets/img/clients/star-active.svg')}}" alt="">
        </li>
    @endfor
    @if($ratingProcess - floor($ratingProcess) != 0)
        <li class="half-star">
            <img class="halfstar" src="{{asset('assets/img/clients/halfstar.svg')}}" alt="">
        </li>
    @endif
    @for($i = 0; $i < floor($subsist); $i++ )
        <li class="full-star-non-active">
            <img class="star-non-active" src="{{asset('assets/img/clients/star-non-active.svg')}}" alt="">
        </li>
    @endfor
</div>

