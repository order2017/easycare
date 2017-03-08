<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-order-search-box">
        <div class="user-order-search">
            <i class="icon icon-search"></i>
            <input type="text" placeholder="商品名称/商品编号/订单号">
        </div>
    </div>
    <div class="tab-nav">
        <a href="{{route('user.order.list',['type'=>'all'])}}" @if($type == 'all') class="active" @endif>全部订单</a>
        <div class="line"></div>
        <a href="{{route('user.order.list',['type'=>'wait'])}}" @if($type == 'wait') class="active" @endif>待兑换</a>
        <div class="line"></div>
        <a href="{{route('user.order.list',['type'=>'finish'])}}" @if($type == 'finish') class="active" @endif>已完成</a>
    </div>
    <div class="tab-box">
        @foreach($list as $line)
            <div class="user-order-list-box">
                {{--<a href="" class="user-order-list-distribution-center">--}}
                {{--<div class="user-order-list-distribution-center-info">您的订单发家史发动机卡</div>--}}
                {{--<div class="user-order-list-distribution-center-time">2016-08-12 20:12:32</div>--}}
                {{--</a>--}}
                <div class="user-order-list-title">
                    @if(empty($line['shop']['name']))
                        <a class="user-order-list-shop-name">伊斯卡尔直营</a>
                    @else
                        <a class="user-order-list-shop-name"
                           href="{{route('shop.page',['id'=>$line['shop']['id']])}}">{{$line['shop']['name']}}</a>
                    @endif
                    @if($line['status'] == \App\Order::STATUS_FINISH && $line['comment_status'] != \App\Order::COMMENTS_FINISH)
                        <a href="{{route('user.comment',['id'=>$line['id']])}}" class="user-order-list-btn">去评价</a>
                    @endif
                    @if($line['status'] == \App\Order::STATUS_FINISH)
                        <a href="{{route('goods.page',['id'=>$line['goods_id']])}}" class="user-order-list-btn">再次购买</a>
                    @endif
                    @if($line['status'] == \App\Order::STATUS_WAIT)
                        <a href="{{route('goods.page',['id'=>$line['goods_id']])}}" class="user-order-list-btn">去兑换</a>
                    @endif
                </div>
                <a href="{{route('user.order.page',['id'=>$line['id']])}}" class="user-order-list-goods">
                    <div class="user-order-list-goods-img">
                        <img src="{{$line['thumb_url']}}" alt="">
                    </div>
                    <div class="user-order-list-goods-info-box">
                        <div class="user-order-list-goods-info-title">{{$line['goods']['name']}}</div>
                        <div class="user-order-list-goods-info">积分：<span class="integral">{{$line['goods']['price']}}
                                积分</span></div>
                        <div class="user-order-list-goods-info">状态：<span class="status">{{$line['status_text']}}</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection