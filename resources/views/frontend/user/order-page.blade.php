<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <ul class="order-detail-status-box">
        <li>提交订单</li>
        <li>配送中</li>
        <li>交易完成</li>
    </ul>
    <div class="order-detail-delivery-information" style="display: none">
        <div class="order-detail-delivery-information-intro">
            <div class="order-detail-delivery-information-text">
                您的订单在发送到房间里卡缴费的卢卡缴费的卢卡斯缴费的绿卡时间的了
            </div>
            <div class="order-detail-delivery-information-time">2016-12-12 12:12:12</div>
        </div>
        <div class="order-detail-delivery-information-detail-base">
            <div>配送方式：申通快递</div>
            <div>运单号：37665387326487</div>
        </div>
        <ul class="order-detail-delivery-information-detail-list">
            @for($i=1;$i<=10;$i++)
                <li>
                    <div class="order-detail-delivery-information-detail-list-text">
                        发电量降幅略卡家的法律框架啊的离开房间啊缴费的垃圾堵塞放假啊的身份卡的身份来看啊京东方
                    </div>
                    <div class="order-detail-delivery-information-detail-list-time">2016-01-01 12:12:12</div>
                </li>
            @endfor
        </ul>
    </div>
    <div class="order-detail-base-info">
        <div>订单编号：{{$order['order_number']}}</div>
        <div>下单时间：{{$order['created_at']}}</div>
        <div>订单状态：{{$order['status_text']}}</div>
        <div>快递单号：{{$order['number']}}</div>
        <a href="{{route('user.order.list')}}" class="btn">返回</a>
        <a href="{{route('user.order.exchange',['id'=>$order['id']])}}" class="btn">立即兑换</a>
    </div>
    <div class="order-detail-goods-box">
        <div class="order-detail-shop-info">
            <div class="order-detail-shop-name">
                {{$order['shop']['name']}}
            </div>
            <div class="order-detail-shop-total">
                共计1件商品
            </div>
        </div>
        <a href="" class="order-detail-goods-info">
            <div class="order-detail-goods-image">
                <img src="{{$order['thumb_url']}}" alt="">
            </div>
            <div class="order-detail-goods-intro">
                <div class="order-detail-goods-name">{{$order['goods']['name']}}</div>
                <div class="order-detail-goods-integral">{{$order['goods']['price']}}积分</div>
            </div>
        </a>
    </div>
    <div class="order-detail-total-box">
        <div class="order-detail-goods-total">
            订单总积分：<b>{{$order['integral']}}</b>
        </div>
        <div class="order-detail-total-info">实付积分：<b>{{$order['integral']}}</b></div>
    </div>
    <div class="order-goods-logo">
        <img src="{{asset('/assets/images/logo.png')}}" alt="">
    </div>
@endsection