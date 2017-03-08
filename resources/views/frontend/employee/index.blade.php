<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top">
        员工业务中心
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.invite')}}" class="user-center-menu"><i class="icon icon-link color-2d9cd8"></i>邀请链接</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.applies')}}" class="user-center-menu"><i class="icon icon-list color-2d9cd8"></i>申请列表</a>
        <a href="{{route('employee.boss.list')}}" class="user-center-menu"><i class="icon icon-boss color-e7154a"></i>老板列表</a>
        <a href="{{route('employee.sale.list')}}" class="user-center-menu"><i class="icon icon-shoppingguide color-601986"></i>导购列表</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.shop.apply')}}" class="user-center-menu"><i class="icon icon-applicationstore color-e7154a"></i>新建店铺</a>
        <a href="{{route('employee.shops.list')}}" class="user-center-menu"><i class="icon icon-shoplist color-601986"></i>店铺列表</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.goods.apply')}}" class="user-center-menu"><i class="icon icon-commodity2 color-ff9600"></i>新建商品</a>
        <a href="{{route('employee.goods.list')}}" class="user-center-menu"><i class="icon icon-commodity2 color-ff9600"></i>商品列表</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.coupon.apply')}}" class="user-center-menu"><i class="icon icon-coupon color-ff9600"></i>新建优惠券</a>
        <a href="{{route('employee.coupon.list')}}" class="user-center-menu"><i class="icon icon-coupon color-ff9600"></i>优惠劵列表</a>
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.selldata.list')}}" class="user-center-menu"><i class="icon icon-data color-39b7ea"></i>销售数据</a>
    </div>
@endsection