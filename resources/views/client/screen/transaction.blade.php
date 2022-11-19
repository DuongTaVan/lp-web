@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div id="content">
        <section class="section" id="section01">
            <div class="inner">
                <div class="inner-02">
                    <p class="ib" id="topics">
                        <span class="home">
                            <a href=""><img src="{{ asset('assets/icons/icon05.svg')}}" alt="" /></a>
                        </span>
                        <span>特定商取引法に基づく表記</span>
                    </p>
                    <h2 class="head head-A"><span class="max">Transactions</span><span class="min">特定商取引法に基づく表記</span></h2>
                    <div class="table table-A">
                        <ul class="ib unit">
                            <dt class="label">会社名</dt>
                            <dd class="item">株式会社Premier</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">サービス名</dt>
                            <dd class="item">PREwiz</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">運営責任者</dt>
                            <dd class="item">立岩 牧子</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">所在地</dt>
                            <dd class="item">〒107-0062 東京都港区南青山5-8-11 萬楽庵ビル3F</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">問い合わせ先</dt>
                            <dd class="item"><a href="">こちら</a>のフォームからご連絡下さい。</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">
                                販売価格及び<br />
                                商品毎の日数利用料金
                            </dt>
                            <dd class="item">プラン毎に異なります。<a href="">こちら</a>のページよりご確認下さい。</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">サービス代金以外の必要料金</dt>
                            <dd class="item">キズ保証料および、商品の紛失、盗難、故意または重過失による破損が起きた場合の弁償金になります。</dd>
                        </ul>
                        <ul class="ib unit">
                            <dt class="label">支払方法</dt>
                            <dd class="item">
                                クレジットカード 現金<br />
                                予約時に事前決済（Amazon Pay）か当日の現金決済でお支払いください。
                            </dd>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- E CONTENT -->

@endsection
