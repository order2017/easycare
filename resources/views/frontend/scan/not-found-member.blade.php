<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small warning">
        <i class="icon icon-warning"></i>
        <b>条码不存在</b>
    </div>
    <div class="verify-tips">温馨提示：您购买的伊斯卡尔可能是非正品，长按二维码关注伊斯卡尔公众号，选购正品。</div>
    <div class="employee-invite-code-box">
        <img src="{{asset('/assets/images/barcode.jpg')}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection