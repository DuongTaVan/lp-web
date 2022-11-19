<!-- Modal -->
<div class="modal fade" id="popupNoticeCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered notice-popup-paragraph" role="document">
        <div class="modal-content notice-popup-paragraph__content">
            <div class="notice-popup-paragraph__content__header">
                <h5 class="modal-title title_notice"
                >{{__('labels.teacher-my-page.message.modal.title_create')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-content notice-popup-paragraph__content__body">
                <form id="submitCreateNotice" method="post">
                    <div class="form-group message-title">
                        <input type="text" name="title"
                               placeholder="{{__('labels.teacher-my-page.message.placeholder.input_create_title')}}"
                               class="form-control" id="title">
                        <div id="errorTitle" class="text-danger mx-2"></div>
                    </div>
                    <textarea name="body" id="content" cols="30" rows="10" class="form-control content_notice"
                              placeholder="{{__('labels.teacher-my-page.message.placeholder.input_create_body')}}"
                    ></textarea>
                    <div id="errorBody" class="text-danger mx-2"></div>
                    <div class="close-modal" style="margin-top: 10px;">
                        <button id="submit">@lang('labels.teacher-my-page.message.send_message_btn')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .ck-reset {
        display: flex;
        flex-direction: column-reverse;
    }
    .ck-toolbar {
        background: #FFFFFF !important;
        border: 1px solid #ECECEC !important;
        border-bottom-right-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top: none !important;
    }

    .ck-editor__main {
        height: 364px;
        border-color: #ECECEC;
    }

    .ck-content {
        height: 100%;
        border: 1px solid #ECECEC !important;
        border-top-right-radius: 5px !important;
        border-top-left-radius: 5px !important;
        border-bottom: none !important;
        font-size: 14px;
        color: #2A3242;
    }

    .ck-editor__top {
    }

    .ck-reset li {
        list-style: unset;
        margin-left: 15px;
    }

    @media (max-width: 576px) {
        .ck-editor__main {
            height: 137px;
        }
    }
</style>
