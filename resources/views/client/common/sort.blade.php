<div class="sort d-flex align-items-center">
    <div class="sort-title">{{ $title }}</div>
    <label class="radio-custom d-flex align-items-center">
        @php
            $query = Request::all();
        @endphp
        <input type="radio" @if(Request::query('sort') == 1) checked @endif name="sort" onclick="window.location.href = '{{route(Route::currentRouteName(), array_merge($query, ['sort' => 1]))}}'">
        <span class="checkmark @if(Request::query('sort') == 1) checked @endif"></span>
        新しい順
    </label>
    <label class="radio-custom d-flex align-items-center oldest">
        <input type="radio" name="sort" onclick="window.location.href = '{{route(Route::currentRouteName(), array_merge($query, ['sort' => 2]))}}'">
        <span class="checkmark @if(Request::query('sort') == 2) checked @endif"></span>
        古い順
    </label>
</div>

<style>
    .checkRadio:checked ~ .checkmark {
        background: red;
    }
</style>