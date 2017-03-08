<?php
view()->share('bodyClass', 'gray');
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="coupon-detail-name">{{$model['title_text']}}</div>
    <div class="coupon-detail-line"></div>
    <div class="coupon-detail-info">
        <div class="coupon-detail-text" @if($model['is_direct'] == 1) style="display: none" @endif>
            <div class="coupon-detail-text-label">适用店铺</div>
            <div class="coupon-detail-text-content">@if ($model['is_direct'] == 0) {{$model['shop_name']}} @endif</div>
        </div>
        <div class="coupon-detail-text">
            <div class="coupon-detail-text-label">适用范围</div>
            <div class="coupon-detail-text-content">{{$model['scope']}}</div>
        </div>
        <div class="coupon-detail-text">
            <div class="coupon-detail-text-label">使用条件</div>
            <div class="coupon-detail-text-content">单笔订单满{{$model['condition']}}元</div>
        </div>
        <div class="coupon-detail-text"
             @if($model['type'] !== \App\CouponApply::TYPE_DIYONGQUAN) style="display: none" @endif>
            <div class="coupon-detail-text-label">抵扣金额</div>
            <div class="coupon-detail-text-content">{{$model['money']}}</div>
        </div>
        <div class="coupon-detail-text"
             @if($model['type'] !== \App\CouponApply::TYPE_ZHEKOUQUAN) style="display: none" @endif>
            <div class="coupon-detail-text-label">折扣</div>
            <div class="coupon-detail-text-content">{{$model['discount']}}折</div>
        </div>
    </div>
    <div class="coupon-detail-base">
        <div class="coupon-detail-title">{{$model['title']}}</div>
        <div class="coupon-detail-base-info">
            <div class="coupon-detail-price"><b>{{$model['integral']}}</b>分</div>

        </div>
        <div class="coupon-detail-base-info-right" @if($model['is_direct'] == 1) style="display: none" @endif>
            <div class="coupon-detail-shop-name">@if ($model['is_direct'] == 0) {{$model['shop_name']}} @endif</div>
        </div>
    </div>
    <div class="goods-detail-content">
        <div class="tab-nav two" data-tab-switch>
            <a href="javascript:" class="active">产品详情</a>
            <div class="line"></div>
            <a href="javascript:">文字详情</a>
        </div>
        <div class="tab-content" data-tab-box>
            <div class="tab active">
                @if(!empty($model['images']))
                    @foreach($model['images'] as $image)
                        @if(!empty($image))
                            <img src="{{route('widget.images',['name'=>$image])}}">
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="tab text">
                {{$model['description']}}
            </div>
        </div>
    </div>
    <div class="goods-detail-bar">
        <a class="goods-detail-bar-shop" href="" @if ($model['is_direct'] == 0) style="display:none" @endif>
            <i class="icon icon-shop1"></i>直营</a>
        <a class="goods-detail-bar-shop" href="{{route('shop.page',['id'=>$model['shop_id']])}}"
           @if ($model['is_direct'] == 1) style="display:none" @endif>
            <i class="icon icon-shop1"></i>店铺</a>
        <a class="goods-detail-bar-star" href="{{route('coupon.collection',['id' => $model['id']])}}"><i
                    class="icon icon-star"></i>收藏</a>
        <form action="{{route('coupon.order',['id'=>$model['id']])}}" method="post" data-order-confirm data-normal
              style="display: inline-block; vertical-align: middle; height: 0.88rem; line-height: 0.88rem;">
            <button class="goods-detail-bar-btn">立即兑换</button>
        </form>
    </div>
@endsection