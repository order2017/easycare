<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small success">
        <i class="icon icon-sure"></i>
        <b>领取佣金成功</b>
    </div>
    <div class="verify-tips">
        您已获得<span class="red">{{$baseCommission+$extendCommission}}</span>元佣金<br>
        长按二维码进入伊斯卡尔公众号<br/>
        查看到账信息
    </div>
    <div class="employee-invite-code-box">
        <img src="{{asset('/assets/images/barcode.jpg')}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection