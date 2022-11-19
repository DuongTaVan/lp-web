@extends('client.base.base')
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="container">
                            <div class="row">
                                <div class="teacher-sidebar-right service-list-draft">
                                    <div class="sidebar-right__navbar-order-list tab-profit-livestream">
                                        <div class="sidebar-right__navbar-order-list__flex">
                                            <div class="sidebar-right__navbar-order-list__order active">
                                                @lang('labels.profit-live-stream.sales_management')
                                            </div>
                                            <div class="sidebar-right__navbar-order-list__cancel">
                                                @lang('labels.profit-live-stream.transfer_application')
                                            </div>
                                        </div>
                                        <div class="sidebar-right__navbar-order-list__year">
                                            <div class="sidebar-right__navbar-order-list__year__left"><img
                                                        src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt=""></div>
                                            <div class="sidebar-right__navbar-order-list__year__number">5月/2021年</div>
                                            <div class="sidebar-right__navbar-order-list__year__right"><img
                                                        src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="manage-sale">
                                        @lang('labels.profit-live-stream.monthly_sales_management')
                                    </div>
                                    <div class="teacher-sidebar-right__table table-profit-livestream">
                                        <table>
                                            <tr class="table-profit-livestream__pre-header videocall">
                                                <td colspan="4"></td>
                                                <td>
                                                    <div class="border-circle">1</div>
                                                </td>
                                                <td>
                                                    <div class="border-circle">2</div>
                                                </td>
                                                <td>
                                                    <div class="border-circle">3</div>
                                                </td>
                                                <td>
                                                    <img src="{{asset('assets/img/teacher-page/icon/caculate_2.svg')}}" alt="">
                                                </td>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__header">
                                                <th>@lang('labels.profit-live-stream.date')</th>
                                                <th>@lang('labels.profit-live-stream.selling_price')</th>
                                                <th>@lang('labels.profit-live-stream.delivery_time')</th>
                                                <th>@lang('labels.profit-live-stream.number_of_customers')</th>
                                                <th>@lang('labels.profit-live-stream.total_sales')</th>
                                                <th>@lang('labels.profit-live-stream.fee')</th>
                                                <th>@lang('labels.profit-live-stream.cancellation_fee')</th>
                                                <th>@lang('labels.profit-live-stream.seller_profit')</th>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td class="custom-font">4月12日</td>
                                                <td>1,000</td>
                                                <td>30</td>
                                                <td>3</td>
                                                <td>10,800</td>
                                                <td>2,700</td>
                                                <td></td>
                                                <td class="custom-font custom-last-td">10,500</td>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__data custom-td">
                                                <td class="custom-font">4月12日</td>
                                                <td>1,000</td>
                                                <td>30</td>
                                                <td></td>
                                                <td>10,800</td>
                                                <td>2,700</td>
                                                <td>450</td>
                                                <td class="custom-font custom-last-td">10,500</td>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td class="custom-font">4月12日</td>
                                                <td>1,000</td>
                                                <td>30</td>
                                                <td>3</td>
                                                <td>10,800</td>
                                                <td>2,700</td>
                                                <td></td>
                                                <td class="custom-font custom-last-td">10,500</td>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td class="custom-font">4月12日</td>
                                                <td>1,000</td>
                                                <td>30</td>
                                                <td>3</td>
                                                <td>10,800</td>
                                                <td>2,700</td>
                                                <td></td>
                                                <td class="custom-font custom-last-td">10,500</td>
                                            </tr>
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td class="custom-font">4月12日</td>
                                                <td>1,000</td>
                                                <td>30</td>
                                                <td>3</td>
                                                <td>10,800</td>
                                                <td>2,700</td>
                                                <td></td>
                                                <td class="custom-font custom-last-td">10,500</td>
                                            </tr>
                                            <tr class="table-profit-livestream__footer-table">
                                                <td colspan="6" class="footer-text">
                                                    <div>
                                                        @lang('labels.profit-live-stream.note_3')
                                                    </div>
                                                </td>
                                                <td class="custom-last-td total">合計</td>
                                                <td class="custom-font custom-last-td">79,050</td>
                                            </tr>
                                        </table>
                                    </div>
                                    @include('client.screen.teacher.my-page.paginate')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
<script>
    let radioButton = document.querySelectorAll('.button-radio');
    radioButton.forEach(el => {
        el.addEventListener ('click', ()=> {
            removeClassActive();
            el.classList.add('active-radio')
        })
    })
    function removeClassActive() {
        radioButton.forEach(el => {
            el.classList.remove('active-radio')
        })
    }
</script>
@endsection
