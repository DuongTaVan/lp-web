<table>
    <tr>
        <th class="indentity-image__id">
            <div class="d-flex justify-content-between f-w6 fields">
                画像ID
            </div>
        </th>
        <th class="indentity-image__user_id">
            <div class="d-flex justify-content-between f-w6 fields">
                ユーザーID
            </div>
        </th>
        <th class="indentity-image__teacher-category">
            <div class="d-flex justify-content-between f-w6 fields">
                カテゴリ
            </div>
        </th>
        <th class="indentity-image__name">
            <div class="d-flex justify-content-between f-w6 fields">
                氏名
            </div>
        </th>
        <th class="indentity-image__account_name">
            <div class="d-flex justify-content-between f-w6 fields">
                口座名義
            </div>
        </th>
        <th class="indentity-image__image_url">
            <div class="d-flex justify-content-between f-w6 fields">
                申請画像
            </div>
        </th>
        <th class="indentity-image__updated-at" colspan="2">
            <div class="d-flex justify-content-between f-w6 fields">
                申請日時
            </div>
        </th>
        <th class="indentity-image__status">
            <div class="d-flex justify-content-between f-w6 fields">
                ステータス
            </div>
        </th>
        <th class="indentity-image__action">
            <div class="d-flex justify-content-between f-w6 fields">
                判定確認
            </div>
        </th>
        <th class="indentity-image__result-notification">
            <div class="d-flex justify-content-between f-w6 fields">
                結果通知
            </div>
        </th>
        <th class="indentity-image__notification-date">
            <div class="d-flex justify-content-between f-w6 fields">
                通知日
            </div>
        </th>
    </tr>
    <tbody class="content-table-data">
    @if (count($data) > 0)
        @foreach($data as $key => $item)
            <tr id="{{ $item->user_id }}" class="f-w3 indentity-image-list-info text-left">
                <td class="indentity-image__id">{{ $item->id }}</td>
                @php
                    $query = app('request')->request->all();
                    $result = array_merge(['user_id' => $item->user_id, 'link' => 'identity'], $query);
                @endphp
                <td class="indentity-image__user_id">
                    <a href="{{ route('portal.user.detail', $result) }}"
                       class="user-link-detail">{{ $item->user_id }}</a>
                </td>
                <td class="indentity-image__teacher-category">
                    {{ $item->teacher_category_text }}
                    <span></span>
                </td>
                <td class="indentity-image__name">
                    <p class="mb-0">{{ $item->last_name_kanji }}{{ $item->first_name_kanji }}</p>
                    <p class="mb-0">{{ $item->last_name_kana }}{{ $item->first_name_kana }}</p>
                </td>
                <td class="indentity-image__account_name">{{ $item->account_name }}</td>
                @if($item->image_url === null)
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
                        @if(isset($item->user) && isset($item->user->imagePathAllType))
                            @foreach($item->user->imagePathAllType as $imageType)
                                <img data-toggle="modal" data-target="#modalImage" class="identity-image__image"
                                     src="{{ $imageType->image_url }}" alt="">
                            @endforeach
                        @endif
                    </td>
                @endif
                <td class="indentity-image__updated-at"
                    style="min-width: 125px;">{{ \Illuminate\Support\Carbon::parse($item->created_at)->format('Y-m-d')  }}</td>
                <td class="indentity-image__updated-at"
                    style="min-width: 125px;"> {{ \Illuminate\Support\Carbon::parse($item->created_at)->format('H:i:s') }}</td>
                <td class="indentity-image__status">
                    @if ($item->user->connect_verification_session === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_PENDING)
                        <div class="indentity-image__status-content approval">承認待ち</div>
                    @elseif ($item->user->connect_verification_session === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_FAIL)
                        <div class="indentity-image__status-content rejected">否認</div>
                    @else
                        <div class="indentity-image__status-content approved">承認</div>
                    @endif
                </td>
                <td class="text-center">
                    @if ($item->user->connect_verification_read === \App\Enums\DBConstant::CONNECT_VERIFICATION_NOT_READ)
                        <form action="{{ route('portal.identity.read-connect-verification', $item->user->user_id) }}"
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
                    @if ($item->status === 1 || $item->status === 2)
                        <div class="indentity-image__result-notification approved">通知済み</div>
                    @endif
                </td>
                <td class="indentity-image__notification-date" style="min-width: 125px;">
                    @if ($item->status === 1 || $item->status === 2)
                        <div>
                            {{ Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8" class="text-left pl-5">{{ __('labels.common.no_data_2') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="modal fade modal-image" id="modalImage" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="icon-close" aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <img class="identity-image__large" src="" alt="">
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(function () {
            setTimeout(function () {
                $('.alert').css('display', "none");
            }, 2900);
        });

        $(document).ready(function () {
            $('.identity-image__image').on("click", function (e) {
                $('.identity-image__large').attr('src', $(this).attr("src"));
            });
            $('table').on('click', 'button[type = "submit"]', function (e) {
                $(this).closest('form').submit();
                e.preventDefault();
                $(this).prop('disabled', true);
            });
        });
    </script>
@endsection
