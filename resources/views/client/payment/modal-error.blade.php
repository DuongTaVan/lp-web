<div class="modal show gift-order" id="modal-error" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content next-step payment-success">
            <div class="title text-center title-error" id="error-message"></div>
            <div class="payment-info">
                <div class="action d-flex justify-content-center m-0">
                    <button class="confirm confirm-success m-0" data-dismiss="modal" aria-label="Close">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function () {
            let error = @json($errors->first('error'));
            if (error && error !== '') {
                $('#error-message').html(error);
                $('#modal-error').modal('show');
            }
        });
    </script>
@endsection

@section('css')
    <style>
        #modal-error .modal-dialog {
            height: 100%;
            margin-top: 0;
            justify-content: center;
            align-items: flex-start;
            padding-top: 200px;
        }

        #modal-error .modal-content {
            padding: 30px 0px;
            height: 150px;
            width: 400px;
        }

        #modal-error .title-error {
            margin: 0px;
            color: #2A3242;
            font-weight: 700;
            font-size: 16px;
        }

        #modal-error .payment-info {
            margin: 25px 0px 0px 0px;
            padding: 0;
            width: 100%;
        }

        #modal-error .confirm {
            margin-top: 35px;
            background: #46CB90;
            border: 1px solid #46CB90;
            box-sizing: border-box;
            border-radius: 5px;
            padding: 10px 0;
            text-align: center;
            color: white;
            max-width: 150px;
            width: 100%;
            height: 41px;
            font-size: 14px;
        }
    </style>
@endsection