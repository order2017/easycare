<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small success">
        <i class="icon icon-sure"></i>
        <b>感谢关注伊斯卡尔</b>
    </div>
    <div class="verify-tips">
        长按二维码关注伊斯卡尔公众号<br>获取最新的产品资讯
    </div>
    <div class="employee-invite-code-box">
        <img src="{{asset('/assets/images/barcode.jpg')}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection