<?php
view()->share('bodyClass', 'gray');
?>
@extends('layouts.wechat')
@section('content')
    <div class="user-center-top">
        销售数据分析
    </div>
    <div class="user-center-menu-box">
        <a href="{{route('employee.totaldata.list')}}" class="user-center-menu"><i
                    class="icon icon-integralrecord introduce color-2d9cd8"></i>总体销售数据</a>
        <a href="{{route('employee.saledata.list')}}" class="user-center-menu"><i
                    class="icon icon-integrallift color-e7154a"></i>导购销售数据</a>
        <a href="{{route('employee.shopdata.list')}}" class="user-center-menu"><i
                    class="icon icon-presentrecord color-ffe400"></i>店铺销售数据</a>
    </div>
@endsection