<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small success">
        <i class="icon icon-sure"></i>
        <b>您购买的{{$barCode['product']['name']}}是正品</b>
    </div>
    <div class="verify-tips">
        您已获得<span class="red">{{$integral+$extendIntegral}}</span>积分@if($redPacket >0 ) {{$redPacket}}元红包 @endif<br>
        长按二维码进入伊斯卡尔公众号
    </div>
    <div class="employee-invite-code-box">
        <img src="{{asset('/assets/images/barcode.jpg')}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection