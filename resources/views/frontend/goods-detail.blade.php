<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="goods-detail-thumb">
        <img src="{{$goods['thumb_url']}}" alt="">
    </div>
    <h1 class="goods-detail-title">{{$goods['name']}}</h1>
    <div class="goods-detail-integral">
        消耗积分：<b>{{$goods['price']}}积分</b>
    </div>
    <div class="order-goods-delivery-method">
        配送方式
        <span>{{$goods['delivery_method']}}</span>
    </div>
    <div class="goods-detail-content">
        <div class="tab-nav" data-tab-switch>
            <a href="javascript:" class="active">产品详情</a>
            <div class="line"></div>
            <a href="javascript:">用户评价</a>
            <div class="line"></div>
            <a href="javascript:">文字详情</a>
        </div>
        <div class="tab-content" data-tab-box>
            <div class="tab active">
                @if(!empty($goods['images']))
                    @foreach($goods['images'] as $image)
                        <img src="{{$image}}">
                    @endforeach
                @endif
            </div>
            <div class="tab">
                <ul class="comment-list-box">
                    @foreach($comment as  $line)
                        <li>
                            <div class="comment-list-name"><i class="icon icon-member"></i>{{$line['user_name']}}</div>
                            <div class="comment-list-score">
                                @for($i=0;$i<$line['point'];$i++)
                                <i class="icon icon-star1"></i>
                                @endfor
                            </div>
                            <div class="comment-list-content">
                                {{$line['content']}}
                            </div>
                            <div class="comment-list-time">{{$line['created_at']}}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab text">
                {{$goods['description']}}
            </div>
        </div>
    </div>
    <div class="goods-detail-bar">
        <a class="goods-detail-bar-shop" href="{{route('shop.page',['id'=>$goods['shop_id']])}}"><i
                    class="icon icon-shop1"></i>店铺</a>
        <a class="goods-detail-bar-star" href="{{route('goods.collection',['id'=>$goods['id']])}}"><i
                    class="icon icon-star"></i>收藏</a>
        <a class="goods-detail-bar-btn" href="{{route('order',['id'=>$goods['id']])}}">立即兑换</a>
    </div>
@endsection
