<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <form action="{{route('order.shop')}}" method="post">
        <input type="hidden" name="goods_id" value="{{$goods['id']}}">
        {{csrf_field()}}
        <div class="order-top-box">
            <div class="order-shop-box">
                <div class="order-shop-img">
                    <img src="{{$shop['thumb_url']}}" alt="">
                </div>
                <div class="order-shop-info">
                    <div class="order-shop-title">{{$shop['name']}}</div>
                    <div class="order-shop-tips">请到店自提</div>
                    <div class="order-shop-intro">{{$shop['intro']}}</div>
                </div>
            </div>
        </div>
        @include('frontend.order-common',['goods'=>$goods])
    </form>
@endsection