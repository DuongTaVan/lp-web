@if (!$data->isEmpty())
    @forelse ($data as $item)
        @if($item->is_read == 1)
            <div class="notice-paragraph">
                <div class="row">
                    <div class="col-md-2 notice-image">
                        <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                    </div>
                    <div class="col-md-10 notice-content">
                        <h6>{{ $item['title'] ?? null }}</h6>
                        <p>{{ $item['body'] ?? null }}</p>
                    </div>
                    <div class="col-md-12 text-right">
                        <h3 class="notice-time">{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d') ?? null }}
                            &nbsp;{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') ?? null }}</h3>
                    </div>
                </div>
            </div>
        @else
            <div class="notice-paragraph notice_unread">
                <div class="row">
                    <div class="col-md-2 notice-image">
                        <img src="{{asset('assets/img/notice/frog.png')}}" alt="">
                    </div>
                    <div class="col-md-10 notice-content">
                        <h6>{{ $item['title'] ?? null }}</h6>
                        <p>{{ $item['body'] ?? null }}</p>
                    </div>
                    <div class="col-md-12 text-right">
                        <h3 class="notice-time">{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d') ?? null }}
                            &nbsp;{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') ?? null }}</h3>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <p class="text-center">@lang('labels.search.no_data')</p>
    @endforelse
@endif
