<!-- Modal -->
<style>
    .modal-dialog {
        max-width: 1000px;
        display: flex;
        justify-content: center;
    }
    .notice-popup-paragraph__content {
        max-width: 924px;
    }

    .notice-popup-paragraph__content__header {
        padding: 24px 13px;
    }
    .notice-popup-paragraph__content__body .content_notice {
        height: 450px;
        word-break: break-all;
    }
    .notice-popup-paragraph__content__body .close-modal button {
        padding: 15px 59px;
    }

    @media (max-width: 576px) {
        .notice-popup-paragraph__content__body .content_notice {
            height: unset;
        }
    }
</style>
<div class="modal fade" id="popupNotice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered notice-popup-paragraph" role="document">
        <div class="modal-content notice-popup-paragraph__content">
            <div class="notice-popup-paragraph__content__header">
               <div style="margin: auto; overflow-wrap: anywhere">
                   <input type="hidden" id="notice-id" value="1">
                   <h5 class="modal-title title_notice" id="exampleModalCenterTitle">配信タイトル</h5>
               </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-content notice-popup-paragraph__content__body" style="padding-bottom: 20px">
                <div class="form-control content_notice"></div>
                <div class="close-modal" data-dismiss="modal">
                    <button>@lang('labels.teacher-my-page.message.btn_close')</button>
                </div>
            </div>
        </div>
    </div>
</div>
