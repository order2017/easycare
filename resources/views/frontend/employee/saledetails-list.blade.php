<?php
view()->share('nav', false);
?>
@extends('layouts.wechat')
@section('content')
    <div class="sale-commission-filter">
        <form action="">
            <input type="date" name="beginTime" max="2016-07-01">
            -
            <input type="date" name="endTime" min="2016-06-01">
        </form>
    </div>

    {{--<div class="employee-list-search">
    </div>--}}
@foreach($list as $line)
    <ul class="tab-shops-list-box">
        <li>
            <ul class="info">
                <li>产品型号:{{ $line['product'][0]['model'] }}</li>
            </ul>
        </li>
    </ul>
@endforeach

    <div class="goods-detail-bar">
        <a class="goods-detail-bar-bottom">{{ $list[0]['shopstaff'][0]['name'] }}</a>
        <a class="goods-detail-bar-btn">销售总数:{{ $list[0]['count'] }}件</a>
    </div>

    {{--<div class="goods-detail-bar">
        <a class="goods-detail-bar-shop" href="">习近平</a>
        <a class="goods-detail-bar-star" href="">积分:500积分</a>
        <a class="goods-detail-bar-btn" href="">销售总数:102件</a>
    </div>--}}
@endsection