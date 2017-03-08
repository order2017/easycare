<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="employee-invite-logo"></div>
    <div class="employee-invite-line"></div>
    <div class="employee-invite-text">Easy To Care For You!</div>
    <div class="employee-invite-text">让爱，更简单！</div>
    <div class="employee-invite-text">扫一扫二维码，成为我们的一员。</div>
    <div class="employee-invite-code-box">
        <img src="{{$codeSrc}}" class="employee-invite-code">
        <div class="left-top"></div>
        <div class="right-top"></div>
        <div class="left-bottom"></div>
        <div class="right-bottom"></div>
    </div>
    <button class="btn" data-toggle="share-box">分享</button>
    @include('frontend.common.share-box')
@endsection
@section('script')
    <script>
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔',
                link: '{{$url}}', // 分享链接
                imgUrl: '' // 分享图标
            });
            wx.onMenuShareAppMessage({
                title: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享标题
                desc: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享描述
                link: '{{$url}}', // 分享链接
                imgUrl: '' // 分享图标
            });
            wx.onMenuShareQQ({
                title: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享标题
                desc: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享描述
                link: '{{$url}}', // 分享链接
                imgUrl: '' // 分享图标
            });
            wx.onMenuShareWeibo({
                title: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享标题
                desc: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享描述
                link: '{{$url}}', // 分享链接
                imgUrl: '' // 分享图标
            });
            wx.onMenuShareQZone({
                title: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享标题
                desc: '{{Auth::user()->employee->name}}邀请您注册伊斯卡尔', // 分享描述
                link: '{{$url}}', // 分享链接
                imgUrl: '' // 分享图标
            });
        });
    </script>
@endsection