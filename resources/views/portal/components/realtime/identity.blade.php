<tr id="{{ $data->user_id }}" class="f-w3 indentity-image-list-info text-left">
    <td class="indentity-image__id">{{ $data->id }}</td>
    @php
        $query = app('request')->request->all();
        $result = array_merge(['user_id' => $data->user_id, 'link' => 'identity'], $query);
    @endphp
    <td class="indentity-image__user_id">
        <a href="{{ route('portal.user.detail', $result) }}"
           class="user-link-detail">{{ $data->user_id }}</a>
    </td>
    <td class="indentity-image__teacher-category">
        {{ $data->teacher_category_text }}
        <span></span>
    </td>
    <td class="indentity-image__name">
        <p class="mb-0">{{ $data->last_name_kanji }}{{ $data->first_name_kanji }}</p>
        <p class="mb-0">{{ $data->last_name_kana }}{{ $data->first_name_kana }}</p>
    </td>
    <td class="indentity-image__account_name">{{ $data->account_name }}</td>
    @if($data->image_url === null)
        <td class="indentity-image__image_url">
        </td>
    @else
        <style>
            .list-image {
                display: flex;
            }

            .identity-image__image:nth-child(2) {
                margin-left: 5px;
            }
        </style>
        <td class="indentity-image__image_url text-center list-image">
            @if(isset($data->user) && isset($data->user->imagePathAllType))
                @foreach($data->user->imagePathAllType as $imageType)
                    <img data-toggle="modal" data-target="#modalImage" class="identity-image__image"
                         src="{{ $imageType->image_url }}" alt="">
                @endforeach
            @endif
        </td>
    @endif
    <td class="indentity-image__updated-at"
        style="min-width: 125px;">{{ \Illuminate\Support\Carbon::parse($data->created_at)->format('Y-m-d')  }}</td>
    <td class="indentity-image__updated-at"
        style="min-width: 125px;"> {{ \Illuminate\Support\Carbon::parse($data->created_at)->format('H:i:s') }}</td>
    <td class="indentity-image__status">
        @if ($data->user->connect_verification_session === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_PENDING)
            <div class="indentity-image__status-content approval">承認待ち</div>
        @elseif ($data->user->connect_verification_session === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_FAIL)
            <div class="indentity-image__status-content rejected">否認</div>
        @else
            <div class="indentity-image__status-content approved">承認</div>
        @endif
    </td>
    <td class="text-center">
        @if ($data->user->connect_verification_read === \App\Enums\DBConstant::CONNECT_VERIFICATION_NOT_READ)
            <form action="{{ route('portal.identity.read-connect-verification', $data->user->user_id) }}"
                  method="POST">
                @csrf
                @method('put')
                <button type="submit" class="btn button button--right">未読</button>
            </form>
        @else
            <button type="button" class="btn button button--left">既読</button>
        @endif
    </td>
    <td class="indentity-image__result">
        @if ($data->status === 1 || $data->status === 2)
            <div class="indentity-image__result-notification approved">通知済み</div>
        @endif
    </td>
    <td class="indentity-image__notification-date" style="min-width: 125px;">
        @if ($data->status === 1 || $data->status === 2)
            <div>
                {{ Carbon\Carbon::parse($data->updated_at)->format('Y-m-d') }}
            </div>
        @endif
    </td>
</tr>
