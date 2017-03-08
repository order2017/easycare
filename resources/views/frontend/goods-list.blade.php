<?php
$navActive = 'goods';
?>
@extends('layouts.wechat')
@section('content')
    <div class="search-bar inline">
        <form action="{{route('goods.list')}}">
            <div class="search-bar-logo"></div>
            <input type="text" name="keyword" class="search-bar-input" placeholder="请输入您所搜索的商品">
            <button class="search-bar-btn"><i class="icon icon-search"></i></button>
        </form>
    </div>
    <div class="tab-nav">
        <a href="{{route('goods.list',['type'=>'all','keyword'=>Request::input('keyword')])}}" data-auto-load
           data-ajax-list @if($type == 'all') class="active" @endif>全部</a>
        <div class="line"></div>
        <a href="{{route('goods.list',['type'=>'Newest','keyword'=>Request::input('keyword')])}}" data-ajax-list @if($type == 'Newest') class="active" @endif >最新</a>
        <div class="line"></div>
        <a href="{{route('goods.list',['type'=>'Popularity','keyword'=>Request::input('keyword')])}}" data-ajax-list @if($type == 'Popularity') class="active" @endif>人气</a>
    </div>
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