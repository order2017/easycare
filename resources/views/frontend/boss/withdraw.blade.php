<?php
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="boss-withdraw-info">
        <i class="icon icon-sure"></i>
        <div class="boss-withdraw-info-title">我的积分</div>
        <div class="boss-withdraw-info-integral">{{$user['integral']}}</div>
        <div class="boss-withdraw-info-rate">每{{\App\Setting::integralProportion()}}积分可兑换1元</div>
    </div>
    <form method="post">
        {{csrf_field()}}
        <div class="boss-withdraw-form">
            <div class="boss-withdraw-form-title">到账微信钱包，最低1元起提</div>
            <div class="boss-withdraw-form-input">
                <label for="money">提现金额</label>
                <div class="input-group">
                    <i>￥</i>
                    <input type="number" step="0.01" name="money" id="money">
                </div>
                <div class="boss-withdraw-form-tips">
                    可兑换金额<span id="enabled-amount">{{$user['can_convert_commission']}}</span>元
                    <a id="all-integral">全部兑换</a>
                </div>
            </div>
        </div>
        <button class="btn">提现</button>
    </form>
@endsection