<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top">
        老板业务中心
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('boss.record.integral')}}" class="user-center-menu"><i
                    class="icon icon-integralrecord introduce color-2d9cd8"></i>积分记录</a>
        <a href="{{route('boss.withdraw.apply')}}" class="user-center-menu"><i
                    class="icon icon-integrallift color-e7154a"></i>积分提现</a>
        <a href="{{route('boss.record.withdraw')}}" class="user-center-menu"><i
                    class="icon icon-presentrecord color-ffe400"></i>提现记录</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('boss.shop.list')}}" class="user-center-menu"><i
                    class="icon icon-applicationstore color-e7154a"></i>店铺列表</a>
        <a href="{{route('boss.sale.list')}}" class="user-center-menu"><i
                    class="icon icon-shoppingguide color-601986"></i>导购列表</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('boss.selldata.list')}}" class="user-center-menu"><i class="icon icon-data color-39b7ea"></i>销售数据</a>
    </div>
@endsection