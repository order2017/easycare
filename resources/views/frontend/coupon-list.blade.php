<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
<div class="filter-bar">
    {{--<select name="" id="">--}}
    {{--<option value=""></option>--}}
    {{--</select>--}}
    {{--<select name="" id="">--}}
    {{--<option value="">全部</option>--}}
    {{--</select>--}}
</div>
<div class="search-bar inline">
    <form action="{{route('coupon.list')}}">
        <div class="search-bar-logo"></div>
        <input type="text" name="keyword" class="search-bar-input" placeholder="请输入您所搜索的优惠券">
        <button class="search-bar-btn"><i class="icon icon-search"></i></button>
    </form>
</div>
<div class="coupon-list-box">
    @foreach($list as $line)
        <a href="{{route('coupon.page',['id'=>$line['id']])}}">
            <div class="coupon-list-img ">
                <img src="{{$line['thumb_url']}}" alt="">
            </div>
            <div class="coupon-list-info">
                <h3>{{$line['title']}}</h3>
                <div class="coupon-list-send">到店使用 <span>{{$line['shop_city']}}</span></div>
                <div class="coupon-list-integral"><b>{{$line['integral']}}</b>分</div>
                <div class="coupon-list-shop-name">{{$line['shop_name']}}</div>
            </div>
        </a>
    @endforeach
</div>
@endsection