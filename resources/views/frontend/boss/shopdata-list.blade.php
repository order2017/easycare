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

    <ul class="tab-shops-list-box">
        <li>
            <ul class="info">
                <li><i class="icon icon-people1"></i>习近平</li>
            </ul>
            <a class="list-btn" href="{{route('boss.shopdetails.list')}}">156件</a>
        </li>
    </ul>

    <ul class="tab-shops-list-box">
        <li>
            <ul class="info">
                <li><i class="icon icon-people1"></i>李克强</li>
            </ul>
            <a class="list-btn" href="{{route('boss.shopdetails.list')}}">156件</a>
        </li>
    </ul>

    <div class="goods-detail-bar">
        <a class="goods-detail-bar-bottom">创悦保店铺</a>
        <a class="goods-detail-bar-btn">销售总数:122件</a>
    </div>
@endsection