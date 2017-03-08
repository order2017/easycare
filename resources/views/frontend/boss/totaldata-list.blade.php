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

    <ul class="goods-list">
        <li>
            <div class="goods-list-image">
                <img src="" alt="">
            </div>
            <div class="goods-list-info">
                <a class="goods-list-btn">15件</a>
                <div class="goods-list-title">直营产品飞车险直营产品飞车险直营产品飞车险</div>
                <div class="goods-list-integral"><b>11.00</b>积分</div>
            </div>
        </li>
    </ul>

    <ul class="goods-list">
        <li>
            <div class="goods-list-image">
                <img src="" alt="">
            </div>
            <div class="goods-list-info">
                <a class="goods-list-btn">15件</a>
                <div class="goods-list-title">直营产品飞车险直营产品飞车险直营产品飞车险</div>
                <div class="goods-list-integral"><b>11.00</b>积分</div>
            </div>
        </li>
    </ul>

    <div class="goods-detail-bar">
        <a class="goods-detail-bar-bottom" href="">积分总数:500积分</a>
        <a class="goods-detail-bar-btn" href="">销售总数:122件</a>
    </div>
@endsection