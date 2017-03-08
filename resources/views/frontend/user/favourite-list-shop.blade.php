<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="tab-nav two">
        <a href="{{route('user.favourites.goods')}}">收藏的商品</a>
        <div class="line"></div>
        <a href="{{route('user.favourites.shop')}}" class="active">收藏的店铺</a>
    </div>
    <div class="favourite-total">您收藏了<b>{{\App\Favorite::whereUserId(Auth::user()->id)->whereType(\App\Favorite::TYPE_SHOP)->count()}}</b>个店铺</div>
    <div class="tab-box">
        @foreach($list as $line)
            <div class="user-favourite-list">
                <a href="{{route('shop.page',['id'=>$line['shop_id']])}}">
                    <div class="user-favourite-img">
                        <img src="{{asset('/assets/images/product.png')}}" alt="">
                    </div>
                    <div class="user-favourite-info">
                        <div class="user-favourite-title">{{$line['shop_name']}}</div>
                        <div class="user-favourite-intro">
                            {{$line['intro']}}
                        </div>
                    </div>
                </a>
                <a href="{{route('shops.collection.delete',['id' => $line['id']])}}" class="user-favourite-hover-btn">取消收藏</a>
            </div>
        @endforeach
    </div>
@endsection