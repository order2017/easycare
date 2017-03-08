<?php
$navActive = 'goods';
?>
@extends('layouts.wechat')
@section('content')
    <div class="search-bar">
        <form action="{{route('shop.goods.list')}}">
            <div class="search-bar-logo"></div>
            <input type="text" name="keyword" class="search-bar-input" placeholder="请输入您所搜索的商品">
            <button class="search-bar-btn"><i class="icon icon-search"></i></button>
        </form>
    </div>
    <div class="tab-nav"></div>
    <ul class="goods-list">
        @foreach($list as $line)
            <li>
                <div class="goods-list-image">
                    <img src="{{$line['thumb_url']}}" alt="">
                </div>
                <div class="goods-list-info">
                    <div class="goods-list-title">{{$line['name']}}</div>
                    <div class="goods-list-integral"><b>{{$line['price']}}</b>积分</div>
                    <a class="goods-list-btn" href="{{route('goods.page',['id'=>$line['id']])}}">立即兑换</a>
                </div>
            </li>
        @endforeach
    </ul>
@endsection