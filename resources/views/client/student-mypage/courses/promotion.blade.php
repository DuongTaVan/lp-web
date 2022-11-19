<div class="list-services-table" id="purchased">
    @if(!empty($data['courseSchedules']) && count($data['courseSchedules']) > 0)
        <table>
            <thead>
            <tr>
                <td style="width: 135px" class="send-at-header">
                    @lang('labels.messages-course-purchase.day-receive')
                </td>
                <td class="time-at-header">
                    @lang('labels.messages-course-purchase.time-header')
                </td>
                <td style="width: 230px" class="full_name-header">
                    タイトル
                </td>
                <td class="full_name-header">
                    @lang('labels.messages-course-purchase.user_name')
                </td>
                <td>
                    @lang('labels.teacher-my-page.message.receive')
                </td>
                <td style="width: 95px" class="message-header">
                    @lang('labels.messages-course-purchase.message-header')
                </td>
            </tr>
            </thead>
            <tbody>
            @php
                $requestAll = Request::all();
                $dataPage = [
                    "sort" => $requestAll["sort"],
                    "option" => (int)$data["option"],
                    "perPage" => $requestAll["perPage"],
                    "page" => $requestAll["page"],
                ];
            @endphp
            @foreach($data['courseSchedules'] as $item)
                <tr>
                    <td class="send-at">
                        {{ isset($item['lastMessage']['createdAt']) ? formatTime($item['lastMessage']['createdAt']) : null }}
                    </td>
                    <td class="time-at">
                        {{ isset($item['lastMessage']['createdAt']) ? formatDayTime($item['lastMessage']['createdAt']) : null }}
                    </td>
                    <td class="full_name text-hidden">
                        {!! $item['lastMessage'] ? explode("<br/>", $item['lastMessage']['message'])[0] : '' !!}
                    </td>
                    <td class="full_name">
                        {{ $item['full_name'] ?? null }}
                    </td>
                    <td class="message{{ $item['messageId'] }}">
                        @if(!$item['isRead'])
                            <img src="{{ url('assets/img/common/checked.svg') }}" alt="">
                        @endif
                    </td>
                    <td class="message">
                        <a data-target="#popupNotice" class="icon-mail"
                           data-toggle="modal"
                           data-title-popup="{{ explode("<br/>", $item['lastMessage']['message'])[0] }}"
                           data-body-popup="{{ explode("<br/>", $item['lastMessage']['message'])[1] }}"
                           data-message-id="{{ $item['messageId'] }}"
                           data-room-id="{{ $item['roomId'] }}"
                           data-is-read="{{ $item['isRead'] }}"
                           href="">
                            <img src="{{ url('assets/img/common/email.svg') }}" alt="">
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('client.screen.teacher.my-page.message.__partials.notice_popup')
    @endif
</div>
@if(!empty($data['pagination']))
    @include('client.screen.teacher.my-page.message.__partials.paginate-custom',['paginate'=>$data['pagination']])
@endif
@section('css')
    <style>
        .full_name {
            word-break: break-all;
            max-width: 100px;
        }
    </style>
@endsection
@section("script")
    <script>
        $(".icon-mail").on("click", function () {
            let data = {
                title: $(this).attr('data-title-popup'),
                body: $(this).attr('data-body-popup'),
            }
            const roomId = $(this).data('room-id');
            const messageId = $(this).data('message-id');
            const isRead = $(this).data('is-read');
            if (!isRead) {
                updateIsRead(roomId, messageId, $(this));
            }
            $("#popupNotice").on('show.bs.modal', function () {
                appendDataModal(data, $(this));
            });
        })

        function appendDataModal(data, $this) {
            $this.find(".title_notice").html(data.title);
            $this.find(".content_notice").html(data.body);
        }

        function updateIsRead(roomId, messageId, element) {
            $.ajax({
                url: "/api/read_message",
                type: "POST",
                data: {
                    roomId: roomId,
                    messageId: messageId,
                },
                success: function (response) {
                    if (response.success) {
                        $(`.message${messageId}`).html('');
                        element.attr('data-is-read', 0);
                    }
                },
                error: function (err) {
                    $('#loading-overlay').hide();
                }
            });
        }
    </script>
@endsection
