
<div class="row">
    <div class="col-lg-4">
        {{ $data->total()}} 件中
        @if(count($data) > 0)
            {{ ($data->currentPage()-1) * $data->perPage() + 1 }}
        @else
            0
        @endif から
        {{ ($data->currentPage()-1) * $data->perPage() + count($data) }}
        まで表示
    </div>
    <div class="col-lg-8">
        <ul role="menubar" aria-disabled="false" aria-label="Pagination" class="pagination justify-content-end">
            {{ $data->appends(request()->query())->links('portal.dashboard.base.paginate') }}
        </ul>
    </div>
</div>
