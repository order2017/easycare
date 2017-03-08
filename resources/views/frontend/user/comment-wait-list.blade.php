<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav two">
        <a href="{{route('user.comments.wait')}}" class="active">待评价</a>
        <div class="line"></div>
        <a href="{{route('user.comments.has')}}">已评价</a>
    </div>
    @if(empty($list))
        <div class="tab-box-none">
            暂无消息
        </div>
    @else
        <div class="tab-box">
            @foreach($list as $line)
                <div class="user-comment-list">
                    <div class="user-comment-title">
                        <a href="{{route('shop.page',['id'=>1])}}"
                           class="user-comment-shop-name">{{$line['shop']['name']}}</a>
                        <a href="{{route('user.comment',['id'=>$line['id']])}}" class="user-comment-btn">去评价</a>
                    </div>
                    <a href="{{route('user.order.page',['id'=>1])}}" class="user-comment-order">
                        <div class="user-comment-order-image">
                            <img src="{{asset('/assets/images/product.png')}}" alt="">
                        </div>
                        <div class="user-comment-order-info-box">
                            <div class="user-comment-order-goods">{{$line['goods']['name']}}</div>
                            <div class="user-comment-order-info">积分：<span class="integral">{{$line['goods']['price']}}
                                    积分</span></div>
                            <div class="user-comment-order-info">状态：<span class="status">{{$line['status_text']}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection