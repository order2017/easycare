<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top member">
        <div class="user-center-top-member">
            <i class="icon icon-member"></i>
            普通会员
        </div>
    </div>
    <div class="user-center-balance">
        <a href="{{route('user.coupon.list')}}" class="user-center-balance-block">
            <div class="user-center-balance-num">0</div>
            <div class="user-center-balance-info">点券</div>
        </a>
        <div class="user-center-balance-line"></div>
        <a href="{{route('user.commission')}}" class="user-center-balance-block">
            <div class="user-center-balance-num">0</div>
            <div class="user-center-balance-info">红包</div>
        </a>
        <div class="user-center-balance-line"></div>
        <a href="{{route('user.integral')}}" class="user-center-balance-block">
            <div class="user-center-balance-num">{{Auth::user()->integral}}</div>
            <div class="user-center-balance-info">积分</div>
        </a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('user.order.list')}}" class="user-center-menu">
            <i class="icon icon-order color-46a1ff"></i>我的订单
        </a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('user.info')}}" class="user-center-menu">
            <i class="icon icon-boss color-e7338d"></i>个人中心
        </a>
        <a href="{{route('user.favourites')}}" class="user-center-menu">
            <i class="icon icon-collection color-f3da29"></i>我的收藏
        </a>
        <a href="{{route('user.comments.wait')}}" class="user-center-menu">
            <i class="icon icon-comment color-f4ad30"></i>我的评论
        </a>
        <a href="{{route('user.addresses')}}" class="user-center-menu">
            <i class="icon icon-add1 color-4ec1e5"></i>地址管理
        </a>
    </div>
    <div class="user-center-menu-box margin-bottom-20">
        <a href="{{route('user.feedback')}}" class="user-center-menu">
            <i class="icon icon-opinion color-b06aa8"></i>意见反馈
        </a>
        <a href="{{route('user.messages')}}" class="user-center-menu">
            <i class="icon icon-messagecenter color-e8424f"></i>消息通知
        </a>
    </div>
@endsection