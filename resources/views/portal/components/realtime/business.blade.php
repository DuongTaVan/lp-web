<tr id="{{ $data->user_id }}" class="f-w3 indentity-image-list-info text-left">
    <td class="indentity-image__id">{{ $data->id }}</td>
    @php
        $query = app('request')->request->all();
        $result = array_merge(['user_id' => $data->user_id, 'link'=>'business'], $query);
    @endphp
    <td class="indentity-image__user_id">
        <a href="{{ route('portal.user.detail', $result) }}"
           class="user-link-detail">{{ $data->user_id }}</a>
    </td>
    <td class="indentity-image__teacher-category">
        {{ $data->teacher_category_text }}
    </td>
    <td class="indentity-image__name">
        <p class="mb-0">{{ $data->last_name_kanji }}{{ $data->first_name_kanji }}</p>
        <p class="mb-0">{{ $data->last_name_kana }}{{ $data->first_name_kana }}</p>
    </td>
    <td class="indentity-image__teacher-category">
        {{ $data->account_name }}
    </td>
    @if($data->image_url === null)
        <td class="indentity-image__image_url"></td>
    @else
        <td class="indentity-image__image_url text-center">
            <img data-toggle="modal" data-target="#modalImage" class="identity-image__image"
                 src="{{ $data->image_url }}" alt="">
        </td>
    @endif
    <td class="indentity-image__updated-at">{{ \Illuminate\Support\Carbon::parse($data->ip_created_at)->format('Y-m-d')  }}</td>
    <td class="indentity-image__updated-at"> {{ \Illuminate\Support\Carbon::parse($data->ip_created_at)->format('H:i:s') }}</td>
    <td class="indentity-image__status">
        @if ($data->status === 0)
            <div class="indentity-image__status-content approval">承認待ち</div>
        @elseif ($data->status === 1)
            <div class="indentity-image__status-content rejected">否認</div>
        @else
            <div class="indentity-image__status-content approved">承認</div>
        @endif
    </td>
    <td>
        @if ($data->status === 0)
            <div class="d-flex justify-content-center group-btn-action">
                <form action="{{ route('portal.business.approve-business-verification-image', $data->id) }}"
                      method="POST">
                    @csrf
                    @method('put')
                    <button type="submit"
                            {{ $data->status !== 0 ? 'disabled' : '' }} class="btn button button--left">
                        承認
                    </button>
                    <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                    <input type="hidden" name="status_user"
                           value="{{ \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED }}">
                    <input type="text" value="{{\App\Enums\DBConstant::IMAGE_PATH_STATUS['approved']}}"
                           name="status" class="d-none"/>
                </form>
                <div>
                    <button type="button"
                            {{ $data->status !== 0 ? 'disabled' : '' }} class="btn button button--right"
                            data-toggle="modal" data-target="#image{{ $data->id }}">否認
                    </button>
                </div>
                <div class="modal fade" id="image{{ $data->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="box-md-title modal--text">本当にこの資格証明書類を</p>
                                <p class="modal--text">否認してもよろしいでしょうか？</p>
                            </div>
                            <div class="modal-footer">
                                <form
                                    action="{{ route('portal.business.approve-business-verification-image', $data->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn button-confirm button-confirm--left">
                                        否認する
                                    </button>
                                    <input type="hidden" name="status_user"
                                           value="{{ \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_REJECTED }}">
                                    <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                                    <input type="text"
                                           value="{{\App\Enums\DBConstant::IMAGE_PATH_STATUS['reject']}}"
                                           name="status" class="d-none"/>
                                </form>
                                <button type="button"
                                        class="btn btn-popup button-confirm button-confirm--right"
                                        data-dismiss="modal">キャンセル
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </td>
    <td class="indentity-image__result">
        @if ($data->status === 1 || $data->status === 2)
            <div class="indentity-image__result-notification approved">通知済み</div>
        @endif
    </td>
    <td class="indentity-image__notification-date">
        @if ($data->status === 1 || $data->status === 2)
            <div>
                {{ Carbon\Carbon::parse($data->updated_at)->format('Y-m-d') }}
            </div>
        @endif
    </td>
</tr>
