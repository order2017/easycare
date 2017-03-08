<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
<div class="search-bar">
    <form action="{{route('goods.list')}}">
        <div class="search-bar-logo"></div>
        <input type="text" name="keyword" class="search-bar-input" placeholder="请输入您所搜索的商品">
        <button class="search-bar-btn"><i class="icon icon-search"></i></button>
    </form>
</div>
<div class="banner" id="banner-box" style="margin-top:40px;height: 150px;">
    <ul class="banner-image-list">
        @foreach($banner as $line)
            <li><a href="{{$line['link']}}"><img src="{{$line['image_url']}}" alt=""></a></li>
        @endforeach
    </ul>
    <dl class="banner-icon">
        @for($i=1;$i<=count($banner);$i++)
            <dd></dd>
        @endfor
    </dl>
</div>
<div class="index-ad-1">
    <a href="{{$ad['link']}}"><img src="{{$ad['image_url']}}" alt=""></a>
</div>
<div class="index-activity">
    <a href="{{route('coupon.list')}}">
        <div class="index-activity-text">
            <h2>领劵中心</h2>
            <small>伊斯卡尔商城积分券</small>
        </div>
        <img src="{{asset('/assets/images/index-activity-1.png')}}" alt="">
    </a>
    <a href="">
        <div class="index-activity-text">
            <h2>优惠活动</h2>
            <small>会员积分优惠</small>
        </div>
        <img src="{{asset('/assets/images/index-activity-2.png')}}" alt="">
    </a>
</div>
<div class="index-goods">
    <div class="index-goods-title">
        最近上新
        <a href="{{route('goods.list')}}">查看更多<i class="icon icon-right"></i></a>
    </div>
    <div class="index-goods-box">
        @foreach($hotGoodsList as $line)
            <a href="{{route('goods.page',['id'=>$line['id']])}}">
                <img src="{{$line['thumb_url']}}" alt="">
            </a>
        @endforeach
    </div>
</div>
<div class="index-shop">
    <div class="index-shop-title">
        热门店铺
        <a href="{{route('shop.list')}}">查看更多<i class="icon icon-right"></i></a>
    </div>
    @foreach($hotShop as $line)
        <a href="{{route('shop.page',['id'=>$line['id']])}}" class="index-shop-image">
            <img src="{{$line['thumb_url']}}" alt="">
        </a>
    @endforeach
</div>
<div class="hot-goods">
    <div class="hot-goods-title">热销排行榜</div>
    <div class="hot-goods-list">
        @foreach($hotGoodsList as $top=>$hotGoods)
            <a href="{{route('goods.page',['id'=>$hotGoods['id']])}}">
                <div class="top">
                    <div class="title">TOP</div>
                    <div class="number">{{$top+1}}</div>
                </div>
                <div class="img">
                    <img src="{{$hotGoods['thumb_url']}}"
                         alt="">
                </div>
                <div class="info">
                    <div class="name">{{$hotGoods['name']}}</div>
                    <div class="sale-number">{{$hotGoods['price']}}
                        <small>积分</small>
                    </div>
                    <div class="comment-number">
                        <span>{{$hotGoods['comment_number']}}</span>人已评论
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>