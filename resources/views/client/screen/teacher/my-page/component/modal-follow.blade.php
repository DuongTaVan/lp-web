<div class="modal" id="modalFollow" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content content-follow">
            <div class="modal-body">
                <p class="modal-head text-center f-w6">フォローリストに登録しますか？</p>
                <div class="popup-content-button d-flex justify-content-center">
                    <button class="cancel text-center"
                            data-dismiss="modal">@lang('labels.course-detail.cancel_course')</button>
                    @if(isset($data['users']['user_id']))
                        <form method="POST"
                              action="{{ route('client.student.follow-teacher', ['user_id' => $data['users']['user_id']]) }}">
                            @csrf
                            <button type="submit"
                                    class="flowUs text-center">@lang('labels.course-detail.follow_course')</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>