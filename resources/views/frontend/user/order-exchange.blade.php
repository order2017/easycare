<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="tips-box small success">
        <i class="icon icon-sure"></i>
        <b>请展示给店员扫码</b>
    </div>
    <div class="employee-invite-code-box">
        <img src="{{$code}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
@endsection