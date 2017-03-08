<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top">
        导购业务中心
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('sale.record.commission')}}" class="user-center-menu"><i
                    class="icon icon-commission color-2d9cd8"></i>佣金记录</a>
        <a href="{{route('sale.shop.list')}}" class="user-center-menu"><i
                    class="icon icon-applicationstore color-e7154a"></i>店铺列表</a>
    </div>
    <div class="user-center-menu-box">
        {{--<a href="{{route('sale.record.sale')}}" class="user-center-menu"><i
                    class="icon icon-salesrecords color-ff9600"></i>销售记录</a>--}}
        <a href="{{route('sale.saledata.list')}}" class="user-center-menu"><i class="icon icon-data color-39b7ea"></i>销售数据</a>
    </div>
@endsection