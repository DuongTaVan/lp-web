<!--  Modal Message  -->
<div class="modal fade" id="messagePopup" tabindex="-1" role="dialog" aria-labelledby="messagePopupTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered notice-popup-paragraph" role="document">
        <div class="modal-content notice-popup-paragraph__content">
            <div class="notice-popup-paragraph__content__header">
                <h5 class="modal-title title_notice" id="messagePopupTitle">購入者にメッセージを送信する(<a id="number-user"></a>人)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-content notice-popup-paragraph__content__body" style="padding-bottom: 20px">
                <form action="javascript:;">
                    <input type="hidden" id="room-ids">
                    <input type="hidden" id="user-ids">
                       <textarea name="" id="content-message" cols="30" rows="10" class="content_notice"
                                 placeholder="@lang('labels.teacher-my-page.message.write_message_required')"></textarea>
                    <div id="messageNoData" style="color: #EE3D48"></div>
                    <div class="close-modal" style="margin-top: 18px;">
                        <button type="submit" id="send-message">@lang('labels.teacher-my-page.message.send_message_btn')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let courseScheduleId = {{ @json_encode($messages['data']['courseSchedule']['course_schedule_id']) }};
    let roomType = "{{ Route::currentRouteName() }}";
    console.log(roomType)
    $('#send-message').on('click', function () {
        $('#messageNoData').html('');
        let data = {
            message: $('#content-message').val(),
            roomIds: $('#room-ids').val(),
            userIds: $('#user-ids').val(),
            courseScheduleId: courseScheduleId,
            roomType: roomType === 'client.teacher.my-page.message.not-buyer' ? 2 : 1
        }
        if (data.message !== '' && data.roomIds) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                beforeSend: () => {
                    $('#loading-overlay').show();
                },
                url: '/teacher/my-page/message/send-message',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                success: function () {
                    $('#loading-overlay').hide();
                    $('#content-message').val('');
                    $('#messagePopup').modal('hide');
                    $('#messagePopupComplete').modal('show');
                    $('input.buyer-check-input').prop('checked', false);
                },
                error: function (err) {
                    $('#loading-overlay').hide();
                    $('#send-message').removeClass('btn-disabled');
                    console.log('Send Message error' + err);
                },
            });
        } else {
            $('#messageNoData').html('メッセージを記入ください');
        }
    });
</script>
@include('client.screen.teacher.my-page.message.__partials.message_popup_complete')