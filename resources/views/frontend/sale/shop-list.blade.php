<?php
view()->share('bodyClass', 'gray');
$navActive = 'user';
?>
@extends('layouts.wechat')
@section('content')
    <div class="employee-list-search">
        <form action="">
            <div class="employee-list-search-form">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="请输入店名/电话">
                <button><i class="icon icon-search"></i></button>
            </div>
        </form>
    </div>
        @foreach($list as $line)
            <div class="sale-shop-list-box">
                <div class="coupon-list-img ">
                    <img src="{{$line['thumb_url']}}" alt="">
                </div>
                <div class="sale-shop-list-info">
                    <div class="sale-shop-list-shop-name">{{$line['name']}}</div>
                    <div class="sale-shop-list-shop-intro">{{$line['intro']}}</div>
                </div>
            </div>
        @endforeach
@endsection