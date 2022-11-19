@if(!empty($data))
    <div class="d-flex justify-content-center align-items-center f-w3"
         style="font-size: 14px;color:#4E5768">
        {{ $data->total() }}@lang('labels.search.in_piece')
        @if(count($data) > 0)
            {{ ($data->currentPage()-1) * $data->perPage() + 1 }}
        @else
            0
        @endif -
        {{ ($data->currentPage()-1) * $data->perPage() + count($data) }}
        @lang('labels.search.case')
    </div>
@endif