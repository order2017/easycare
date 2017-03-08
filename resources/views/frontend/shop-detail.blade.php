<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="shop-image">
        <img src="{{$shop['thumb_url']}}" alt="">
    </div>
    <div class="shop-base-info">
        <h3 class="shop-base-info-name">{{$shop['name']}}</h3>
        <div class="shop-base-info-text-box">
            <div class="shop-base-info-text"><i class="icon icon-upward"></i>{{$shop['full_address']}}</div>
            <div class="shop-base-info-text"><i class="icon icon-upward"></i>{{$shop['phone']}}</div>
        </div>
    </div>

    <div class="shop-intro-info">
        <div class="shop-intro-text">
            <a href="{{route('shop.goods.list',['keyword'=>Request::input('keyword')])}}" class="cxlall"><label><i class="icon icon-star"></i>商品列表</label></a>
        </div>
    </div>

    <div class="shop-intro-info">
        <div class="shop-intro-text">
            <label><i class="icon icon-star"></i>店铺介绍</label>
            <div class="shop-intro">
                {{$shop['intro']}}
            </div>
        </div>
    </div>
    <div class="shop-images">
        <div class="shop-images-title"><i class="icon icon-add"></i>店铺图片</div>
        <div class="shop-images-list">
            @foreach($shop['image_urls'] as $image)
                <img src="{{$image}}" alt="">
            @endforeach
        </div>
    </div>
@endsection