<div class="modal" id="modalFollow" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content content-follow">
            <div class="modal-body">
                <p class="modal-head text-center f-w6">フォローリストに登録しますか？</p>
                <div class="popup-content-button d-flex justify-content-center">
                    <button class="cancel text-center"
                            data-dismiss="modal">{{ __('labels.course-detail.cancel_course') }}</button>
                    @if(isset($courseSchedule->course->user->user_id))
                        <form id="followTeacherForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $courseSchedule->course->user->user_id }}">
                            <button type="submit" class="flowUs text-center">{{ __('labels.course-detail.follow_course') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>