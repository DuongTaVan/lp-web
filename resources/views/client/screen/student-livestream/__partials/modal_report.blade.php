<!-- Modal -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-report-livestream" role="document">
        <div class="modal-content modal-content-report-livestream">
            <div class="modal-header modal-header-report border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="modal-header-report__close-modal-text">
                        <img src="{{asset('assets/img/icons/union.svg')}}" alt="">
                    </span>
                </button>
            </div>
            <div class="modal-body modal-body-report">
                <form id="reportTeacherForm">
                    @csrf
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-12 col-md-12 modal-body-report__title">
                                {{__('labels.users.student_live_stream.title_report')}}
                            </div>
                            <div class="col-12 col-md-12 modal-body-report__content">
                                <textarea name="content"></textarea>
                                <input type="hidden" name="name_teacher" value="{{ $fullname_teacher ?? null }}">
                                <input type="hidden" name="name_student" value="{{ auth()->guard('client')->user()->nickname }}">
                            </div>
                            <div class="col-12 col-md-12">
                                <button type="submit"
                                        class="btn modal-body-report__btn-submit">{{__('labels.users.student_live_stream.btn_send_report')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

