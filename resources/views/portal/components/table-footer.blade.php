<div class="d-flex align-items-center table__footer justify-content-between">
    <div class="table__footer__text f-w3">
        {{ $data->total() }} 件中
        @if(count($data) > 0)
            {{ ($data->currentPage()-1) * $data->perPage() + 1 }}
        @else
            0
        @endif から
        {{ ($data->currentPage()-1) * $data->perPage() + count($data) }}
        まで表示
    </div>
    <div class="table__footer__pagination">
        {{ $data->appends(request()->query())->links('portal.components.paginate') }}
    </div>
</div>
