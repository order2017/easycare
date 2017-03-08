<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small success">
        <i class="icon icon-sure"></i>
        <b>验证成功</b>
    </div>
    <div class="verify-tips">
        您购买的{{$barCode['product']['name']}}是正品<br>
        此二维码已被扫{{$barCode['verify_times']}}次
    </div>
    <div class="employee-invite-code-box">
        <img src="{{asset('/assets/images/barcode.jpg')}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection