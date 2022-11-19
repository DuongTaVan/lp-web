<div class="modal fade" id="buyer-check" tabindex="-1" role="dialog" aria-labelledby="buyer-checkTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title f-w6" id="exampleModalLongTitle">購入者を選択</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('assets/img/icons/close-option.svg')}}" alt="">
                </button>
            </div>
            <div class="modal-body">
                <div class="table-option-item check-all">
                    <label class="checkbox">
                        <input type="checkbox" id="checkAll"> すべて選択
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="content-table">
                    <table class="table fs-14">
                        <thead>
                        <tr>
                            <th scope="col">購入日</th>
                            <th scope="col">時間</th>
                            <th scope="col">ニックネーム</th>
                            <th scope="col">性別</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($totalMember as $item)
                            <tr class="buyer-check">
                                <td class="check-item" data-id="{{ $item->purchase_id }}">
                                    <div class="table-option-item">
                                        <label class="checkbox">
                                            <input type="checkbox" name="roomId[]" class="buyer-check-input" value="{{ $item->roomId }}">
                                            <input type="hidden" name="userId[]" class="user-id-checked" value="{{ $item->user_id }}">
                                            {{ now()->parse($item['purchased_at'])->format('Y/m/d') }}
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>{{ now()->parse($item['purchased_at'])->format('H:i') }}</td>
                                <td class="full-name">{{ $item->full_name }}</td>
                                <td style="white-space: nowrap">{{ $item->sex_type }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer confirm d-flex justify-content-center">
                    <button class="btn fs-14 button-close" type="button" data-dismiss="modal" aria-label="戻る">戻る</button>
                    <button class="btn fs-14 button-confirm" id="submit-list-room">確認する</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let inputBuyer = $('.buyer-check-input');
        let bgInputBuyer = $('.buyer-check');
        $("#checkAll").click(function () {
            inputBuyer.prop('checked', this.checked);
            inputBuyer.prop('checked') ? bgInputBuyer.addClass('active') : bgInputBuyer.removeClass('active');
        });
        inputBuyer.on('change', function () {
            var parent = $(this).parent().parent().parent().parent();
            $(this).prop('checked') ? parent.addClass('active') : parent.removeClass('active');
            !$(this).prop('checked') ? $("#checkAll").prop('checked', false) : '';
        });
        $('#submit-list-room').click(function () {
            const arrayUId = [];
            const array = $.map($('input.buyer-check-input:checked'), function(c){
                arrayUId.push($(c).parent().find('.user-id-checked').val());
                return c.value;
            });

            if (array.length > 0) {
                $('#number-user').html(array.length);
                $('#room-ids').val(array.join());
                $('#user-ids').val(arrayUId.join());
                $('#messagePopup').modal('show');
                $('#buyer-check').modal('hide');
                $("#checkAll").prop('checked', false);
                inputBuyer.prop('checked', false);
            }
        });
        $('#buyer-check').on('hidden.bs.modal', function () {
            $("#checkAll").prop('checked', false);
            inputBuyer.prop('checked', false);
            bgInputBuyer.removeClass('active')
        })
    });
</script>

